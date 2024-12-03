<x-dash.layout>
    @slot('title')
        Edit Transaksi Keuangan
    @endslot
    <h2 class="mb-4">Edit Transaksi Keuangan</h2>
    <div class="row">
        <div class="col-xl-9">
            <form class="row g-3 mb-6 needs-validation" novalidate="" method="POST"
                action="{{ route('transactions.update', $transaction->id) }}" onsubmit="showLoader(event)">
                @csrf
                @method('PUT')
                <div class="col-12">
                    <div class="form-floating">
                        <input class="form-control" id="transaction_date" type="date" name="transaction_date"
                            placeholder="Tanggal Transaksi" value="{{ $transaction->transaction_date }}" required />
                        <label for="transaction_date">Tanggal Transaksi</label>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-floating">
                        <input class="form-control" id="transaction_type" type="text" name="transaction_type"
                            placeholder="Jenis Transaksi" value="{{ $transaction->transaction_type }}" required />
                        <label for="transaction_type">Jenis Transaksi</label>
                    </div>
                </div>
                <div class="col-12">
                    <label for="transaction_description">Deskripsi Transaksi</label>
                    <textarea class="form-control" id="transaction_description" name="transaction_description"
                        placeholder="Deskripsi Transaksi" style="height: 150px" required>{{ $transaction->transaction_description }}</textarea>
                </div>
                <div class="col-12">
                    <div class="form-floating">
                        <input class="form-control" id="agent_client_name" type="text" name="agent_client_name"
                            placeholder="Nama Agen/Klien" value="{{ $transaction->agent_client_name }}" required />
                        <label for="agent_client_name">Nama Agen/Klien</label>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-floating">
                        <input class="form-control" id="unit_quantity" type="number" name="unit_quantity"
                            placeholder="Jumlah Unit" value="{{ $transaction->unit_quantity }}" required />
                        <label for="unit_quantity">Jumlah Unit</label>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-floating">
                        <input class="form-control" id="unit_price" type="text" name="unit_price"
                            placeholder="Harga per Unit"
                            value="{{ number_format($transaction->unit_price, 0, ',', '.') }}" required />
                        <label for="unit_price">Harga per Unit</label>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-floating">
                        <input class="form-control" id="total_amount" type="text" step="0.01" name="total_amount"
                            placeholder="Total" value="{{ number_format($transaction->total_amount, 0, ',', '.') }}"
                            disabled />
                        <label for="total_amount">Total</label>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-floating">
                        <input class="form-control" id="payment_method" type="text" name="payment_method"
                            placeholder="Metode Pembayaran" value="{{ $transaction->payment_method }}" required />
                        <label for="payment_method">Metode Pembayaran</label>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-floating">
                        <select class="form-select" id="payment_status" required name="payment_status">
                            <option hidden value="">Pilih Status Pembayaran</option>
                            <option value="Paid" {{ $transaction->payment_status == 'Paid' ? 'selected' : '' }}>Lunas
                            </option>
                            <option value="Unpaid" {{ $transaction->payment_status == 'Unpaid' ? 'selected' : '' }}>
                                Belum Lunas
                            </option>
                            <option value="Partial" {{ $transaction->payment_status == 'Partial' ? 'selected' : '' }}>
                                Sebagian
                            </option>
                        </select>
                        <label for="payment_status">Status Pembayaran</label>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-floating">
                        <input class="form-control" id="expense_category" type="text" name="expense_category"
                            placeholder="Kategori Pengeluaran (Opsional)"
                            value="{{ $transaction->expense_category }}" />
                        <label for="expense_category">Kategori Pengeluaran (Opsional)</label>
                    </div>
                </div>
                <div class="col-12">
                    <label for="additional_notes">Catatan Tambahan (Opsional)</label>
                    <textarea class="form-control" id="additional_notes" name="additional_notes" placeholder="Catatan Tambahan"
                        style="height: 150px">{{ $transaction->additional_notes }}</textarea>
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
