@extends('layouts.app')

@section('content')
<body class="bg-black text-white font-poppins antialiased h-screen flex justify-center items-center">

    <div class="bg-black p-8 rounded-lg shadow-xl transform transition duration-300 hover:scale-105 w-full max-w-lg">

        <h1 class="text-4xl font-extrabold text-gradient bg-clip-text text-transparent bg-gradient-to-r from-teal-400 to-indigo-500 mb-6 text-center">Payment Receipt</h1>

        <div class="space-y-6">
            <h2 class="text-xl font-semibold text-indigo-400">Receipt Details</h2>

            <div class="grid grid-cols-1 gap-4">
                <p><strong class="text-lg">Amount Paid:</strong> ${{ number_format($receipt->amount, 2) }}</p>
                <p><strong class="text-lg">Status:</strong> {{ ucfirst($receipt->status) }}</p>
                <p><strong class="text-lg">Payment Description:</strong> {{ $receipt->description ?? 'N/A' }}</p>
                <p><strong class="text-lg">Receipt Email:</strong> {{ $receipt->receipt_email }}</p>
                <p><strong class="text-lg">Payment Intent ID:</strong> {{ $receipt->payment_intent_id }}</p>
                <p><strong class="text-lg">Date:</strong> {{ \Carbon\Carbon::parse($receipt->created_at)->format('F j, Y, g:i a') }}</p>
            </div>
        </div>

        <div class="mt-6 flex justify-center space-x-6">
            <a href="{{ route('receipt.download', $receipt->id) }}" class="px-6 py-3 bg-indigo-500 text-white font-semibold rounded-lg hover:bg-indigo-600 transition duration-300 transform hover:scale-105">
                Download PDF
            </a>
            <a href="{{ route('student.dashboard') }}" class="px-6 py-3 bg-gray-700 text-white font-semibold rounded-lg hover:bg-gray-800 transition duration-300 transform hover:scale-105">
                Go to Dashboard
            </a>
        </div>

    </div>

</body>
@endsection
