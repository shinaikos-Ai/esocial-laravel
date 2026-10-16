<?php $__env->startSection('title', 'Novo Usuário'); ?>
<?php $__env->startSection('content'); ?>
<div class="max-w-xl">
    <div class="mb-6 flex items-center gap-3">
        <a href="<?php echo e(route('users.index')); ?>" class="text-gray-400 hover:text-gray-600 text-sm">← Voltar</a>
        <h1 class="text-2xl font-bold text-gray-800">Novo Usuário</h1>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <form method="POST" action="<?php echo e(route('users.store')); ?>" novalidate>
            <?php echo csrf_field(); ?>
            <?php echo $__env->make('users._form', ['user' => null], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            <div class="flex justify-end gap-3 mt-6">
                <a href="<?php echo e(route('users.index')); ?>" class="rounded-md border border-gray-300 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition">Cancelar</a>
                <button type="submit" class="rounded-md bg-[#2C7A3F] px-4 py-2 text-sm font-semibold text-white hover:bg-[#235e31] transition">Salvar</button>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\XAMPP02\htdocs\esocial-laravel\resources\views/users/create.blade.php ENDPATH**/ ?>