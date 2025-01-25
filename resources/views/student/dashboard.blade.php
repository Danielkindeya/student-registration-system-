@extends('layouts.app')

@section('content')
<body class="bg-black text-white font-poppins antialiased h-screen">

    <!-- Header Section -->
    <header class="bg-black py-6 shadow-xl">
        <div class="container mx-auto flex justify-between items-center px-6">
            <div class="logo">
                <h1 class="text-3xl font-extrabold text-gradient bg-clip-text text-transparent bg-gradient-to-r from-teal-400 to-indigo-500">Student Dashboard</h1>
            </div>
            <nav class="nav">
                <ul class="flex space-x-6">
                    <li><a href="{{ route('logout') }}" class="text-lg text-gray-300 hover:text-indigo-400 transition duration-200">Logout</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <!-- Main Section -->
    <main class="py-16">
        <div class="container mx-auto px-6">

            <!-- Dashboard Options Section -->
            <section class="max-w-3xl mx-auto grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 gap-12">

                <div class="bg-gray-600 p-6 rounded-lg shadow-lg hover:shadow-2xl transition duration-300 cursor-pointer transform hover:scale-105" onclick="window.location='{{ route('student.enrolled-courses') }}'">
                    <h3 class="text-2xl font-semibold text-indigo-400 mb-4">Enrolled Courses</h3>
                    <p class="text-gray-300 text-3xl font-bold">{{ $enrolledCourses->count() ?? '0' }}</p>
                </div>

                <div class="bg-gray-600 p-6 rounded-lg shadow-lg hover:shadow-2xl transition duration-300 cursor-pointer transform hover:scale-105" onclick="window.location='{{ route('student.available-courses') }}'">
                    <h3 class="text-2xl font-semibold text-indigo-400 mb-4">Available Courses</h3>
                    <p class="text-gray-300 text-3xl font-bold">{{ $availableCourses->count() ?? '0' }}</p>
                </div>

                <div class="bg-gray-600 p-6 rounded-lg shadow-lg hover:shadow-2xl transition duration-300 cursor-pointer transform hover:scale-105">
                    <h3 class="text-2xl font-semibold text-indigo-400 mb-4">Messages</h3>
                    <a href="#" class="text-lg text-gray-300 hover:text-indigo-400 transition duration-200">No New Messages</a>
                </div>

                <div class="bg-gray-600 p-6 rounded-lg shadow-lg hover:shadow-2xl transition duration-300 cursor-pointer transform hover:scale-105">
                    <h3 class="text-2xl font-semibold text-indigo-400 mb-4">Profile Settings</h3>
                    <a href="#" class="text-lg text-gray-300 hover:text-indigo-400 transition duration-200">Profile</a>
                </div>

            </section>

        </div>
    </main>

</body>
@endsection
