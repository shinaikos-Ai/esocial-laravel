<!DOCTYPE html>
<html lang="pt-BR" class="h-full bg-gray-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo e(config('app.name', 'eSocial Extrator')); ?> — <?php echo $__env->yieldContent('title', 'Painel'); ?></title>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
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
                    <a href="<?php echo e(route('extrator.index')); ?>"
                       class="text-slate-300 hover:text-white text-sm font-medium transition <?php echo e(request()->routeIs('extrator.*') ? 'text-white' : ''); ?>">
                        Extrator
                    </a>
                    <?php if(auth()->user()->isAdmin()): ?>
                        <a href="<?php echo e(route('users.index')); ?>"
                           class="text-slate-300 hover:text-white text-sm font-medium transition <?php echo e(request()->routeIs('users.*') ? 'text-white' : ''); ?>">
                            Usuários
                        </a>
                    <?php endif; ?>
                </div>

                <div class="flex items-center gap-4">
                    <div class="text-right">
                        <div class="text-white text-sm font-medium"><?php echo e(auth()->user()->name); ?></div>
                        <?php if(auth()->user()->nr_insc): ?>
                            <div class="text-slate-400 text-xs">Empresa: <?php echo e(auth()->user()->nr_insc); ?></div>
                        <?php endif; ?>
                    </div>
                    <form method="POST" action="<?php echo e(route('logout')); ?>">
                        <?php echo csrf_field(); ?>
                        <button type="submit"
                                class="text-slate-300 hover:text-white text-sm transition">
                            Sair
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <?php if(session('success') || session('error')): ?>
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 mt-4">
            <?php if(session('success')): ?>
                <div class="rounded-md bg-green-50 border border-green-200 p-4 text-green-800 text-sm">
                    ✅ <?php echo e(session('success')); ?>

                </div>
            <?php endif; ?>
            <?php if(session('error')): ?>
                <div class="rounded-md bg-red-50 border border-red-200 p-4 text-red-800 text-sm">
                    ❌ <?php echo e(session('error')); ?>

                </div>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <main class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-8">
        <?php echo $__env->yieldContent('content'); ?>
    </main>
</div>

</body>
</html>
<?php /**PATH C:\XAMPP02\htdocs\esocial-laravel\resources\views/layouts/app.blade.php ENDPATH**/ ?>