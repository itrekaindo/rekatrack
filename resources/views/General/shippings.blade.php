<!doctype html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta
      name="viewport"
      content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0"
    />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Manajemen Pengiriman | Rekatrack</title>
  </head>
  @vite('resources/css/app.css')
  @vite('resources/js/app.js')
  <body
    x-data="{
      page: 'ecommerce',
      loaded: true,
      darkMode: false,
      stickyMenu: false,
      sidebarToggle: false,
      scrollTop: false,
      showExportModal: false
    }"
    x-init="
      darkMode = JSON.parse(localStorage.getItem('darkMode'));
      $watch('darkMode', value => localStorage.setItem('darkMode', JSON.stringify(value)))
    "
    :class="{'dark bg-gray-900': darkMode === true}"
  >
    <!-- ===== Preloader Start ===== -->
    @include('partials.preloader')
    <!-- ===== Preloader End ===== -->

    <!-- ===== Page Wrapper Start ===== -->
    <div class="flex h-screen overflow-hidden">
      <!-- ===== Sidebar Start ===== -->
      @include('Template.sidebar')
      <!-- ===== Sidebar End ===== -->

      <!-- ===== Content Area Start ===== -->
      <div class="relative flex flex-col flex-1 overflow-x-hidden overflow-y-auto">
        <!-- Small Device Overlay Start -->
        @include('partials.overlay')
        <!-- Small Device Overlay End -->

        <!-- ===== Header Start ===== -->
        @include('Template.header')
        <!-- ===== Header End ===== -->

        <!-- ===== Main Content Start ===== -->
        <main>
          <div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">
            <div x-data="{ pageName: `Manajemen Pengiriman`, subPageName: '' }">
              @include('Template.breadcrumb')
            </div>

            <!-- Search + Export Controls -->
            <div class="flex flex-wrap items-center justify-between gap-3 mt-4">
              <!-- Left Group: Tambah & Export -->
              <div class="flex flex-wrap items-center gap-3">
                <!-- Tambah Pengiriman -->
                <a href="{{ route('shippings.add') }}" class="rounded-md bg-blue-500 text-white px-3.5 py-2.5 text-sm font-semibold shadow-xs hover:bg-blue-400 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white">
                  Tambah Pengiriman
                </a>

                <!-- Export Button with Icon -->
                <button
                  type="button"
                  @click="showExportModal = true"
                  class="flex items-center gap-2 rounded-md bg-green-600 text-white px-3.5 py-2.5 text-sm font-semibold shadow-xs hover:bg-green-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-green-600"
                  aria-label="Export Excel"
                >
                  <img src="{{ asset('images/icons/export.svg') }}" alt="Export" class="h-4 w-4" /></button>
              </div>

              <!-- Right: Search -->
              <div x-data="searchDocumentComponent()" class="relative w-64 flex-shrink-0">
                <input
                  type="text"
                  placeholder="Cari..."
                  id="search"
                  name="search"
                  x-model="query"
                  @keydown.enter.prevent="search()"
                  class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 pr-11 pl-4 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                />
                <button
                  @click="search()"
                  class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 w-5 h-5"
                  aria-label="Search"
                  type="button"
                >
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.5"
                    stroke="currentColor"
                    class="w-5 h-5"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z"
                    />
                  </svg>
                </button>
              </div>
            </div>

            <!-- Table -->
            <div class="overflow-hidden rounded-xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03] px-4 sm:px-6 mx-4 mt-4">
              <div class="max-w-full overflow-x-auto">
                <table class="min-w-full">
                  <thead>
                    <tr class="border-b border-gray-100 dark:border-gray-800">
                      <th class="px-5 py-3 sm:px-6">
                        <div class="flex items-center">
                          <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">No</p>
                        </div>
                      </th>
                      <th class="px-5 py-3 sm:px-6">
                        <div class="flex items-center">
                          <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Nomor SJN</p>
                        </div>
                      </th>
                      <th class="px-5 py-3 sm:px-6">
                        <div class="flex items-center">
                          <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Tanggal</p>
                        </div>
                      </th>
                      <th class="px-5 py-3 sm:px-6">
                        <div class="flex items-center">
                          <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Kepada</p>
                        </div>
                      </th>
                      <th class="px-5 py-3 sm:px-6">
                        <div class="flex items-center">
                          <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Proyek</p>
                        </div>
                      </th>
                      <th class="px-5 py-3 sm:px-6">
                        <div class="flex items-center">
                          <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Status</p>
                        </div>
                      </th>
                      <th class="px-5 py-3 sm:px-6">
                        <div class="flex items-center">
                          <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Aksi</p>
                        </div>
                      </th>
                    </tr>
                  </thead>
                  <tbody id="shipping-table-body" class="divide-y divide-gray-100 dark:divide-gray-800">
                    @foreach($listTravelDocument as $index => $data)
                      <tr>
                        <td class="px-2 py-4 sm:px-6">
                          <p class="text-gray-500 text-theme-sm dark:text-gray-400">{{ $index + $listTravelDocument->firstItem() }}</p>
                        </td>
                        <td class="px-5 py-4 sm:px-6">
                          <p class="text-gray-500 text-theme-sm dark:text-gray-400">{{ $data->no_travel_document }}</p>
                        </td>
                        <td class="px-5 py-4 sm:px-6">
                          <p class="text-gray-500 text-theme-sm dark:text-gray-400">{{ \Carbon\Carbon::parse($data->date_no_travel_document)->format('d/m/Y') }}</p>
                        </td>
                        <td class="px-5 py-4 sm:px-6">
                          <p class="text-gray-500 text-theme-sm dark:text-gray-400">{{ $data->send_to }}</p>
                        </td>
                        <td class="px-5 py-4 sm:px-6">
                          <p class="text-gray-500 text-theme-sm dark:text-gray-400">{{ $data->project }}</p>
                        </td>
                        <td class="px-5 py-4 sm:px-6 whitespace-nowrap">
                          <p class="text-gray-500 text-theme-sm dark:text-gray-400">{{ $data->status }}</p>
                        </td>
                        <td class="px-5 py-4 sm:px-6">
                          <div class="flex space-x-2">
                            <form action="{{ route('shippings.detail', ['id' => $data['id']]) }}" method="GET">
                              <button type="submit" class="text-blue-600 dark:text-blue-400 hover:underline">detail</button>
                            </form>
                            <form action="{{ route('shippings.destroy', ['id' => $data['id']]) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus?');">
                              @csrf
                              @method('DELETE')
                              <button type="submit" class="text-red-600 dark:text-red-400 hover:underline">Hapus</button>
                            </form>
                          </div>
                        </td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>

                <div class="flex items-center justify-between border-t border-gray-200 bg-white px-4 py-3 sm:px-6 dark:border-gray-800 dark:bg-white/[0.03]">
                  <p class="text-sm text-gray-500 dark:text-gray-300 mb-2 sm:mb-0">
                    Menampilkan {{ $listTravelDocument->firstItem() }} ke {{ $listTravelDocument->lastItem() }} dari total {{ $listTravelDocument->total() }} data
                  </p>
                  <div>
                    {{ $listTravelDocument->links('pagination::tailwind') }}
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Export Modal -->
          <div
            x-show="showExportModal"
            x-cloak
            class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50"
            style="display: none;"
            @click="showExportModal = false"
          >
            <div
              @click.stop
              class="relative w-full max-w-md rounded-lg bg-white p-6 shadow-xl dark:bg-gray-800"
            >
              <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white">Export Data Pengiriman</h3>
                <button
                  type="button"
                  @click="showExportModal = false"
                  class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200"
                  aria-label="Close modal"
                >
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                  </svg>
                </button>
              </div>

              <form method="GET" action="{{ route('shippings.export') }}">
                <div class="space-y-4">
                  <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Dari Tanggal</label>
                    <input
                      type="date"
                      name="start_date"
                      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                    />
                  </div>

                  <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Sampai Tanggal</label>
                    <input
                      type="date"
                      name="end_date"
                      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                    />
                  </div>

                  <div class="flex justify-end space-x-3 pt-2">
                    <button
                      type="button"
                      @click="showExportModal = false"
                      class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-200 rounded-md hover:bg-gray-300 dark:bg-gray-700 dark:text-gray-200 dark:hover:bg-gray-600"
                    >
                      Batal
                    </button>
                    <button
                      type="submit"
                      class="flex items-center gap-2 px-4 py-2 text-sm font-medium text-white bg-green-600 rounded-md hover:bg-green-500"
                    >
                      <img src="{{ asset('images/icons/export.svg') }}" alt="Export" class="h-4 w-4" />
                      Export
                    </button>
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
