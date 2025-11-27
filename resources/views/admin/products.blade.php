<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Manajemen Produk — Admin</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>

    <style>
        /* Glass helpers (opsional, dipakai pada card/table) */
        .glass {
            background: rgba(255,255,255,0.85);
            -webkit-backdrop-filter: blur(6px);
            backdrop-filter: blur(6px);
            border: 1px solid rgba(15,23,42,0.04);
        }
        .glass-dark {
            background: rgba(255,255,255,0.06);
            -webkit-backdrop-filter: blur(8px);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255,255,255,0.04);
        }
        .modal { display:none; }
        .modal.show { display:flex; }
    </style>
</head>
<body class="bg-gradient-to-br from-slate-50 to-slate-100 antialiased text-slate-900">

<div class="flex h-screen overflow-hidden">
    {{-- Sidebar (pakai file sidebar yang sama) --}}
    @include('admin.sidebar')

    <div class="flex-1 flex flex-col overflow-hidden lg:ml-64 transition-all duration-300">

        {{-- HEADER (sama dengan dashboard) --}}
        <header class="bg-white/80 backdrop-blur-lg shadow-sm z-10 border-b border-slate-200">
            <div class="flex items-center justify-between px-6 py-4">
                <div class="flex items-center">
                    <button id="sidebarToggle" class="text-slate-600 hover:text-slate-900 focus:outline-none lg:hidden mr-4">
                        <i class="fas fa-bars text-2xl"></i>
                    </button>
                    <div>
                        <h1 class="text-2xl font-bold bg-gradient-to-r from-cyan-600 to-blue-600 bg-clip-text text-transparent">Manajemen Produk</h1>
                        <p class="text-sm text-slate-500">Kelola produk — konsisten dengan dashboard.</p>
                    </div>
                </div>

                <div class="flex items-center space-x-4">
                    <button class="relative p-2 text-slate-600 hover:text-slate-900 hover:bg-slate-100 rounded-xl transition-all">
                        <i class="fas fa-bell text-xl"></i>
                        <span class="absolute top-1 right-1 bg-gradient-to-r from-red-500 to-pink-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center font-bold shadow-lg">3</span>
                    </button>

                    <div class="relative">
                        <img class="h-11 w-11 rounded-xl border-2 border-cyan-500 shadow-md"
                             src="https://ui-avatars.com/api/?name={{ Auth::user()->name ?? 'Admin' }}&background=06b6d4&color=fff"
                             alt="Admin">
                        <div class="absolute bottom-0 right-0 w-3 h-3 bg-green-500 rounded-full border-2 border-white"></div>
                    </div>
                </div>
            </div>
        </header>

        {{-- MAIN --}}
        <main class="flex-1 overflow-y-auto p-6">

            {{-- ALERT SUCCESS (sama feel dengan dashboard cards) --}}
            @if(session('success'))
                <div class="mb-6">
                    <div class="p-4 rounded-2xl bg-white shadow-md flex items-center gap-3">
                        <i class="fas fa-check-circle text-green-500 text-2xl"></i>
                        <div>
                            <div class="font-semibold text-slate-800">{{ session('success') }}</div>
                        </div>
                    </div>
                </div>
            @endif

            {{-- FILTER + ACTIONS (struktur & spacing serupa dashboard) --}}
            <div class="mb-6 grid grid-cols-1 lg:grid-cols-3 gap-4">
                <div class="col-span-2">
                    <div class="p-4 rounded-2xl glass shadow-sm">
                        <form method="GET" action="{{ route('admin.products.index') }}" id="filterForm" class="flex gap-3 items-center">
                            <div class="relative flex-1">
                                <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"></i>
                                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari produk atau SKU..."
                                       class="w-full pl-10 pr-4 py-3 rounded-xl border border-slate-200 bg-white/70 focus:outline-none focus:ring-2 focus:ring-cyan-300">
                            </div>

                            <select name="category" onchange="document.getElementById('filterForm').submit()" class="px-4 py-2 rounded-xl border border-slate-200 bg-white/70">
                                <option value="">Semua Kategori</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                                @endforeach
                            </select>

                            <select name="status" onchange="document.getElementById('filterForm').submit()" class="px-4 py-2 rounded-xl border border-slate-200 bg-white/70">
                                <option value="">Semua Status</option>
                                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                                <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Nonaktif</option>
                            </select>

                            <button type="submit" class="px-5 py-2 rounded-xl bg-gradient-to-r from-cyan-500 to-blue-500 text-white font-semibold shadow-md">
                                <i class="fas fa-filter mr-2"></i>Filter
                            </button>
                        </form>
                    </div>
                </div>

                <div class="p-4 rounded-2xl flex items-center justify-end">
                    <button onclick="openModal('createModal')" class="px-5 py-3 rounded-2xl bg-gradient-to-r from-purple-600 to-pink-500 text-white font-semibold shadow-lg hover:scale-105 transform transition">
                        <i class="fas fa-plus mr-2"></i>Tambah Produk
                    </button>
                </div>
            </div>

            {{-- TABLE (mengambil desain table glass namun tetap matching dengan dashboard cards) --}}
            <div class="rounded-2xl bg-white shadow overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full min-w-[900px]">
                        <thead>
                            <tr class="text-left text-sm uppercase text-slate-600 border-b">
                                <th class="px-6 py-4">Gambar</th>
                                <th class="px-6 py-4">SKU</th>
                                <th class="px-6 py-4">Produk</th>
                                <th class="px-6 py-4">Kategori</th>
                                <th class="px-6 py-4">Harga Jual</th>
                                <th class="px-6 py-4">Stok</th>
                                <th class="px-6 py-4">Status</th>
                                <th class="px-6 py-4">Aksi</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y">
                            @forelse($products as $product)
                                <tr class="hover:bg-slate-50 transition-colors">
                                    <td class="px-6 py-4">
                                        @if($product->image)
                                            <img src="{{ asset('storage/'.$product->image) }}" class="h-12 w-12 rounded-lg object-cover" alt="{{ $product->name }}">
                                        @else
                                            <div class="h-12 w-12 bg-slate-100 rounded-lg flex items-center justify-center">
                                                <i class="fas fa-box text-slate-400"></i>
                                            </div>
                                        @endif
                                    </td>

                                    <td class="px-6 py-4 text-sm font-medium text-slate-800">{{ $product->sku }}</td>

                                    <td class="px-6 py-4">
                                        <div class="font-semibold text-slate-800">{{ $product->name }}</div>
                                        <div class="text-xs text-slate-500">{{ \Illuminate\Support\Str::limit($product->description, 60) }}</div>
                                    </td>

                                    <td class="px-6 py-4 text-sm text-slate-700">{{ $product->category ?? '-' }}</td>

                                    <td class="px-6 py-4 text-sm font-semibold text-slate-800">Rp {{ number_format($product->selling_price,0,',','.') }}</td>

                                    <td class="px-6 py-4">
                                        <span class="{{ $product->stock < 10 ? 'text-red-600 font-semibold' : 'text-slate-800' }}">{{ $product->stock }} {{ $product->unit }}</span>
                                    </td>

                                    <td class="px-6 py-4">
                                        @if($product->status === 'active')
                                            <span class="inline-flex px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-700">Aktif</span>
                                        @else
                                            <span class="inline-flex px-3 py-1 text-xs font-semibold rounded-full bg-slate-100 text-slate-700">Nonaktif</span>
                                        @endif
                                    </td>

                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-2">
                                            <button onclick="editProduct({{ $product->id }})" class="p-2 rounded-lg border border-slate-200 hover:bg-slate-50">
                                                <i class="fas fa-edit text-slate-700"></i>
                                            </button>
                                            <button onclick="deleteProduct({{ $product->id }})" class="p-2 rounded-lg border border-slate-200 hover:bg-red-50">
                                                <i class="fas fa-trash text-red-600"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="px-6 py-12 text-center text-slate-500">
                                        <i class="fas fa-box-open text-4xl mb-3"></i>
                                        <div class="text-lg font-semibold">Belum ada produk</div>
                                        <div class="text-sm">Tambahkan produk pertama Anda sekarang!</div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination (sama feel) --}}
                @if($products->hasPages())
                    <div class="p-4 border-t flex items-center justify-end">
                        {{ $products->links() }}
                    </div>
                @endif
            </div>

        </main>
    </div>
