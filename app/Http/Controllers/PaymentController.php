<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Receipt;
use App\Models\RegistrationFee;
use App\Models\Course;
use App\Models\User;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use Dompdf\Dompdf;
use Dompdf\Options;


class PaymentController extends Controller
{
    // Display the registration payment page
    public function showRegistrationPaymentForm()
    {
        // Get the current registration fee
        $registrationFee = RegistrationFee::getCurrentFee();

        if (!$registrationFee) {
            return redirect()->back()->with('error', 'Registration fee not available.');
        }

        return view('payments.registration', [
            'fee' => $registrationFee->amount
        ]);
    }

    public function processRegistrationPayment(Request $request)
    {
        $request->validate([
            'token' => 'required|string',
        ]);
    
        // Get the current registration fee
        $registrationFee = RegistrationFee::getCurrentFee();
    
        if (!$registrationFee) {
            return redirect()->back()->with('error', 'Registration fee not available.');
        }
    
        // Create a new payment record in the database with status 'pending'
        $payment = Payment::create([
            'student_id' => auth()->user()->id,
            'amount' => $registrationFee->amount,
            'payment_type' => 'registration',
            'status' => 'pending',
        ]);
    
        // Set up Stripe client
        Stripe::setApiKey(env('STRIPE_SECRET'));
    
        // Create a payment intent
        try {
            $paymentIntent = PaymentIntent::create([
                'amount' => $registrationFee->amount * 100, // Convert to cents
                'currency' => 'usd',
                'description' => 'Registration Fee',
                'receipt_email' => auth()->user()->email,
                'payment_method_data' => [
                    'type' => 'card',
                    'card' => [
                        'token' => $request->token
                    ],
                ],
                'confirm' => true,
                'automatic_payment_methods' => [
                    'enabled' => true,
                    'allow_redirects' => 'never',
                ],
            ]);
    
            // After successful payment
            $payment->status = 'completed';
            $payment->payment_intent_id = $paymentIntent->id;
            $payment->save();

            $receipt = Receipt::create([
                'payment_intent_id' => $payment->payment_intent_id,
                'amount' => $payment->amount,
                'currency' => $paymentIntent->currency,
                'description' => $paymentIntent->description,
                'receipt_email' => $paymentIntent->receipt_email,
                'status' => $payment->status,
            ]);


    
            // Redirect to the receipt page
            return response()->json([
                'success' => true,
                'redirect_url' => route('receipt.show', ['paymentId' => $payment->id])
            ]);
        } catch (\Exception $e) {
            // Handle any errors and update the payment status to failed
            $payment->status = 'failed';
            $payment->save();
    
            return response()->json([
                'success' => false,
                'error' => 'Payment failed: ' . $e->getMessage()
            ]);
        }
    }
    

    // Display the course payment page
    public function showCoursePaymentForm(Course $course)
    {
        // Retrieve the fee for the course
        $courseFee = $course->courseFee;

        if (!$courseFee) {
            return redirect()->back()->with('error', 'Course fee not available.');
        }

        return view('payments.course', [
            'course' => $course,
            'fee' => $courseFee->amount
        ]);
    }

    // Process the course payment
    public function processCoursePayment(Request $request, Course $course)
    {
        $request->validate([
            'token' => 'required|string',
        ]);

        $courseFee = $course->courseFee;

        if (!$courseFee) {
            return redirect()->back()->with('error', 'Course fee not available.');
        }

        // Create a new payment record in the database with status 'pending'
        $payment = Payment::create([
            'student_id' => auth()->user()->id,
            'amount' => $courseFee->amount,
            'payment_type' => 'course_enrollment',
            'status' => 'pending',
            'course_id' => $course->id
        ]);

        // Set up Stripe client
        Stripe::setApiKey(env('STRIPE_SECRET'));

        // Create a payment intent
        try {
            $paymentIntent = PaymentIntent::create([
                'amount' => $courseFee->amount * 100, // Convert to cents
                'currency' => 'usd',
                'description' => 'Course Enrollment Fee',
                'receipt_email' => auth()->user()->email,
                'payment_method_data' => [
                    'type' => 'card',
                    'card' => [
                        'token' => $request->token
                    ],
                ],
                'confirm' => true,
                'automatic_payment_methods' => [
                    'enabled' => true,
                    'allow_redirects' => 'never',
                ],
            ]);
    
            // After successful payment
            $payment->status = 'completed';
            $payment->payment_intent_id = $paymentIntent->id;
            $payment->save();

            auth()->user()->enrollments()->create([
                'course_id' => $course->id,
                'status' => 'approved',
            ]);


            $receipt = Receipt::create([
                'payment_intent_id' => $payment->payment_intent_id,
                'amount' => $payment->amount,
                'currency' => $paymentIntent->currency,
                'description' => $paymentIntent->description,
                'receipt_email' => $paymentIntent->receipt_email,
                'status' => $payment->status,
            ]);


    
            // Redirect to the receipt page
            return response()->json([
                'success' => true,
                'redirect_url' => route('receipt.show', ['paymentId' => $payment->id])
            ]);
        } catch (\Exception $e) {
            // Handle any errors and update the payment status to failed
            $payment->status = 'failed';
            $payment->save();

            return response()->json([
                'success' => false,
                'error' => 'Payment failed: ' . $e->getMessage()
            ]);
        }
    }

    public function showReceipt($paymentId)
    {
        // Retrieve payment details using the payment ID
        $payment = Payment::findOrFail($paymentId);

        // Retrieve the receipt using the payment_intent_id
        $receipt = Receipt::where('payment_intent_id', $payment->payment_intent_id)->firstOrFail();

        return view('payments.receipt', compact('receipt'));
    }

    // Download the receipt as PDF
    public function downloadReceipt($receiptId)
    {
        $receipt = Receipt::findOrFail($receiptId);

        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);

        $dompdf = new Dompdf($options);
        $html = view('payments.receipt-template', ['receipt' => $receipt])->render();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $formattedDate = now()->format('Y-m-d-H-i-s'); // Format: YYYY-MM-DD-HH-MM-SS
        $filename = "receipt-{$formattedDate}.pdf";

        return $dompdf->stream($filename);
    }


}
