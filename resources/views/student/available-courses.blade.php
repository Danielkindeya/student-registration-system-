@extends('layouts.app')

@section('content')
<body class="bg-black text-white font-poppins antialiased h-screen">

    <!-- Header Section -->
    <header class="bg-black py-6 shadow-xl">
        <div class="container mx-auto flex justify-between items-center px-6">
            <div class="logo">
                <h1 class="text-3xl font-extrabold text-gradient bg-clip-text text-transparent bg-gradient-to-r from-teal-400 to-indigo-500">Available Courses</h1>
            </div>
            <nav class="nav">
                <ul class="flex space-x-6">
                    <!-- Back to Dashboard link -->
                    <li><a href="{{ route('student.dashboard') }}" class="text-lg text-gray-300 hover:text-indigo-400 transition duration-200">Back to Dashboard</a></li>
                    <li><a href="{{ route('logout') }}" class="text-lg text-gray-300 hover:text-indigo-400 transition duration-200">Logout</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <!-- Main Section -->
    <main class="py-16">
        <div class="container mx-auto px-6">

            <!-- Available Courses Section -->
            <section class="max-w-6xl mx-auto mb-16">
                <div class="bg-gray-600 p-6 rounded-lg shadow-lg">
                    <h2 class="text-2xl font-semibold text-indigo-400 mb-6">Explore Courses Available to You</h2>

                    <!-- Available Courses Table -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full table-auto text-left">
                            <thead>
                                <tr>
                                    <th class="text-indigo-400 py-3 px-6">Course Name</th>
                                    <th class="text-indigo-400 py-3 px-6">Course Code</th>
                                    <th class="text-indigo-400 py-3 px-6">Category</th>
                                    <th class="text-indigo-400 py-3 px-6">Credits</th>
                                    <th class="text-indigo-400 py-3 px-6">Description</th>
                                    <th class="text-indigo-400 py-3 px-6">Course Fee</th>
                                    <th class="text-indigo-400 py-3 px-6">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($availableCourses as $course)
                                    <tr class="border-t border-gray-700">
                                        <td class="py-3 px-6">{{ $course->name }}</td>
                                        <td class="py-3 px-6">{{ $course->code }}</td>
                                        <td class="py-3 px-6">{{ $course->category }}</td>
                                        <td class="py-3 px-6">{{ $course->credits }}</td>
                                        <td class="py-3 px-6">{{ Str::limit($course->description, 50) }}</td>
                                        <td class="py-3 px-6">
                                            @if($course->courseFee)
                                                ${{ number_format($course->courseFee->amount, 2) }}
                                            @else
                                                Not set
                                            @endif
                                        </td>
                                        <td class="py-3 px-6">
                                            <!-- Enroll Button -->
                                            <form action="{{ route('student.enroll', $course->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="bg-indigo-500 text-white px-6 py-3 rounded-lg shadow-lg hover:bg-indigo-600 transition duration-200">Enroll</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>

        </div>
    </main>

</body>
@endsection
