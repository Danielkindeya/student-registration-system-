@extends('layouts.app')

@section('content')
    <body class="bg-black text-white font-poppins antialiased h-screen flex flex-col justify-center items-center">

        <div class="container mx-auto py-12 w-full max-w-md">
            <h1 class="text-4xl font-extrabold text-gradient bg-clip-text text-transparent bg-gradient-to-r from-teal-400 to-indigo-500 mb-8 text-center">Complete Your Registration Payment</h1>

            <form id="payment-form" class="space-y-8 bg-black p-8 rounded-lg shadow-xl">
                <!-- Card Element -->
                <div>
                    <label for="card-element" class="text-lg font-medium text-gray-300">Credit or Debit Card</label>
                    <div id="card-element" class="mt-2 p-4 rounded-lg bg-gray-800 border border-gray-600">
                        <!-- A Stripe Element will be inserted here. -->
                    </div>
                    <p class="mt-2 text-sm text-gray-400">Please enter your card details below.</p>
                </div>

                <!-- Error Message -->
                <div id="error-message" class="text-red-500 mt-4 text-center"></div>

                <!-- Submit Button -->
                <button id="submit" class="w-full px-4 py-3 bg-indigo-500 text-white font-semibold rounded-lg shadow-lg hover:bg-indigo-600 transition duration-300">
                    Pay ${{ $fee }}
                </button>
                
            </form>
        </div>

        <script src="https://js.stripe.com/v3/"></script>
        <script>
            // Initialize Stripe
            var stripe = Stripe("{{ config('services.stripe.key') }}");
            var elements = stripe.elements();

            // Style customization for the Stripe Elements
            var style = {
                base: {
                    color: '#fff',
                    fontSize: '16px',
                    fontFamily: '"Inter", sans-serif',
                    fontSmoothing: 'antialiased',
                    '::placeholder': {
                        color: '#888'
                    },
                },
                invalid: {
                    color: '#e74c3c',
                    iconColor: '#e74c3c'
                }
            };

            // Create an instance of the card Element
            var card = elements.create("card", {style: style});

            // Add the card Element to the page
            card.mount("#card-element");

            // Handle form submission
            var form = document.getElementById("payment-form");
            form.addEventListener("submit", async function (event) {
                event.preventDefault();

                const {token, error} = await stripe.createToken(card);

                if (error) {
                    document.getElementById("error-message").innerText = error.message;
                } else {
                    const response = await fetch("{{ route('process.registration.payment') }}", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": "{{ csrf_token() }}",
                        },
                        body: JSON.stringify({ token: token.id })
                    });

                    const data = await response.json();

                    if (data.success) {
                        window.location.href = data.redirect_url;
                    } else {
                        document.getElementById("error-message").innerText = data.error;
                    }
                }
            });

        </script>
    </body>
@endsection
