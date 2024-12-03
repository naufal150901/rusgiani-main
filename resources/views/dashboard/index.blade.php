<x-dash.layout>
    @slot('title')
        Dashboard
    @endslot
    <div class="row g-3 mb-3"> <!-- Kartu Total Barang Masuk -->
        <div class="col-sm-6 col-md-4 col-xl-3 col-xxl-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex d-sm-block justify-content-between">
                        <div class="mb-sm-4">
                            <div class="d-flex align-items-center">
                                <div class="d-flex align-items-center icon-wrapper-sm shadow-primary-100"
                                    style="transform: rotate(-7.45deg);"><span
                                        class="fa-solid fa-boxes text-primary fs-7 z-1 ms-2"></span></div>
                                <p class="text-body-tertiary fs-9 mb-0 ms-2 mt-3">Total Barang Masuk</p>
                            </div>
                            <p class="text-primary mt-2 fs-6 fw-bold mb-0 mb-sm-4">{{ $totalBarangMasuk }} <span
                                    class="fs-8 text-body lh-lg">Barang</span></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Kartu Total Barang Keluar -->
        <div class="col-sm-6 col-md-4 col-xl-3 col-xxl-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex d-sm-block justify-content-between">
                        <div class="mb-sm-4">
                            <div class="d-flex align-items-center">
                                <div class="d-flex align-items-center icon-wrapper-sm shadow-primary-100"
                                    style="transform: rotate(-7.45deg);"><span
                                        class="fa-solid fa-truck-loading text-primary fs-7 z-1 ms-2"></span></div>
                                <p class="text-body-tertiary fs-9 mb-0 ms-2 mt-3">Stok Barang</p>
                            </div>
                            <p class="text-primary mt-2 fs-6 fw-bold mb-0 mb-sm-4">{{ $totalBarangKeluar }} <span
                                    class="fs-8 text-body lh-lg">Barang</span></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-dash.layout>