</div>

<!-- ====== CREATE MODAL (responsive, scrollable, sticky footer) ====== -->
<div id="createModal" class="modal fixed inset-0 bg-black bg-opacity-40 items-center justify-center z-50 p-4">
  <div
    class="w-full max-w-2xl rounded-2xl glass shadow-2xl overflow-hidden transform transition-all duration-200"
    data-modal-card
    role="dialog"
    aria-modal="true"
    aria-labelledby="createModalTitle"
    style="max-height: calc(100vh - 2rem); display: flex; flex-direction: column;"
  >
    <!-- Header -->
    <div class="p-4 border-b border-slate-200 flex items-center justify-between flex-shrink-0">
      <h2 id="createModalTitle" class="text-lg font-semibold text-slate-800">Tambah Produk Baru</h2>
      <button onclick="closeModal('createModal')" class="text-slate-600 p-2 rounded-lg hover:bg-slate-100" aria-label="Tutup">
        <i class="fas fa-times"></i>
      </button>
    </div>

    <!-- Body (scrollable) -->
    <div class="px-6 py-4 overflow-y-auto" style="flex: 1 1 auto;">
      <form id="createFormScrollable" method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data" class="space-y-4">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div>
            <label class="text-sm text-slate-600 block mb-1">SKU *</label>
            <input type="text" name="sku" required class="w-full px-3 py-2 rounded-lg border border-slate-200">
          </div>
          <div>
            <label class="text-sm text-slate-600 block mb-1">Nama Produk *</label>
            <input type="text" name="name" required class="w-full px-3 py-2 rounded-lg border border-slate-200">
          </div>

          <div>
            <label class="text-sm text-slate-600 block mb-1">Kategori</label>
            <input type="text" name="category" class="w-full px-3 py-2 rounded-lg border border-slate-200">
          </div>

          <div>
            <label class="text-sm text-slate-600 block mb-1">Satuan *</label>
            <select name="unit" required class="w-full px-3 py-2 rounded-lg border border-slate-200">
              <option value="">Pilih Satuan</option>

                <optgroup label="Unit Umum">
                    <option value="pcs">Pcs (Pieces)</option>
                    <option value="unit">Unit</option>
                    <option value="buah">Buah</option>
                    <option value="item">Item</option>
                    <option value="set">Set</option>
                    <option value="pack">Pack</option>
                </optgroup>

                <optgroup label="Berat">
                    <option value="g">Gram (g)</option>
                    <option value="kg">Kilogram (kg)</option>
                    <option value="mg">Miligram (mg)</option>
                    <option value="ton">Ton</option>
                </optgroup>

                <optgroup label="Volume">
                    <option value="L">Liter (L)</option>
                    <option value="ml">Mililiter (ml)</option>
                    <option value="m3">Meter Kubik (m³)</option>
                </optgroup>

                <optgroup label="Panjang">
                    <option value="cm">Centimeter (cm)</option>
                    <option value="m">Meter (m)</option>
                    <option value="km">Kilometer (km)</option>
                    <option value="inch">Inch</option>
                </optgroup>

                <optgroup label="Kemasan">
                    <option value="botol">Botol</option>
                    <option value="kaleng">Kaleng</option>
                    <option value="kotak">Kotak</option>
                    <option value="sachet">Sachet</option>
                    <option value="karung">Karung</option>
                    <option value="barrel">Barrel</option>
                </optgroup>

                <optgroup label="Kuantitas Khusus">
                    <option value="lusin">Lusin</option>
                    <option value="kodi">Kodi</option>
                    <option value="rim">Rim</option>
                    <option value="gross">Gross</option>
                </optgroup>
            </select>
          </div>

          <div>
            <label class="text-sm text-slate-600 block mb-1">Harga Beli *</label>
            <input type="text" id="purchase_price" name="purchase_price" required class="w-full px-3 py-2 rounded-lg border border-slate-200">
          </div>

          <div>
            <label class="text-sm text-slate-600 block mb-1">Harga Jual *</label>
            <input type="text" id="selling_price" name="selling_price" required class="w-full px-3 py-2 rounded-lg border border-slate-200">
          </div>

          <div>
            <label class="text-sm text-slate-600 block mb-1">Stok *</label>
            <input type="number" name="stock" min="0" required class="w-full px-3 py-2 rounded-lg border border-slate-200">
          </div>

          <div>
            <label class="text-sm text-slate-600 block mb-1">Status *</label>
            <select name="status" required class="w-full px-3 py-2 rounded-lg border border-slate-200">
              <option value="active">Aktif</option>
              <option value="inactive">Nonaktif</option>
            </select>
          </div>
        </div>

        <div>
          <label class="text-sm text-slate-600 block mb-1">Deskripsi</label>
          <textarea name="description" rows="4" class="w-full px-3 py-2 rounded-lg border border-slate-200"></textarea>
        </div>

        <div>
          <label class="text-sm text-slate-600 block mb-1">Gambar Produk</label>
          <input type="file" name="image" accept="image/*" class="w-full rounded-lg border border-slate-200 p-2">
        </div>

        <!-- spacer to ensure content doesn't hide under sticky footer on very short screens -->
        <div style="height: 1.25rem;"></div>
      </form>
    </div>

    <!-- Sticky footer (always visible) -->
    <div class="p-4 border-t border-slate-200 bg-white/60 backdrop-blur-sm flex justify-end gap-3 flex-shrink-0" style="position: sticky; bottom: 0; z-index: 10;">
      <button type="button" onclick="closeModal('createModal')" class="px-5 py-2 rounded-lg border border-slate-200 bg-white">Batal</button>

      <!-- submit the form inside the scrollable body -->
      <button type="button" onclick="document.getElementById('createFormScrollable').submit()" class="px-5 py-2 rounded-lg bg-gradient-to-r from-cyan-500 to-blue-500 text-white font-semibold">
        <i class="fas fa-save mr-2"></i>Simpan
      </button>
    </div>
  </div>
