<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title>Sign In - RekaTrack</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="<?php echo e(asset('images/logo/logo-rekatrack.png')); ?>">

    <!-- Fonts and icons (sesuai Kaiadmin) -->
    <script src="<?php echo e(asset('assets/js/plugin/webfont/webfont.min.js')); ?>"></script>
    <script>
        WebFont.load({
            google: {
                families: ["Public Sans:300,400,500,600,700"]
            },
            custom: {
                families: [
                    "Font Awesome 5 Solid",
                    "Font Awesome 5 Regular",
                    "Font Awesome 5 Brands",
                    "simple-line-icons",
                ],
                urls: ["<?php echo e(asset('assets/css/fonts.min.css')); ?>"],
            },
            active: function() {
                sessionStorage.fonts = true;
            },
        });
    </script>

    <!-- CSS Files (Kaiadmin) -->
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/bootstrap.min.css')); ?>" />
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/plugins.min.css')); ?>" />
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/kaiadmin.min.css')); ?>" />

    <style>
        body,
        html {
            height: 100%;
            font-family: 'Public Sans', sans-serif;
        }

        .login-wrapper {
            min-height: 100vh;
            background-image: url('<?php echo e(asset('assets/img/background-login.png')); ?>');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            position: relative;
        }

        .login-wrapper::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(15, 23, 42, 0.58);
            /* overlay gelap dengan opacity */
            z-index: 1;
        }

        .login-container {
            position: relative;
            z-index: 2;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 1rem;
        }

        .login-card {
            background: #ffffff;
            border-radius: 1rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            max-width: 420px;
            width: 100%;
        }

        @media (min-width: 992px) {
            .login-card {
                padding: 2.5rem;
            }
        }

        .input-group .btn-outline-secondary {
            border-color: #dacecf !important;
            /* warna border input standar Bootstrap */
            background-color: #fff !important;
        }

        #togglePassword:hover i {
            color: #6c757d !important;
        }
    </style>
</head>

<body>
    <div class="login-wrapper">
        <div class="login-container">
            <div class="login-card p-4 p-md-5">

                <!-- Logo & Judul -->
                <div class="text-center mb-4">
                    <img src="<?php echo e(asset('images/logo/logo-rekatrack.png')); ?>" alt="RekaTrack" height="50"
                        class="mb-3">
                    <h4 class="fw-bold">Masuk ke RekaTrack</h4>
                    <p class="text-muted mb-0">Sistem Manajemen Distribusi Barang PT. Rekaindo Global Jasa.</p>
                </div>

                <!-- Flash Messages -->
                <?php if(session('success')): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <?php echo e(session('success')); ?>

                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <?php if(session('error') || $errors->any()): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?php echo e(session('error') ?: 'Email atau password salah.'); ?>

                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <!-- Form Login -->
                <form method="POST" action="<?php echo e(route('login')); ?>">
                    <?php echo csrf_field(); ?>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0">
                                <i class="fas fa-envelope text-muted"></i>
                            </span>
                            <input type="email" class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                id="email" name="email" placeholder="Masukkan email" value="<?php echo e(old('email')); ?>"
                                required autofocus>
                        </div>
                        <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="mb-4">
                        <label for="password" class="form-label">Password</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0">
                                <i class="fas fa-lock text-muted"></i>
                            </span>
                            <input type="password" class="form-control <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                id="password" name="password" placeholder="Masukkan password" required>
                            <button class="btn btn-outline-secondary border-start-0" type="button" id="togglePassword"
                                style="border-color: #ced4da !important;">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-sign-in-alt me-2"></i> Masuk
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Core JS -->
    <script src="<?php echo e(asset('assets/js/core/jquery-3.7.1.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/core/bootstrap.bundle.min.js')); ?>"></script>

    <script>
        // Toggle password visibility
        document.getElementById('togglePassword').addEventListener('click', function() {
            const password = document.getElementById('password');
            const icon = this.querySelector('i');
            if (password.type === 'password') {
                password.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                password.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });
    </script>
</body>

</html>
<?php /**PATH /home/server/Reka/current-rekatrack/current/resources/views/Auth/login.blade.php ENDPATH**/ ?>