<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta
      name="viewport"
      content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0"
    />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>
      Manajemen Pengguna | Rekatrack
    </title>
  </head>
    <?php echo app('Illuminate\Foundation\Vite')('resources/css/app.css'); ?>
    <?php echo app('Illuminate\Foundation\Vite')('resources/js/app.js'); ?>
  <body
    x-data="{ page: 'ecommerce', 'loaded': true, 'darkMode': false, 'stickyMenu': false, 'sidebarToggle': false, 'scrollTop': false }"
    x-init="
         darkMode = JSON.parse(localStorage.getItem('darkMode'));
         $watch('darkMode', value => localStorage.setItem('darkMode', JSON.stringify(value)))"
    :class="{'dark bg-gray-900': darkMode === true}"
  >
    <!-- ===== Preloader Start ===== -->
    <?php echo $__env->make('partials.preloader', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <!-- ===== Preloader End ===== -->

    <!-- ===== Page Wrapper Start ===== -->
    <div class="flex h-screen overflow-hidden">
      <!-- ===== Sidebar Start ===== -->
      <?php echo $__env->make('Template.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
      <!-- ===== Sidebar End ===== -->

      <!-- ===== Content Area Start ===== -->
      <div
        class="relative flex flex-col flex-1 overflow-x-hidden overflow-y-auto"
      >
        <!-- Small Device Overlay Start -->
        <?php echo $__env->make('partials.overlay', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <!-- Small Device Overlay End -->

        <!-- ===== Header Start ===== -->
        <?php echo $__env->make('Template.header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <!-- ===== Header End ===== -->

        <!-- ===== Main Content Start ===== -->
        <main>
          <div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">
          <div x-data="{ 
              pageName: 'Manajemen Pengguna', 
              subPageName: 'Edit Pengguna'}">
              <?php echo $__env->make('Template.breadcrumb', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
          </div>

            <div class="">
              <div class="space-y-6">
                <div
                  class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
                  <div class="px-5 py-4 sm:px-6 sm:py-5">
                    <h3
                      class="text-base font-medium text-gray-800 dark:text-white/90">
                      Data pengguna
                    </h3>
                  </div>
                  <div
                    class="space-y-6 border-t border-gray-100 p-5 sm:p-6 dark:border-gray-800">
                    <form method="POST" action="<?php echo e(route('users.update', $user->id)); ?>">
                      <?php echo csrf_field(); ?>
                      <?php echo method_field('PUT'); ?>
                      <!-- Elements -->
                      <div class="pb-3">
                        <label
                          class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                          Nama Lengkap
                        </label>
                        <input
                          type="text"
                          id="fullname"
                          name="fullname"
                          value="<?php echo e(old('fullname', $user->name)); ?>"
                          class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                        />
                      </div>

                      <div class="pb-3">
                        <label
                          class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                          NIP
                        </label>
                        <input
                          type="text"
                          id="nip"
                          name="nip"
                          value="<?php echo e(old('nip', $user->nip)); ?>"
                          class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                        />
                      </div>

                      <!-- Elements -->
                      <div class="pb-3">
                        <label
                          class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                          E-mail
                        </label>
                        <input
                          type="email"
                          placeholder="info@gmail.com"
                          id="email"
                          name="email"
                          value="<?php echo e(old('email', $user->email)); ?>"
                          class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                        />
                      </div>

                      <!-- Elements -->
                      <div class="pb-3">
                        <label
                          class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                          Nomor Telephone
                        </label>
                        <input
                          type="text"
                          id="telephone"
                          name="telephone"
                          value="<?php echo e(old('telephone', $user->phone_number)); ?>"
                          class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                        />
                      </div>

                      <!-- Elements -->
                      <div class="pb-3">
                        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                          Pilih Role
                        </label>
                        <div class="relative z-20 bg-transparent">
                          <select
                            id="role"
                            name="role"
                            class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 pr-11 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                          >
                            <option value="">Select Option</option>
                            <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                              <option
                                value="<?php echo e($role->id); ?>"
                                <?php echo e(old('role', $user->role_id) == $role->id ? 'selected' : ''); ?>>
                                <?php echo e($role->name); ?>

                              </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                          </select>
                        </div>
                      </div>

                      <!-- Elements -->
                       <div class="justify-end flex space-x-4">
                         <button
                           type="submit"
                           class="rounded-md bg-blue-500 text-white px-3.5 py-2.5 text-sm font-semibold shadow-xs hover:bg-blue-400 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white"
                         >
                           Edit Pengguna
                         </button>
                       </div>
                    </form>
                  </div>
                </div>
              </div>

         
            </div>
          
        </main>
        <!-- ===== Main Content End ===== -->
      </div>
      <!-- ===== Content Area End ===== -->
    </div>
    <!-- ===== Page Wrapper End ===== -->
  </body>

</html>
<?php /**PATH /home/server/Reka/current-rekatrack/current/resources/views/General/users-edit.blade.php ENDPATH**/ ?>