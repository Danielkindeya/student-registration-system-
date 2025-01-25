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
                <section class="login-form-section bg-black p-8 rounded-lg shadow-xl w-full">
                    <!-- Display error message if there are validation errors -->
                    @if ($errors->any())
                        <div class="mb-4 text-red-500">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('login') }}" method="POST" class="space-y-6">
                        @csrf  <!-- CSRF token for security -->
                        
                        <!-- Email Input -->
                        <div class="form-group">
                            <label for="email" class="form-label text-lg font-medium text-gray-300">Email</label>
                            <input 
                                type="email" 
                                id="email" 
                                name="email" 
                                class="w-full p-3 bg-gray-800 text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" 
                                placeholder="Enter your email" 
                                required 
                                value="{{ old('email') }}"
                                aria-describedby="emailHelp"
                            >
                        </div>

                        <!-- Password Input -->
                        <div class="form-group">
                            <label for="password" class="form-label text-lg font-medium text-gray-300">Password</label>
                            <input 
                                type="password" 
                                id="password" 
                                name="password" 
                                class="w-full p-3 bg-gray-800 text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" 
                                placeholder="Enter your password" 
                                required
                                aria-describedby="passwordHelp"
                            >
                        </div>

                        <!-- Submit Button -->
                        <div class="form-group">
                            <button 
                                type="submit" 
                                class="w-full p-3 bg-indigo-500 text-white rounded-lg hover:bg-indigo-600 focus:outline-none focus:ring-2 focus:ring-indigo-400 transition duration-200"
                            >
                                Login
                            </button>
                        </div>
                    </form>

                    <!-- Register Link -->
                    <div class="register-link text-center mt-4">
                        <p class="text-gray-400">Don't have an account? 
                            <a href="{{ route('register') }}" class="text-indigo-400 hover:text-indigo-300">Register here</a>
                        </p>
                    </div>
                </section>
            </div>
        </main>
    </body>
@endsection
