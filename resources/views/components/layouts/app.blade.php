<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="corporate" >
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>
        {{ (isset($title) ? $title . ' | ' : (View::hasSection('title') ? View::getSection('title') . ' | ' : '')) . config('app.name') }}
    </title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen font-sans antialiased bg-base-200/50 dark:bg-base-200">

    {{-- NAVBAR mobile only --}}
    <livewire:navigation.navbar />

    {{-- MAIN --}}
    <x-main full-width>

        {{-- SIDEBAR --}}
        <x-slot:sidebar drawer="main-drawer" collapsible class="bg-base-100 lg:bg-inherit lg:hidden">
            <livewire:navigation.sidebar />
        </x-slot:sidebar>

        {{-- SLOT --}}
        <x-slot:content>
            {{ $slot }}
        </x-slot:content>

    </x-main>

    {{-- FOOTER --}}
    <hr><br>
    <livewire:navigation.footer />
    <br>

    {{--  TOAST area --}}
    <x-toast />
</body>
</html>
