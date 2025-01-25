@extends('layouts.app')

@section('content')
    <body class="bg-black text-white font-poppins antialiased h-screen flex flex-col justify-center items-center">

        <!-- Header Section -->
        <header class="bg-black py-8 shadow-xl w-full text-center">
            <h1 class="text-4xl font-extrabold text-gradient bg-clip-text text-transparent bg-gradient-to-r from-indigo-500 via-purple-600 to-pink-500">Nexus</h1>
        </header>

        <!-- Main Section -->
        <main class="flex flex-col justify-center items-center h-full">
            <div class="container mx-auto px-8 max-w-md">
                <section class="register-form-section bg-black p-8 rounded-lg shadow-xl w-full">
                    <!-- Display error messages for any validation failures -->
                    @if ($errors->any())
                        <div class="mb-4 text-red-500">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('register') }}" method="POST" class="space-y-6">
                        @csrf  <!-- CSRF token for security -->

                        <!-- Full Name -->
                        <div class="form-group">
                            <label for="full_name" class="form-label text-lg font-medium text-gray-300">Full Name</label>
                            <input type="text" id="full_name" name="full_name" class="w-full p-3 bg-gray-700 text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="Enter your full name" value="{{ old('full_name') }}" required>
                            @error('full_name')
                                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="form-group">
                            <label for="email" class="form-label text-lg font-medium text-gray-300">Email Address</label>
                            <input type="email" id="email" name="email" class="w-full p-3 bg-gray-700 text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="Enter your email address" value="{{ old('email') }}" required>
                            @error('email')
                                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div class="form-group">
                            <label for="password" class="form-label text-lg font-medium text-gray-300">Password</label>
                            <input type="password" id="password" name="password" class="w-full p-3 bg-gray-700 text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="Choose a password" required>
                            @error('password')
                                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Password Confirmation -->
                        <div class="form-group">
                            <label for="password_confirmation" class="form-label text-lg font-medium text-gray-300">Confirm Password</label>
                            <input type="password" id="password_confirmation" name="password_confirmation" class="w-full p-3 bg-gray-700 text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="Confirm your password" required>
                            @error('password_confirmation')
                                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <button type="submit" class="w-full p-3 bg-indigo-500 text-white rounded-lg hover:bg-indigo-600 focus:outline-none focus:ring-2 focus:ring-indigo-400 transition duration-200">Register</button>
                        </div>
                    </form>

                    <div class="already-registered-link text-center mt-4">
                        <p class="text-gray-400">Already have an account? <a href="{{ route('login') }}" class="text-indigo-400 hover:text-indigo-300">Log in here</a></p>
                    </div>
                </section>
            </div>
        </main>

    </body>
@endsection