</div>

<!-- ====== EDIT MODAL (responsive, scrollable, sticky footer) ====== -->
<div id="editModal" class="modal fixed inset-0 bg-black bg-opacity-40 items-center justify-center z-50 p-4">
  <div
    class="w-full max-w-2xl rounded-2xl glass shadow-2xl overflow-hidden transform transition-all duration-200"
    data-modal-card
    role="dialog"
    aria-modal="true"
    aria-labelledby="editModalTitle"
    style="max-height: calc(100vh - 2rem); display: flex; flex-direction: column;"
  >
    <!-- Header -->
    <div class="p-4 border-b border-slate-200 flex items-center justify-between flex-shrink-0">
      <h2 id="editModalTitle" class="text-lg font-semibold text-slate-800">Edit Produk</h2>
      <button onclick="closeModal('editModal')" class="text-slate-600 p-2 rounded-lg hover:bg-slate-100" aria-label="Tutup">
        <i class="fas fa-times"></i>
      </button>
    </div>

    <!-- Body (scrollable) -->
    <div class="px-6 py-4 overflow-y-auto" style="flex: 1 1 auto;">
      <form id="editFormScrollable" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div>
            <label class="text-sm text-slate-600 block mb-1">SKU *</label>
            <input type="text" id="edit_sku" name="sku" required class="w-full px-3 py-2 rounded-lg border border-slate-200">
          </div>
          <div>
            <label class="text-sm text-slate-600 block mb-1">Nama Produk *</label>
            <input type="text" id="edit_name" name="name" required class="w-full px-3 py-2 rounded-lg border border-slate-200">
          </div>

          <div>
            <label class="text-sm text-slate-600 block mb-1">Kategori</label>
            <input type="text" id="edit_category" name="category" class="w-full px-3 py-2 rounded-lg border border-slate-200">
          </div>

          <div>
            <label class="text-sm text-slate-600 block mb-1">Satuan *</label>
            <select id="edit_unit" name="unit" required class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-purple-500">
                <option value="">Pilih Satuan</option>

                <optgroup label="Unit Umum">
                    <option value="pcs">Pcs (Pieces)</option>
                    <option value="unit">Unit</option>
                    <option value="buah">Buah</option>
                    <option value="item">Item</option>
                    <option value="set">Set</option>
                    <option value="pack">Pack</option>
                </optgroup>

                <optgroup label="Berat">
                    <option value="g">Gram (g)</option>
                    <option value="kg">Kilogram (kg)</option>
                    <option value="mg">Miligram (mg)</option>
                    <option value="ton">Ton</option>
                </optgroup>

                <optgroup label="Volume">
                    <option value="L">Liter (L)</option>
                    <option value="ml">Mililiter (ml)</option>
                    <option value="m3">Meter Kubik (m³)</option>
                </optgroup>

                <optgroup label="Panjang">
                    <option value="cm">Centimeter (cm)</option>
                    <option value="m">Meter (m)</option>
                    <option value="km">Kilometer (km)</option>
                    <option value="inch">Inch</option>
                </optgroup>

                <optgroup label="Kemasan">
                    <option value="botol">Botol</option>
                    <option value="kaleng">Kaleng</option>
                    <option value="kotak">Kotak</option>
                    <option value="sachet">Sachet</option>
                    <option value="karung">Karung</option>
                    <option value="barrel">Barrel</option>
                </optgroup>

                <optgroup label="Kuantitas Khusus">
                    <option value="lusin">Lusin</option>
                    <option value="kodi">Kodi</option>
                    <option value="rim">Rim</option>
                    <option value="gross">Gross</option>
                </optgroup>
            </select>
          </div>

          <div>
            <label class="text-sm text-slate-600 block mb-1">Harga Beli *</label>
            <input type="text" id="edit_purchase_price" name="purchase_price" required class="w-full px-3 py-2 rounded-lg border border-slate-200">
          </div>

          <div>
            <label class="text-sm text-slate-600 block mb-1">Harga Jual *</label>
            <input type="text" id="edit_selling_price" name="selling_price" required class="w-full px-3 py-2 rounded-lg border border-slate-200">
          </div>

          <div>
            <label class="text-sm text-slate-600 block mb-1">Stok *</label>
            <input type="number" id="edit_stock" name="stock" min="0" required class="w-full px-3 py-2 rounded-lg border border-slate-200">
          </div>

          <div>
            <label class="text-sm text-slate-600 block mb-1">Status *</label>
            <select id="edit_status" name="status" required class="w-full px-3 py-2 rounded-lg border border-slate-200">
              <option value="active">Aktif</option>
              <option value="inactive">Nonaktif</option>
            </select>
          </div>
        </div>

        <div>
          <label class="text-sm text-slate-600 block mb-1">Deskripsi</label>
          <textarea id="edit_description" name="description" rows="4" class="w-full px-3 py-2 rounded-lg border border-slate-200"></textarea>
        </div>

        <div>
          <label class="text-sm text-slate-600 block mb-1">Gambar Produk</label>
          <input type="file" id="editImageInputSticky" name="image" accept="image/*" class="w-full rounded-lg border border-slate-200 p-2">
          <p class="text-xs text-slate-500 mt-1">Biarkan kosong jika tidak ingin mengubah gambar</p>
        </div>

        <!-- spacer to ensure content doesn't hide under sticky footer on very short screens -->
        <div style="height: 1.25rem;"></div>
      </form>
    </div>

    <!-- Sticky footer (always visible) -->
    <div class="p-4 border-t border-slate-200 bg-white/60 backdrop-blur-sm flex justify-end gap-3 flex-shrink-0" style="position: sticky; bottom: 0; z-index: 10;">
      <button type="button" onclick="closeModal('editModal')" class="px-5 py-2 rounded-lg border border-slate-200 bg-white">Batal</button>

      <!-- submit the edit form inside the scrollable body -->
      <button type="button" onclick="document.getElementById('editFormScrollable').submit()" class="px-5 py-2 rounded-lg bg-gradient-to-r from-cyan-500 to-blue-500 text-white font-semibold">
        <i class="fas fa-save mr-2"></i>Update
      </button>
    </div>
  </div>
