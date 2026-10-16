<?php $__env->startSection('title', 'Usuários'); ?>
<?php $__env->startSection('content'); ?>
<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Usuários</h1>
    <a href="<?php echo e(route('users.create')); ?>"
       class="inline-flex items-center gap-1 rounded-md bg-[#2C7A3F] px-4 py-2 text-sm font-semibold text-white shadow hover:bg-[#235e31] transition">
        + Novo Usuário
    </a>
</div>

<form method="GET" action="<?php echo e(route('users.index')); ?>" class="mb-4 flex gap-2">
    <input type="text" name="search" value="<?php echo e(request('search')); ?>"
           placeholder="Buscar por nome, e-mail ou nrInsc..."
           class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
    <button type="submit" class="rounded-md bg-gray-800 px-4 py-2 text-sm font-medium text-white hover:bg-gray-700 transition">Buscar</button>
    <?php if(request('search')): ?>
        <a href="<?php echo e(route('users.index')); ?>" class="rounded-md border border-gray-300 px-4 py-2 text-sm text-gray-600 hover:bg-gray-50 transition">Limpar</a>
    <?php endif; ?>
</form>

<div class="overflow-hidden rounded-lg shadow ring-1 ring-black/5 bg-white">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Nome</th>
                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">E-mail</th>
                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Nº Inscrição</th>
                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Papel</th>
                <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase">Ações</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-6 py-4 text-sm font-medium text-gray-900"><?php echo e($user->name); ?></td>
                    <td class="px-6 py-4 text-sm text-gray-600"><?php echo e($user->email); ?></td>
                    <td class="px-6 py-4 text-sm text-gray-600 font-mono">
                        <?php echo e($user->nr_insc ?: '—'); ?>

                    </td>
                    <td class="px-6 py-4">
                        <span class="inline-flex rounded-full px-2.5 py-0.5 text-xs font-semibold
                            <?php echo e($user->role === 'admin' ? 'bg-red-100 text-red-700' : 'bg-blue-100 text-blue-700'); ?>">
                            <?php echo e($user->role === 'admin' ? 'Admin' : 'Operador'); ?>

                        </span>
                    </td>
                    <td class="px-6 py-4 text-right text-sm font-medium space-x-3">
                        <a href="<?php echo e(route('users.edit', $user)); ?>" class="text-yellow-600 hover:text-yellow-900">Editar</a>
                        <form method="POST" action="<?php echo e(route('users.destroy', $user)); ?>" class="inline"
                              onsubmit="return confirm('Confirma a exclusão?')">
                            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="text-red-600 hover:text-red-900">Excluir</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="5" class="px-6 py-10 text-center text-sm text-gray-400">Nenhum usuário encontrado.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<div class="mt-4"><?php echo e($users->links()); ?></div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\XAMPP02\htdocs\esocial-laravel\resources\views/users/index.blade.php ENDPATH**/ ?>