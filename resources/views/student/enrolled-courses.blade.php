@extends('layouts.app')

@section('content')
<body class="bg-black text-white font-poppins antialiased h-screen">

    <!-- Header Section -->
    <header class="bg-black py-6 shadow-xl">
        <div class="container mx-auto flex justify-between items-center px-6">
            <div class="logo">
                <h1 class="text-3xl font-extrabold text-gradient bg-clip-text text-transparent bg-gradient-to-r from-teal-400 to-indigo-500">Your Enrolled Courses</h1>
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

            <!-- Enrolled Courses Section -->
            <section class="max-w-6xl mx-auto mb-16">
                <div class="bg-gray-600 p-6 rounded-lg shadow-lg">
                    <h2 class="text-2xl font-semibold text-indigo-400 mb-6">Courses You Are Enrolled In</h2>

                    <!-- Courses Table -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full table-auto text-left">
                            <thead>
                                <tr>
                                    <th class="text-indigo-400 py-3 px-6">Course Name</th>
                                    <th class="text-indigo-400 py-3 px-6">Course Code</th>
                                    <th class="text-indigo-400 py-3 px-6">Category</th>
                                    <th class="text-indigo-400 py-3 px-6">Credits</th>
                                    <th class="text-indigo-400 py-3 px-6">Description</th>
                                    <th class="text-indigo-400 py-3 px-6">Grade</th>
                                    <th class="text-indigo-400 py-3 px-6">Completion</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($enrolledCourses as $enrollment)
                                    <tr class="border-t border-gray-700">
                                        <td class="py-3 px-6">{{ $enrollment->course->name }}</td>
                                        <td class="py-3 px-6">{{ $enrollment->course->code }}</td>
                                        <td class="py-3 px-6">{{ $enrollment->course->category }}</td>
                                        <td class="py-3 px-6">{{ $enrollment->course->credits }}</td>
                                        <td class="py-3 px-6">{{ Str::limit($enrollment->course->description, 50) }}</td>
                                        <td class="py-3 px-6">
                                            @if($enrollment->getAverageGradeForStudent() !== null)
                                                {{ number_format($enrollment->getAverageGradeForStudent(), 2) }}%
                                            @else
                                                No grade available
                                            @endif
                                        </td>
                                        <td class="py-3 px-6">
                                            @if($enrollment->getCompletionPercentageForStudent() !== null)
                                                {{ number_format($enrollment->getCompletionPercentageForStudent(), 2) }}%
                                            @else
                                                Not completed
                                            @endif
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
