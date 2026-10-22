<!DOCTYPE html>
<html lang="pt-BR" class="h-full bg-gray-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'eSocial Extrator') }} — @yield('title', 'Painel')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body class="h-full font-sans antialiased">

<div class="min-h-full">
    <nav class="bg-[#1B2A3B] shadow">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex h-16 items-center justify-between">
                <div class="flex items-center gap-6">
                    <span class="text-white font-semibold text-base tracking-tight">
                        eSocial Extrator
                    </span>
                    <a href="{{ route('extrator.index') }}"
                       class="text-slate-300 hover:text-white text-sm font-medium transition {{ request()->routeIs('extrator.*') ? 'text-white' : '' }}">
                        Extrator
                    </a>
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('users.index') }}"
                           class="text-slate-300 hover:text-white text-sm font-medium transition {{ request()->routeIs('users.*') ? 'text-white' : '' }}">
                            Usuários
                        </a>
                    @endif
                </div>

                <div class="flex items-center gap-4">
                    <div class="text-right">
                        <div class="text-white text-sm font-medium">{{ auth()->user()->name }}</div>
                        @if(auth()->user()->nr_insc)
                            <div class="text-slate-400 text-xs">Empresa: {{ auth()->user()->nr_insc }}</div>
                        @endif
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                                class="text-slate-300 hover:text-white text-sm transition">
                            Sair
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    @if(session('success') || session('error'))
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 mt-4">
            @if(session('success'))
                <div class="rounded-md bg-green-50 border border-green-200 p-4 text-green-800 text-sm">
                    ✅ {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="rounded-md bg-red-50 border border-red-200 p-4 text-red-800 text-sm">
                    ❌ {{ session('error') }}
                </div>
            @endif
        </div>
    @endif

    <main class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-8">
        @yield('content')
    </main>
</div>

</body>
</html>
