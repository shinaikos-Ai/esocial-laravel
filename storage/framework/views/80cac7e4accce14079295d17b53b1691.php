
<?php $editing = isset($user) && $user !== null; ?>


<div class="mb-4">
    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nome</label>
    <input type="text" id="name" name="name" value="<?php echo e(old('name', $editing ? $user->name : '')); ?>" required
           class="w-full rounded-md border <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-400 <?php else: ?> border-gray-300 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?> px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
    <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-1 text-xs text-red-600"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
</div>


<div class="mb-4">
    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">E-mail</label>
    <input type="email" id="email" name="email" value="<?php echo e(old('email', $editing ? $user->email : '')); ?>" required
           class="w-full rounded-md border <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-400 <?php else: ?> border-gray-300 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?> px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
    <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-1 text-xs text-red-600"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
</div>


<div class="mb-4">
    <label for="nr_insc" class="block text-sm font-medium text-gray-700 mb-1">
        Número de inscrição (CNPJ-raiz)
    </label>
    <input type="text" id="nr_insc" name="nr_insc"
           value="<?php echo e(old('nr_insc', $editing ? $user->nr_insc : '')); ?>"
           placeholder="Ex: 12345678 ou 12345678000195"
           maxlength="14" inputmode="numeric"
           class="w-full rounded-md border <?php $__errorArgs = ['nr_insc'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-400 <?php else: ?> border-gray-300 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?> px-3 py-2 text-sm font-mono focus:outline-none focus:ring-2 focus:ring-green-500">
    <p class="mt-1 text-xs text-gray-500">
        8 dígitos (CNPJ-raiz) ou 14 dígitos (CNPJ completo). Somente números.
        O extrator usará este valor para filtrar os XMLs da empresa.
    </p>
    <?php $__errorArgs = ['nr_insc'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-1 text-xs text-red-600"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
</div>


<div class="mb-4">
    <label for="role" class="block text-sm font-medium text-gray-700 mb-1">Papel</label>
    <select id="role" name="role"
            class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
        <option value="operador" <?php if(old('role', $editing ? $user->role : 'operador') === 'operador'): echo 'selected'; endif; ?>>Operador</option>
        <option value="admin"    <?php if(old('role', $editing ? $user->role : '') === 'admin'): echo 'selected'; endif; ?>>Administrador</option>
    </select>
</div>

<hr class="my-5 border-gray-200">
<?php if($editing): ?>
    <p class="text-xs text-gray-500 mb-4">Deixe em branco para manter a senha atual.</p>
<?php endif; ?>


<div class="mb-4">
    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">
        <?php echo e($editing ? 'Nova senha' : 'Senha'); ?>

    </label>
    <input type="password" id="password" name="password" <?php echo e($editing ? '' : 'required'); ?>

           class="w-full rounded-md border <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-400 <?php else: ?> border-gray-300 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?> px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
    <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-1 text-xs text-red-600"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
</div>


<div>
    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">
        Confirmar senha
    </label>
    <input type="password" id="password_confirmation" name="password_confirmation" <?php echo e($editing ? '' : 'required'); ?>

           class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
</div>
<?php /**PATH C:\XAMPP02\htdocs\esocial-laravel\resources\views/users/_form.blade.php ENDPATH**/ ?>