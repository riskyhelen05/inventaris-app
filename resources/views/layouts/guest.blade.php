<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>

    <meta charset="utf-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1">

    <meta name="csrf-token"
          content="{{ csrf_token() }}">

    <title>AssetTrack</title>

    <link rel="preconnect" href="https://fonts.bunny.net">

    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap"
          rel="stylesheet" />

    @vite(['resources/css/app.css','resources/js/app.js'])

</head>

<body class="bg-gradient-to-br from-red-50 via-white to-red-100 min-h-screen">

<div class="min-h-screen flex items-center justify-center p-6">

    <div class="w-full max-w-md">

        <!-- Logo -->
        <div class="text-center mb-8">

            <a href="/">

                <img src="{{ asset('images/logo_icon.png') }}"
                     class="mx-auto h-16 w-auto mb-4"
                     alt="AssetTrack">

            </a>

            <h1 class="text-3xl font-bold text-slate-800">
                AssetTrack
            </h1>

            <p class="text-slate-500 mt-1">
                Inventory Management System
            </p>

        </div>

        <!-- Card -->
        <div class="bg-white rounded-2xl shadow-xl border border-slate-200 p-8">

            {{ $slot }}

        </div>

    </div>

</div>

</body>
</html>