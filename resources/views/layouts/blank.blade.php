<!DOCTYPE html>
<html
    class="h-full"
    lang="{{ str_replace('_', '-', app()->getLocale()) }}"
>

<head>
    <title>{{ config('app.name') }}</title>
    @include('layouts.meta')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body
    class="flex relative min-h-full font-sans antialiased bg-white dark:bg-slate-950"
    
    x-cloak
    x-data="{
        theme: false,
        toggleTheme() {
            if (localStorage.theme === 'dark') {
                localStorage.setItem('theme', 'light')
                document.documentElement.classList.remove('dark');
            } else {
                localStorage.setItem('theme', 'dark')
                document.documentElement.classList.add('dark');
            }
        },
        checkTheme() {
            if (localStorage.theme === 'dark') {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        }
    }"
    x-init="
    theme = localStorage.getItem('theme');
    checkTheme();
    $watch('theme', () => toggleTheme());"
>
    
    
    <main class="w-full h-full">
        
        @if( !app()->environment('production'))
            <div class="p-2 m-1 w-screen text-center bg-green-600 text-[10px]">
                <p class="font-bold text-white whitespace-nowrap">This is the training environment</p>
            </div>
        @endif
        
        
        <div class="relative py-10 px-4 lg:px-20 prose">
            {{ $slot }}
        </div>
    
    </main>
    
    @livewireScripts
</body>

</html>
