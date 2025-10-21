<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta
      name="viewport"
      content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0"
    />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title>Manajemen Unit | Rekatrack</title>
    <?php echo app('Illuminate\Foundation\Vite')('resources/css/app.css'); ?>
    <?php echo app('Illuminate\Foundation\Vite')('resources/js/app.js'); ?>
  </head>
  <body
    x-data="{ page: 'unit', loaded: true, darkMode: false, stickyMenu: false, sidebarToggle: false, scrollTop: false }"
    x-init="darkMode = JSON.parse(localStorage.getItem('darkMode'));
             $watch('darkMode', value => localStorage.setItem('darkMode', JSON.stringify(value)))"
    :class="{ 'dark bg-gray-900': darkMode === true }"
  >
    <?php echo $__env->make('partials.preloader', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <div class="flex h-screen overflow-hidden">
      <?php echo $__env->make('Template.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

      <div class="relative flex flex-col flex-1 overflow-x-hidden overflow-y-auto">
        <?php echo $__env->make('partials.overlay', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <?php echo $__env->make('Template.header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

        <main>
          <div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">
            <div x-data="{ pageName: 'Satuan Unit', subPageName: '' }">
              <?php echo $__env->make('Template.breadcrumb', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            </div>

            <!-- Tombol Tambah -->
            <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
              <a href="<?php echo e(route('units.add')); ?>"
                 class="rounded-md bg-blue-500 text-white px-3.5 py-2.5 text-sm font-semibold shadow-xs hover:bg-blue-400 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white">
                Tambah Unit
              </a>
            </div>

            <!-- Tabel -->
            <div class="overflow-hidden rounded-xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
              <div class="max-w-full overflow-x-auto">
                <table class="min-w-full">
                  <thead>
                    <tr class="border-b border-gray-100 dark:border-gray-800">
                      <th class="px-5 py-3 sm:px-6">
                        <p class="text-start font-medium text-gray-500 text-theme-xs dark:text-gray-400">No</p>
                      </th>
                      <th class="px-5 py-3 sm:px-6">
                        <p class="text-start font-medium text-gray-500 text-theme-xs dark:text-gray-400">Nama Unit</p>
                      </th>
                      <th class="px-5 py-3 sm:px-6">
                        <p class="text-start font-medium text-gray-500 text-theme-xs dark:text-gray-400">Aksi</p>
                      </th>
                    </tr>
                  </thead>
                  <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                    <?php $__currentLoopData = $units; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $unit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                      <td class="px-5 py-3 sm:px-6">
                        <p class="text-gray-500 text-theme-sm dark:text-gray-400">
                          <?php echo e($loop->iteration + ($units->currentPage() - 1) * $units->perPage()); ?>

                        </p>
                      </td>
                      <td class="px-6 py-4 sm:px-6">
                        <p class="text-gray-500 text-theme-sm dark:text-gray-400"><?php echo e($unit->name); ?></p>
                      </td>
                      <td class="px-6 py-4 sm:px-6">
                        <div class="flex space-x-2">
                          <a href="<?php echo e(route('units.edit', $unit->id)); ?>"
                             class="text-blue-600 dark:text-blue-400 hover:underline">Edit</a>
                          <form action="<?php echo e(route('units.destroy', $unit->id)); ?>" method="POST" onsubmit="return confirm('Yakin ingin menghapus unit ini?')">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button class="text-red-600 dark:text-red-400 hover:underline">Hapus</button>
                          </form>
                        </div>
                      </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  </tbody>
                </table>

                <!-- Pagination -->
                <div class="flex items-center justify-between border-t border-gray-200 bg-white px-4 py-3 sm:px-6 dark:border-gray-800 dark:bg-white/[0.03]">
                  <p class="text-sm text-gray-500 dark:text-gray-300 mb-2 sm:mb-0">
                    Menampilkan <?php echo e($units->firstItem()); ?> ke <?php echo e($units->lastItem()); ?> dari total <?php echo e($units->total()); ?> data
                  </p>
                  <div>
                    <?php echo e($units->links('pagination::tailwind')); ?>

                  </div>
                </div>
              </div>
            </div>
          </div>
        </main>
      </div>
    </div>
  </body>
</html>
<?php /**PATH /home/server/Reka/current-rekatrack/current/resources/views/General/units.blade.php ENDPATH**/ ?>