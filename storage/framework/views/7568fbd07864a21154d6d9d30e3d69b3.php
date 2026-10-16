<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — eSocial Extrator</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { background: #f0fdf4; }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4">

<div class="w-full max-w-md">
    
    <div class="text-center mb-8">
        <div class="inline-flex items-center justify-center w-14 h-14 rounded-full bg-[#2C7A3F] mb-3">
            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
        </div>
        <h1 class="text-2xl font-bold text-gray-800">eSocial Extrator</h1>
        <p class="text-sm text-gray-500 mt-1">Acesse com suas credenciais</p>
    </div>

    
    <div class="bg-white rounded-2xl shadow-lg p-8">
        
        <?php if(session('status')): ?>
            <div class="mb-4 rounded-md bg-green-50 border border-green-200 px-4 py-3 text-sm text-green-700">
                <?php echo e(session('status')); ?>

            </div>
        <?php endif; ?>

        <form method="POST" action="<?php echo e(route('login')); ?>" novalidate>
            <?php echo csrf_field(); ?>

            
            <div class="mb-5">
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">E-mail</label>
                <input type="email" id="email" name="email"
                       value="<?php echo e(old('email')); ?>"
                       autofocus autocomplete="username"
                       required
                       class="w-full rounded-lg border <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-400 bg-red-50 <?php else: ?> border-gray-300 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                              px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#2C7A3F]">
                <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="mt-1 text-xs text-red-600"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            
            <div class="mb-5">
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Senha</label>
                <input type="password" id="password" name="password"
                       autocomplete="current-password"
                       required
                       class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm
                              focus:outline-none focus:ring-2 focus:ring-[#2C7A3F]">
                <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="mt-1 text-xs text-red-600"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            
            <div class="flex items-center mb-6">
                <input id="remember" name="remember" type="checkbox"
                       class="h-4 w-4 rounded border-gray-300 text-[#2C7A3F] focus:ring-[#2C7A3F]">
                <label for="remember" class="ml-2 block text-sm text-gray-600">Lembrar-me</label>
            </div>

            <button type="submit"
                    class="w-full rounded-lg bg-[#2C7A3F] py-2.5 text-sm font-semibold text-white
                           hover:bg-[#235e31] focus:outline-none focus:ring-2 focus:ring-[#2C7A3F] focus:ring-offset-2
                           transition">
                Entrar
            </button>
        </form>
    </div>

    <p class="text-center text-xs text-gray-400 mt-6">
        Não tem acesso? Solicite ao administrador do sistema.
    </p>
</div>

</body>
</html>
<?php /**PATH C:\XAMPP02\htdocs\esocial-laravel\resources\views/auth/login.blade.php ENDPATH**/ ?>