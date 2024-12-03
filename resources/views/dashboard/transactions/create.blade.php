<x-dash.layout>
    @slot('title')
        Tambah Pengeluaran
    @endslot
    <h2 class="mb-4">Tambah Pengeluaran</h2>
    <div class="row">
        <div class="col-xl-9">
            <form class="row g-3 mb-6 needs-validation" novalidate="" method="POST"
                action="{{ route('transactions.store') }}" onsubmit="showLoader(event)">
                @csrf
                <div class="col-12">
                    <div class="form-floating">
                        <input class="form-control" id="transaction_date" type="date" name="transaction_date"
                            placeholder="Tanggal Transaksi" required />
                        <label for="transaction_date">Tanggal Transaksi</label>
                    </div>
                </div>
                <div class="col-12">
                    <label for="transaction_description">Deskripsi Transaksi</label>
                    <textarea class="form-control" id="transaction_description" name="transaction_description"
                        placeholder="Deskripsi Transaksi" style="height: 150px" required></textarea>
                </div>
                <div class="col-12">
                    <div class="form-floating">
                        <input class="form-control" id="payment_method" type="text" name="payment_method"
                            placeholder="Metode Pembayaran" required />
                        <label for="payment_method">Metode Pembayaran</label>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-floating">
                        <input class="form-control" id="expense_category" type="text" name="expense_category"
                            placeholder="Kategori Pengeluaran (Opsional)" />
                        <label for="expense_category">Jumlah Pengeluaran</label>
                    </div>
                </div>
                <div class="col-12">
                    <label for="additional_notes">Catatan Tambahan (Opsional)</label>
                    <textarea class="form-control" id="additional_notes" name="additional_notes" placeholder="Catatan Tambahan"
                        style="height: 150px"></textarea>
                </div>
                <div class="col-12 gy-6">
                    <div class="row g-3 justify-content-end">
                        <div class="col-auto">
                            <button class="btn btn-phoenix-primary px-5" type="button"
                                onclick="window.history.back()">Cancel</button>
                        </div>
                        <div class="col-auto">
                            <button class="btn btn-primary px-5 px-sm-15">Tambah</button>
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
        const unitQuantityInput = document.getElementById('unit_quantity');
        const totalAmountInput = document.getElementById('total_amount');

        function calculateTotal() {
            const unitPrice = parseInt(unitPriceInput.value.replace(/[^0-9]/g, ''), 10) || 0;
            const unitQuantity = parseInt(unitQuantityInput.value, 10) || 0;
            const total = unitPrice * unitQuantity;
            totalAmountInput.value = total.toLocaleString('id-ID', {
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

        unitQuantityInput.addEventListener('input', calculateTotal);
    });
</script>
