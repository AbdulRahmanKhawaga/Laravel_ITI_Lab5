<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'ITI Blog') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
<div class="min-h-screen">
    <!-- ITI Blog Navigation -->
    <nav class="bg-dark text-white p-3 d-flex justify-content-between align-items-center">
        <a href="{{ route('dashboard') }}" class="text-white text-decoration-none h4">
            {{ config('app.name', 'ITI Blog') }}
        </a>

        <div class="d-flex align-items-center">
            @auth
                <a href="{{ route('posts.index') }}" class="text-white text-decoration-none me-3">
                    All Posts
                </a>
                @if(Auth::user()->is_admin)
                <a href="{{ route('posts.trashed') }}" class="text-white text-decoration-none me-3">
                    Trashed Posts
                </a>
                @endif
                @if(Auth::user()->is_admin)
                    <a href="{{ route('admin.users.index') }}" class="text-white text-decoration-none me-3">
                        Users
                    </a>
                @endif
                <x-dropdown align="right" width="48" class="d-inline">
                    <x-slot name="trigger">
                        <button aria-label="User Menu" class="text-white text-decoration-none bg-transparent border-0">
                            {{ Auth::user()->name }}
                            <svg class="fill-current h-4 w-4 d-inline" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Logout -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                             onclick="event.preventDefault(); this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            @else
                <a href="{{ route('login') }}" class="text-white text-decoration-none me-3">Log in</a>
                <a href="{{ route('register') }}" class="text-white text-decoration-none">Register</a>
            @endauth
        </div>
    </nav>

    <!-- Page Heading (Optional) -->
    {{--
    @isset($header)
        <header class="bg-white shadow">
            <div class="container py-3">
                {{ $header }}
            </div>
        </header>
    @endisset
    --}}

    <!-- Page Content -->
    <main>
        <div class="container mt-3">
            {{ $slot }}
        </div>
    </main>
</div>

<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
