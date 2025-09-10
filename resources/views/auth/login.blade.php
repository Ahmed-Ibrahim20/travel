<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Sun & Sea Tours</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: url('https://images.unsplash.com/photo-1507525428034-b723cf961d3e?ixlib=rb-4.0.3&auto=format&fit=crop&w=1650&q=80') no-repeat center center fixed;
            background-size: cover;
        }

        .overlay {
            background: rgba(0, 0, 0, 0.55);
        }
    </style>
</head>

<body class="h-screen flex items-center justify-center">

    <div class="overlay absolute inset-0"></div>

    <div class="relative z-10 bg-white/90 backdrop-blur-md rounded-2xl shadow-2xl p-10 w-full max-w-md">
        <!-- Logo -->
        <div class="text-center mb-6">
            <img src="https://cdn-icons-png.flaticon.com/512/201/201623.png"
                alt="Sun & Sea Tours"
                class="mx-auto w-16 h-16 mb-2">
            <h1 class="text-2xl font-bold text-gray-800">Sun & Sea Tours</h1>
            <p class="text-gray-500 text-sm">Login to explore your journeys</p>
        </div>

        <!-- Session Status -->
        @if(session('status'))
        <div class="mb-4 text-green-600 text-sm text-center">
            {{ session('status') }}
        </div>
        @endif

        <!-- Login Form -->
        <form method="POST" action="{{ route('login') }}" class="space-y-5">
            @csrf
            <!-- Close Button (X) -->
            <a href="{{ url('/') }}"
                class="absolute top-1 left-5 text-gray-400 hover:text-red-500 transition" style="font-size: 30px;">
                ✕
            </a>
            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                <input type="email" name="email" id="email"
                    value="{{ old('email') }}"
                    required autofocus autocomplete="username"
                    class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-sky-400 focus:border-sky-400">
                @error('email')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                <input type="password" name="password" id="password"
                    required autocomplete="current-password"
                    class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-sky-400 focus:border-sky-400">
                @error('password')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Remember Me -->
            <div class="flex items-center">
                <input id="remember_me" type="checkbox" name="remember"
                    class="h-4 w-4 text-sky-500 border-gray-300 rounded focus:ring-sky-400">
                <label for="remember_me" class="ml-2 text-sm text-gray-600">Remember Me</label>
            </div>

            <!-- Actions -->
            <div class="flex items-center justify-between">
                @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}"
                    class="text-sm text-sky-500 hover:text-sky-700">Forgot your password?</a>
                @endif
                <button type="submit"
                    class="px-6 py-2 bg-sky-500 text-white rounded-lg shadow-md hover:bg-sky-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sky-400 transition">
                    Log In
                </button>
            </div>
        </form>

        <!-- Footer -->
        <p class="mt-6 text-center text-xs text-gray-500">
            © 2025 Sun & Sea Tours. All rights reserved.
        </p>
    </div>

</body>
</html>