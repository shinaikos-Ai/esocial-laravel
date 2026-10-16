@extends('layouts.app')
@section('title', 'Editar Usuário')
@section('content')
<div class="max-w-xl">
    <div class="mb-6 flex items-center gap-3">
        <a href="{{ route('users.index') }}" class="text-gray-400 hover:text-gray-600 text-sm">← Voltar</a>
        <h1 class="text-2xl font-bold text-gray-800">Editar: {{ $user->name }}</h1>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <form method="POST" action="{{ route('users.update', $user) }}" novalidate>
            @csrf @method('PUT')
            @include('users._form', ['user' => $user])
            <div class="flex justify-end gap-3 mt-6">
                <a href="{{ route('users.index') }}" class="rounded-md border border-gray-300 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition">Cancelar</a>
                <button type="submit" class="rounded-md bg-[#2C7A3F] px-4 py-2 text-sm font-semibold text-white hover:bg-[#235e31] transition">Atualizar</button>
            </div>
        </form>
    </div>
</div>
@endsection
