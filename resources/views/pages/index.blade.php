@extends('layouts.app')

@section('content')
    <body class="bg-black text-gray-100 font-poppins antialiased h-screen flex flex-col justify-center items-center">

        <!-- Header Section -->
        <header class="bg-black py-8 shadow-xl w-full text-center">
            <h1 class="text-4xl font-extrabold text-gradient bg-clip-text text-transparent bg-gradient-to-r from-indigo-500 via-purple-600 to-pink-500">Nexus</h1>
        </header>

        <!-- Main Section -->
        <div class="flex flex-col justify-center items-center h-full">
            <div class="container mx-auto px-8">
                <section class="flex justify-center mt-16">
                    <div class="card bg-gradient-to-r from-indigo-500 via-purple-600 to-pink-500 p-8 rounded-lg shadow-2xl transform transition-transform duration-300 hover:scale-105 text-center text-white">
                        <h3 class="text-2xl font-bold mb-4">Start Learning</h3>
                        <p class="text-sm mb-4">Begin your educational journey today with our wide range of courses designed for all levels of learners.</p>
                        <a href="{{ route('register') }}" class="text-lg font-semibold hover:text-indigo-100 transition duration-200">Log in to Explore</a>
                    </div>
                </section>
            </div>
        </div>

    </body>
@endsection
