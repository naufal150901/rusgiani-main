<x-dash.layout>
    @slot('title')
        Edit Barang Masuk
    @endslot
    <h2 class="mb-4">Edit Barang Masuk</h2>
    <div class="row">
        <div class="col-xl-9">
            <form class="row g-3 mb-6 needs-validation" novalidate="" method="POST"
                action="{{ route('incoming-items.update', $incomingItem->id) }}" onsubmit="prepareForm(event)">
                @csrf
                @method('PUT')
                <div class="col-12">
                    <div class="form-floating">
                        <input class="form-control" id="in_date" type="date" name="in_date"
                            placeholder="Tanggal Masuk" value="{{ $incomingItem->in_date }}" required />
                        <label for="in_date">Tanggal Masuk</label>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-floating">
                        <input class="form-control" id="gas_type" type="text" name="gas_type"
                            placeholder="Jenis Gas" value="{{ $incomingItem->gas_type }}" required />
                        <label for="gas_type">Jenis Gas</label>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-floating">
                        <input class="form-control" id="quantity_in" type="number" name="quantity_in"
                            placeholder="Jumlah Masuk" value="{{ $incomingItem->quantity_in }}" required />
                        <label for="quantity_in">Jumlah Masuk</label>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-floating">
                        <input class="form-control" id="unit_price" type="text" step="0.01" name="unit_price"
                            placeholder="Harga per Unit" value="{{ $incomingItem->unit_price }}" required />
                        <label for="unit_price">Harga per Unit</label>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-floating">
                        <input class="form-control" id="total_cost" type="text" step="0.01" name="total_cost"
                            placeholder="Total Biaya" value="{{ $incomingItem->total_cost }}" readonly />
                        <label for="total_cost">Total Biaya</label>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-floating">
                        <input class="form-control" id="supplier" type="text" name="supplier" placeholder="Pemasok"
                            value="{{ $incomingItem->supplier }}" required />
                        <label for="supplier">Pemasok</label>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-floating">
                        <input class="form-control" id="batch_number" type="text" name="batch_number"
                            placeholder="Nomor Batch (Opsional)" value="{{ $incomingItem->batch_number }}" />
                        <label for="batch_number">Nomor Batch (Opsional)</label>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-floating">
                        <input class="form-control" id="warehouse_location" type="text" name="warehouse_location"
                            placeholder="Lokasi Gudang (Opsional)" value="{{ $incomingItem->warehouse_location }}" />
                        <label for="warehouse_location">Lokasi Gudang (Opsional)</label>
                    </div>
                </div>
                <div class="col-12">
                    <label for="additional_notes">Catatan Tambahan (Opsional)</label>
                    <textarea class="form-control" id="additional_notes" name="additional_notes" placeholder="Catatan Tambahan"
                        style="height: 150px">{{ $incomingItem->additional_notes }}</textarea>
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
        const quantityInInput = document.getElementById('quantity_in');
        const totalCostInput = document.getElementById('total_cost');

        function calculateTotal() {
            const unitPrice = parseInt(unitPriceInput.value.replace(/[^0-9]/g, ''), 10) || 0;
            const quantityIn = parseInt(quantityInInput.value, 10) || 0;
            const total = unitPrice * quantityIn;
            totalCostInput.value = total.toLocaleString('id-ID', {
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

        quantityInInput.addEventListener('input', calculateTotal);
    });

    function prepareForm(event) {
        showLoader(event);
        const unitPriceInput = document.getElementById('unit_price');
        unitPriceInput.value = unitPriceInput.value.replace(/[^0-9]/g, '');
        const totalCostInput = document.getElementById('total_cost');
        totalCostInput.value = totalCostInput.value.replace(/[^0-9]/g, '');
    }
</script>