</div>

<form id="deleteForm" method="POST" style="display:none;">
    @csrf
    @method('DELETE')
</form>

<script>
    // Sidebar toggle (dari dashboard)
    const sidebarToggle = document.getElementById('sidebarToggle');
    const sidebar = document.getElementById('sidebar');
    if (sidebarToggle && sidebar) {
        sidebarToggle.addEventListener('click', () => {
            sidebar.classList.toggle('-translate-x-full');
        });
    }

    // Modal open/close
    function openModal(id) { document.getElementById(id).classList.add('show'); }
    function closeModal(id) { document.getElementById(id).classList.remove('show'); }
    document.querySelectorAll('.modal').forEach(modal => {
        modal.addEventListener('click', function (e) { if (e.target === this) closeModal(this.id); });
    });

    // Format Rupiah kecil
    function formatRupiah(angka) {
        let number_string = angka.replace(/[^,\d]/g, '').toString(),
            split = number_string.split(','),
            sisa = split[0].length % 3,
            rupiah = split[0].substr(0, sisa),
            ribuan = split[0].substr(sisa).match(/\d{3}/gi);
        if (ribuan) { let separator = sisa ? '.' : ''; rupiah += separator + ribuan.join('.'); }
        rupiah = split[1] !== undefined ? rupiah + ',' + split[1] : rupiah;
        return rupiah;
    }

    const purchaseInput = document.getElementById('purchase_price');
    const sellingInput  = document.getElementById('selling_price');
    const editPurchaseInput = document.getElementById('edit_purchase_price');
    const editSellingInput  = document.getElementById('edit_selling_price');

    [purchaseInput, sellingInput, editPurchaseInput, editSellingInput].forEach(inp => {
        if (!inp) return;
        inp.addEventListener('keyup', function () { this.value = formatRupiah(this.value); });
    });

    // Replacement: lebih aman, cari form di dalam modal, set action hanya kalau form ditemukan,
