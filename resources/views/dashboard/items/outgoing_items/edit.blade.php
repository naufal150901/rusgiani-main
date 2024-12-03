<x-dash.layout>
    @slot('title')
        Edit Barang Keluar
    @endslot
    <h2 class="mb-4">Edit Barang Keluar</h2>
    <div class="row">
        <div class="col-xl-9">
            <form class="row g-3 mb-6 needs-validation" novalidate="" method="POST"
                action="{{ route('outgoing-items.update', $outgoingItem->id) }}" onsubmit="prepareForm(event)">
                @csrf
                @method('PUT')
                <div class="col-12">
                    <div class="form-floating">
                        <input class="form-control" id="out_date" type="date" name="out_date"
                            placeholder="Tanggal Keluar" value="{{ $outgoingItem->out_date }}" required />
                        <label for="out_date">Tanggal Keluar</label>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-floating">
                        <input class="form-control" id="gas_type" type="text" name="gas_type"
                            placeholder="Jenis Gas" value="{{ $outgoingItem->gas_type }}" required />
                        <label for="gas_type">Jenis Gas</label>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-floating">
                        <input class="form-control" id="quantity_out" type="number" name="quantity_out"
                            placeholder="Jumlah Keluar" value="{{ $outgoingItem->quantity_out }}" required />
                        <label for="quantity_out">Jumlah Keluar</label>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-floating">
                        <input class="form-control" id="unit_price" type="text" step="0.01" name="unit_price"
                            placeholder="Harga per Unit" value="{{ $outgoingItem->unit_price }}" required />
                        <label for="unit_price">Harga per Unit</label>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-floating">
                        <input class="form-control" id="total_revenue" type="text" step="0.01"
                            name="total_revenue" placeholder="Total Pendapatan"
                            value="{{ $outgoingItem->total_revenue }}" readonly />
                        <label for="total_revenue">Total Pendapatan</label>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-floating">
                        <input class="form-control" id="recipient" type="text" name="recipient"
                            placeholder="Penerima" value="{{ $outgoingItem->recipient }}" required />
                        <label for="recipient">Penerima</label>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-floating">
                        <input class="form-control" id="shipment_number" type="text" name="shipment_number"
                            placeholder="Nomor Pengiriman" value="{{ $outgoingItem->shipment_number }}" required />
                        <label for="shipment_number">Nomor Pengiriman</label>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-floating">
                        <input class="form-control" id="shipment_method" type="text" name="shipment_method"
                            placeholder="Metode Pengiriman" value="{{ $outgoingItem->shipment_method }}" required />
                        <label for="shipment_method">Metode Pengiriman</label>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-floating">
                        <input class="form-control" id="warehouse_location" type="text" name="warehouse_location"
                            placeholder="Lokasi Gudang" value="{{ $outgoingItem->warehouse_location }}" required />
                        <label for="warehouse_location">Lokasi Gudang</label>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-floating">
                        <select class="form-select" id="shipment_status" required name="shipment_status">
                            <option hidden value="">Pilih Status Pengiriman</option>
                            <option value="dalam_pengiriman"
                                {{ $outgoingItem->shipment_status == 'dalam_pengiriman' ? 'selected' : '' }}>Dalam
                                Pengiriman</option>
                            <option value="transit"
                                {{ $outgoingItem->shipment_status == 'transit' ? 'selected' : '' }}>Transit</option>
                        </select>
                        <label for="shipment_status">Status Pengiriman</label>
                    </div>
                </div>
                <div class="col-12">
                    <label for="additional_notes">Catatan Tambahan (Opsional)</label>
                    <textarea class="form-control" id="additional_notes" name="additional_notes" placeholder="Catatan Tambahan"
                        style="height: 150px">{{ $outgoingItem->additional_notes }}</textarea>
                </div>
                <div class="col-12 gy-6">
                    <div class="row g-3 justify-content-end">
                        <div class="col-auto">
                            <button class="btn btn-phoenix-primary px-5" type="button"
                                onclick="window.history.back()">Cancel</button>
                        </div>
                        <div class="col-auto">
                            <button class="btn btn-primary px-5 px-sm-15">Update</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @push('css')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
            integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    @endpush
</x-dash.layout>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const unitPriceInput = document.getElementById('unit_price');
        const quantityOutInput = document.getElementById('quantity_out');
        const totalRevenueInput = document.getElementById('total_revenue');

        function calculateTotal() {
            const unitPrice = parseInt(unitPriceInput.value.replace(/[^0-9]/g, ''), 10) || 0;
            const quantityOut = parseInt(quantityOutInput.value, 10) || 0;
            const total = unitPrice * quantityOut;
            totalRevenueInput.value = total.toLocaleString('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0
            });
        }

        unitPriceInput.addEventListener('input', function() {
            let value = unitPriceInput.value.replace(/[^0-9]/g, '');
            if (value) {
                value = parseInt(value, 10).toLocaleString('id-ID', {
                    style: 'currency',
                    currency: 'IDR',
                    minimumFractionDigits: 0
                });
                unitPriceInput.value = value;
            }
            calculateTotal();
        });

        quantityOutInput.addEventListener('input', calculateTotal);
    });

    function prepareForm(event) {
        showLoader(event);
        const unitPriceInput = document.getElementById('unit_price');
        unitPriceInput.value = unitPriceInput.value.replace(/[^0-9]/g, '');
        const totalRevenueInput = document.getElementById('total_revenue');
        totalRevenueInput.value = totalRevenueInput.value.replace(/[^0-9]/g, '');
    }
</script>
