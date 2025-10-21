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
                pageName: 'Manajemen Pengiriman', 
                subPageName: 'Edit Data Pengiriman'}">
              <?php echo $__env->make('Template.breadcrumb', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            </div>

            <div>
            <form method="POST" action="<?php echo e(route('shippings.update', $travelDocument->id)); ?>">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>
                <div x-data="{
                    sendTo: '<?php echo e($travelDocument->send_to); ?>',
                    numberSJN: '<?php echo e($travelDocument->no_travel_document); ?>',
                    numberRef: '<?php echo e($travelDocument->reference_number); ?>',
                    projectName: '<?php echo e($travelDocument->project); ?>',
                    poNumber: '<?php echo e($travelDocument->po_number); ?>'
                }" class="space-y-6">

                <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
                    <div class="px-5 py-4 sm:px-6 sm:py-5">
                        <h3 class="text-base font-medium text-gray-800 dark:text-white/90">
                            Data pengiriman
                        </h3>
                    </div>

                    <div class="space-y-6 border-t border-gray-100 p-5 sm:p-6 dark:border-gray-800">
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                            <!-- Column 1 -->
                            <div class="flex items-center space-x-4">
                                <label for="sendTo" class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400 w-1/3">Kepada <p class="text-red-500 inline">*</p></label>
                                <input
                                    type="text"
                                    x-model="sendTo"
                                    id="sendTo"
                                    name="sendTo"
                                    :value="sendTo"
                                    class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                                />
                            </div>

                            <!-- Column 2 -->
                            <div class="flex items-center space-x-4">
                                <label for="numberSJN" class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400 w-1/3">Nomor SJN <p class="text-red-500 inline">*</p></label>
                                <input
                                    type="text"
                                    x-model="numberSJN"
                                    id="numberSJN"
                                    name="numberSJN"
                                    class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                                />
                            </div>

                            <!-- Column 3 -->
                            <div class="flex items-center space-x-4">
                                <label for="numberRef" class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400 w-1/3">Nomor Ref <p class="text-red-500 inline">*</p></label>
                                <input
                                    type="text"
                                    x-model="numberRef"
                                    id="numberRef"
                                    name="numberRef"
                                    class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                                />
                            </div>

                            <!-- Column 4 -->
                            <div class="flex items-center space-x-4">
                                <label for="projectName" class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400 w-1/3">Proyek <p class="text-red-500 inline">*</p></label>
                                <input
                                    type="text"
                                    x-model="projectName"
                                    id="projectName"
                                    name="projectName"
                                    class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                                />
                            </div>

                            <!-- Column 5 -->
                            <div class="flex items-center space-x-4">
                                <label for="poNumber" class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400 w-1/3">Nomor PO <p class="text-red-500 inline">*</p></label>
                                <input
                                    type="text"
                                    x-model="poNumber"
                                    id="poNumber"
                                    name="poNumber"
                                    class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                                />
                            </div>
                        </div>
                    </div>
                </div>
                </div>  

                
                <!-- BAGIAN ITEM BARANG -->
                <div class="space-y-6 mt-4">
                <div x-data="{
                        totalBarang: <?php echo e(count($travelDocument->items)); ?>,
                        forms: <?php echo e(Js::from($travelDocument->items->map(function($item) {
                        return [
                            'itemName' => $item->item_name,
                            'itemCode' => $item->item_code,
                            'quantitySend' => $item->qty_send,
                            'unitType' => trim(optional($item->unit)->name ?? ''),
                            'description' => $item->description,
                            'totalSend' => $item->total_send,
                            'information' => $item->information,
                            'qtyPreOrder' => $item->qty_po
                        ];
                    }))); ?>,
                         unitOptions: <?php echo e(Js::from($units->map(fn($u) => ['id' => $u->id, 'name' => $u->name]))); ?>,
                }"
                x-init="
    console.log('unitOptions:', unitOptions);
    console.log('forms:', forms);
    ">

                    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
                        <div class="px-5 py-4 sm:px-6 sm:py-5 flex flex-inline justify-between">
                        <h3 class="text-base font-medium text-gray-800 dark:text-white/90">
                            Data barang pengiriman
                        </h3>
                        <h3 class="text-base font-medium text-gray-800 dark:text-white/90">
                            Total barang: <span x-text="totalBarang"></span>
                        </h3>
                        </div>
                  
                        <div class="space-y-6 border-t border-gray-100 p-5 sm:p-6 dark:border-gray-800">
                            <template x-for="(form, index) in forms" x-bind:key="index">
                            <div>
                                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 pb-6">
                                <!-- Column 0 -->
                                <div class="flex items-center space-x-4">
                                    <label for="itemName" class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400 w-1/3">Nama barang <p class="text-red-500 inline">*</p></label>
                                    <input
                                    type="text"
                                    x-model="form.itemName"
                                    id="itemName"
                                    name="itemName[]"
                                    class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                                    />
                                </div>

                                <!-- Column 1 -->
                                <div class="flex items-center space-x-4">
                                    <label for="itemCode" class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400 w-1/3">Kode barang <p class="text-red-500 inline">*</p></label>
                                    <input
                                    type="text"
                                    x-model="form.itemCode"
                                    id="itemCode"
                                    name="itemCode[]"
                                    class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                                    />
                                </div>

                                <!-- Column 3 -->
                                <div class="flex items-center space-x-4"> 
                                    <label for="unitType" class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400 w-1/3">Satuan <p class="text-red-500 inline">*</p></label>
                                    <select
                                    x-model="forms[index].unitType"
                                    name="unitType[]"
                                    class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                                >
                                
                                    <option value="">-- Pilih Satuan --</option>
                                    <template x-for="unit in unitOptions" :key="unit.id">
                                        <option 
                                            :value="unit.id" 
                                            x-text="unit.name" 
                                            :selected="forms[index].unitType === unit.name"
                                            >
                                        </option>
                                    </template>
                                </select>
                            </div>

                                <!-- Column 2 -->
                                <div class="flex items-center space-x-4">
                                    <label for="quantitySend" class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400 w-1/3">Qty Kirim <p class="text-red-500 inline">*</p></label>
                                    <input
                                    type="number"
                                    x-model="form.quantitySend"
                                    id="quantitySend"
                                    name="quantitySend[]"
                                    class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                                    />
                                </div>

                                    <!-- Colum 7 -->
                                    <div class="flex items-center space-x-4">
                                    <label for="qtyPreOrder" class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400 w-1/3">Qty PO <p class="text-red-500 inline">*</p></label>
                                    <input
                                    type="number"
                                    x-model="form.qtyPreOrder"
                                    id="qtyPreOrder"
                                    name="qtyPreOrder[]"
                                    class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                                    />
                                </div>

                                <!-- Column 5 -->
                                <div class="flex items-center space-x-4">
                                    <label for="totalSend" class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400 w-1/3">Total Kirim <p class="text-red-500 inline">*</p></label>
                                    <input
                                    type="number"
                                    x-model="form.totalSend"
                                    id="totalSend"
                                    name="totalSend[]"
                                    class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                                    />
                                </div>

                                <!-- Column 4 -->
                                <div class="flex items-center space-x-4">
                                    <label for="description" class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400 w-1/3">Deskripsi <p class="text-red-500 inline">*</p></label>
                                    <input
                                    type="text"
                                    x-model="form.description"
                                    id="description"
                                    name="description[]"
                                    class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-full w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                                    />
                                </div>

                                <!-- Column 6 -->
                                <div class="flex items-center space-x-4">
                                    <label for="information" class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400 w-1/3">Keterangan</label>
                                    <input
                                    type="text"
                                    x-model="form.information"
                                    id="information"
                                    name="information[]"
                                    class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-full w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                                    />
                                </div>
                                
                                <!-- <div class="flex justify-end space-x-4">
                                    <button type="button" @click="forms.splice(index, 1); totalBarang--"
                                    :class="forms.length <= 1 ? 'bg-gray-400 cursor-not-allowed' : 'bg-red-500 hover:bg-red-400'"
                                    :disabled="forms.length <= 1"
                                    class="rounded-md text-white px-3.5 py-2.5 text-sm font-semibold shadow-xs focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white">
                                    Hapus Item
                                    </button>
                                </div> -->
                                
                                </div>
                                <hr class="border-t border-gray-300 dark:border-gray-800 mt-2" />
                                
                            </div>
                            
                            </template>

                            <div class="justify-end flex space-x-4">
                                <button type="submit" class="bg-green-500 hover:bg-green-400 text-white rounded-md px-3.5 py-2.5 text-sm font-semibold shadow-xs focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white">
                                Simpan Perubahan
                                </button>
                            </div>
                        </div>
                    </div>
                  </div>
                </div>
            </form>
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
<?php /**PATH /home/server/Reka/current-rekatrack/current/resources/views/General/shippings-edit.blade.php ENDPATH**/ ?>