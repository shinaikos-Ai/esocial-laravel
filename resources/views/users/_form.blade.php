{{-- Partial compartilhado por create e edit --}}
@php $editing = isset($user) && $user !== null; @endphp

{{-- Nome --}}
<div class="mb-4">
    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nome</label>
    <input type="text" id="name" name="name" value="{{ old('name', $editing ? $user->name : '') }}" required
           class="w-full rounded-md border @error('name') border-red-400 @else border-gray-300 @enderror px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
    @error('name') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
</div>

{{-- E-mail --}}
<div class="mb-4">
    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">E-mail</label>
    <input type="email" id="email" name="email" value="{{ old('email', $editing ? $user->email : '') }}" required
           class="w-full rounded-md border @error('email') border-red-400 @else border-gray-300 @enderror px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
    @error('email') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
</div>

{{-- Número de inscrição (nrInsc / CNPJ-raiz) --}}
<div class="mb-4">
    <label for="nr_insc" class="block text-sm font-medium text-gray-700 mb-1">
        Número de inscrição (CNPJ-raiz)
    </label>
    <input type="text" id="nr_insc" name="nr_insc"
           value="{{ old('nr_insc', $editing ? $user->nr_insc : '') }}"
           placeholder="Ex: 12345678 ou 12345678000195"
           maxlength="14" inputmode="numeric"
           class="w-full rounded-md border @error('nr_insc') border-red-400 @else border-gray-300 @enderror px-3 py-2 text-sm font-mono focus:outline-none focus:ring-2 focus:ring-green-500">
    <p class="mt-1 text-xs text-gray-500">
        8 dígitos (CNPJ-raiz) ou 14 dígitos (CNPJ completo). Somente números.
        O extrator usará este valor para filtrar os XMLs da empresa.
    </p>
    @error('nr_insc') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
</div>

{{-- Papel --}}
<div class="mb-4">
    <label for="role" class="block text-sm font-medium text-gray-700 mb-1">Papel</label>
    <select id="role" name="role"
            class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
        <option value="operador" @selected(old('role', $editing ? $user->role : 'operador') === 'operador')>Operador</option>
        <option value="admin"    @selected(old('role', $editing ? $user->role : '') === 'admin')>Administrador</option>
    </select>
</div>

<hr class="my-5 border-gray-200">
@if($editing)
    <p class="text-xs text-gray-500 mb-4">Deixe em branco para manter a senha atual.</p>
@endif

{{-- Senha --}}
<div class="mb-4">
    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">
        {{ $editing ? 'Nova senha' : 'Senha' }}
    </label>
    <input type="password" id="password" name="password" {{ $editing ? '' : 'required' }}
           class="w-full rounded-md border @error('password') border-red-400 @else border-gray-300 @enderror px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
    @error('password') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
</div>

{{-- Confirmar senha --}}
<div>
    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">
        Confirmar senha
    </label>
    <input type="password" id="password_confirmation" name="password_confirmation" {{ $editing ? '' : 'required' }}
           class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
</div>