// isi preview gambar jika tersedia, dan set tombol status (jika ada).
function editProduct(productId) {
  fetch(`/admin/products/${productId}`)
    .then(r => { if (!r.ok) throw new Error('Gagal mengambil data'); return r.json(); })
    .then(product => {
      // isi field
      const setIfExists = (id, value) => {
        const el = document.getElementById(id);
        if (el) el.value = value ?? '';
      };
      setIfExists('edit_sku', product.sku ?? '');
      setIfExists('edit_name', product.name ?? '');
      setIfExists('edit_category', product.category ?? '');
      setIfExists('edit_unit', product.unit ?? '');
      setIfExists('edit_purchase_price', product.purchase_price ? formatRupiah(product.purchase_price.toString()) : '');
      setIfExists('edit_selling_price', product.selling_price ? formatRupiah(product.selling_price.toString()) : '');
      setIfExists('edit_stock', product.stock ?? 0);
      setIfExists('edit_status', product.status ?? 'active');
      setIfExists('edit_description', product.description ?? '');

      // cari form edit di dalam modal (lebih fleksibel daripada mengandalkan id tunggal)
      const editModal = document.getElementById('editModal');
      let form = document.getElementById('editForm'); // coba id lama dulu (kompatibilitas)
      if (!form && editModal) {
        form = editModal.querySelector('form'); // ambil form pertama di editModal
      }
      if (!form) {
        // fallback: cari form dengan id baru yang kita pakai sebelumnya
        form = document.getElementById('editFormScrollable');
      }

      if (form) {
        // pastikan method/attributes sesuai dan set action
        form.action = `/admin/products/${productId}`;
      } else {
        console.warn('Form edit tidak ditemukan. Pastikan form berada di dalam #editModal atau memiliki id "editFormScrollable".');
      }

      // set image preview jika API menyediakan path image (adjust sesuai API)
      // preferensi: jika backend mengembalikan product.image_url penuh gunakan itu,
      // jika hanya path storage gunakan konstruktor URL
      const editPreviewImage = document.getElementById('editPreviewImage');
      const editPreviewText = document.getElementById('editPreviewText');
      if (product.image) {
        let imageUrl = product.image_url ?? (product.image.startsWith('http') ? product.image : (window.location.origin + '/storage/' + product.image.replace(/^\/+/,'')));
        if (editPreviewImage) {
          editPreviewImage.src = imageUrl;
          editPreviewImage.classList.remove('hidden');
        }
        if (editPreviewText) editPreviewText.classList.add('hidden');
      } else {
        if (editPreviewImage) editPreviewImage.classList.add('hidden');
        if (editPreviewText) editPreviewText.classList.remove('hidden');
      }

      // set status pills jika ada tombol status custom
      const editStatusActiveBtn = document.getElementById('editStatusActiveBtn');
      const editStatusInactiveBtn = document.getElementById('editStatusInactiveBtn');
      const editStatusInput = document.getElementById('edit_status');
      if (editStatusInput && product.status) editStatusInput.value = product.status;
      if (product.status === 'inactive') {
        if (editStatusInactiveBtn) editStatusInactiveBtn.classList.add('bg-white','text-slate-800');
        if (editStatusActiveBtn) editStatusActiveBtn.classList.remove('bg-white','text-slate-800');
      } else {
        if (editStatusActiveBtn) editStatusActiveBtn.classList.add('bg-white','text-slate-800');
        if (editStatusInactiveBtn) editStatusInactiveBtn.classList.remove('bg-white','text-slate-800');
      }

      // finally open the modal
      openModal('editModal');
    })
    .catch(err => {
      console.error(err);
      alert(err.message || 'Terjadi kesalahan saat mengambil data produk');
    });
}


    // Hapus produk
    function deleteProduct(productId) {
        if (!confirm('Apakah Anda yakin ingin menghapus produk ini?')) return;
        const form = document.getElementById('deleteForm');
        form.action = `/admin/products/${productId}`;
        form.submit();
    }

    // Hapus titik pada harga sebelum submit
    document.querySelectorAll('form').forEach(form => {
        form.addEventListener('submit', function () {
            if (purchaseInput && purchaseInput.value) purchaseInput.value = purchaseInput.value.replace(/\./g, '');
            if (sellingInput && sellingInput.value) sellingInput.value = sellingInput.value.replace(/\./g, '');
            if (editPurchaseInput && editPurchaseInput.value) editPurchaseInput.value = editPurchaseInput.value.replace(/\./g, '');
            if (editSellingInput && editSellingInput.value) editSellingInput.value = editSellingInput.value.replace(/\./g, '');
        });
    });
</script>
</body>
</html>
