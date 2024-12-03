<x-dash.layout>
    @slot('title')
        {{ $title }}
    @endslot

    <div class="mb-9">
        <div id="financialTransactions"
            data-list='{"valueNames":["id","transaction_date", "transaction_type", "transaction_description", "agent_client_name", "unit_quantity", "unit_price", "total_amount", "payment_method", "payment_status"],"page":6,"pagination":true}'>
            <div class="row mb-4 gx-6 gy-3 align-items-center">
                <div class="col-auto">
                    <h2 class="mb-0">{{ $title }}<span class="fw-normal text-body-tertiary ms-3"></span></h2>
                </div>
            </div>
            <form method="POST" action="{{ route('transactions.bulkDestroy') }}" id="bulk-delete-form">
                @csrf
                @method('DELETE')
                <div class="row g-3 justify-content-between align-items-end mb-4">
                    <div class="col-12 col-sm-auto">
                        <div class="d-flex align-items-center">
                            @can('transaction-create')
                                <div class="mt-3 mx-2">
                                    <a class="btn btn-primary btn-sm" href="{{ route('transactions.create') }}">
                                        <i class="fa-solid fa-plus me-2"></i>Tambah
                                    </a>
                                </div>
                            @endcan

                            @can('transaction-delete')
                                <div class="mt-3">
                                    <button type="submit" class="btn btn-danger btn-sm" id="delete-selected"
                                        onclick="return confirm('Apakah anda yakin?')" disabled>
                                        <span class="fas fa-trash me-2"></span>Hapus yang dipilih
                                    </button>
                                </div>
                            @endcan
                        </div>
                    </div>
                    <div class="col-12 col-sm-auto">
                        <div class="search-box me-3">
                            <form class="position-relative">
                                <input class="form-control search-input search" type="search"
                                    placeholder="Cari transaksi" aria-label="Search" />
                                <span class="fas fa-search search-box-icon"></span>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="table-responsive scrollbar">
                    <table class="table fs-9 mb-0 border-top border-translucent">
                        <thead>
                            <tr>
                                <th class="ps-3" style="width:2%;">
                                    <input type="checkbox" id="select-all">
                                </th>
                                <th class="sort ps-3" scope="col" data-sort="id" style="width:6%;">ID</th>
                                <th class="sort ps-3" scope="col" data-sort="transaction_date">Tanggal Transaksi</th>
                                <th class="sort ps-3" scope="col" data-sort="transaction_type">Jenis Transaksi</th>
                                <th class="sort ps-3" scope="col" data-sort="transaction_description">Deskripsi
                                    Transaksi</th>
                                <th class="sort ps-3" scope="col" data-sort="agent_client_name">Nama Agen/Klien</th>
                                <th class="sort ps-3" scope="col" data-sort="unit_quantity">Jumlah Unit</th>
                                <th class="sort ps-3" scope="col" data-sort="unit_price">Harga per Unit</th>
                                <th class="sort ps-3" scope="col" data-sort="total_amount">Total</th>
                                <th class="sort ps-3" scope="col" data-sort="payment_method">Metode Pembayaran</th>
                                <th class="sort ps-3" scope="col" data-sort="payment_status">Status Pembayaran</th>
                                @canany(['transaction-edit', 'transaction-delete'])
                                    <th class="sort text-end" scope="col"></th>
                                @endcanany
                            </tr>
                        </thead>
                        <tbody class="list" id="transaction-list-table-body">
                            @foreach ($transactions as $transaction)
                                <tr class="position-static">
                                    <td class="text-center time white-space-nowrap ps-0 id py-4">
                                        <input type="checkbox" name="transactionIds[]" value="{{ $transaction->id }}"
                                            class="select-item">
                                    </td>
                                    <td class="text-center time white-space-nowrap ps-0 id py-4">{{ $transaction->id }}
                                    </td>
                                    <td class="time white-space-nowrap ps-0 transaction_date py-4">
                                        {{ $transaction->transaction_date }}</td>
                                    <td class="time white-space-nowrap ps-0 transaction_type py-4">
                                        {{ $transaction->transaction_type }}</td>
                                    <td class="time white-space-nowrap ps-0 transaction_description py-4">
                                        {{ $transaction->transaction_description }}</td>
                                    <td class="time white-space-nowrap ps-0 agent_client_name py-4">
                                        {{ $transaction->agent_client_name }}</td>
                                    <td class="time white-space-nowrap ps-0 unit_quantity py-4">
                                        {{ $transaction->unit_quantity }}</td>
                                    <td class="time white-space-nowrap ps-0 unit_price py-4">
                                        Rp {{ number_format($transaction->unit_price, 0, ',', '.') }}
                                    </td>
                                    <td class="time white-space-nowrap ps-0 total_amount py-4">
                                        Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</td>
                                    <td class="time white-space-nowrap ps-0 payment_method py-4">
                                        {{ $transaction->payment_method }}</td>
                                    <td class="time white-space-nowrap ps-0 payment_status py-4">
                                        {{ $transaction->payment_status }}</td>
                                    @canany(['transaction-edit', 'transaction-delete'])
                                        <td class="text-end white-space-nowrap pe-0 action">
                                            <div class="btn-reveal-trigger position-static">
                                                <button
                                                    class="btn btn-sm dropdown-toggle dropdown-caret-none transition-none btn-reveal fs-10"
                                                    type="button" data-bs-toggle="dropdown" data-boundary="window"
                                                    aria-haspopup="true" aria-expanded="false" data-bs-reference="parent">
                                                    <span class="fas fa-ellipsis-h fs-10"></span>
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-end py-2">
                                                    @can('transaction-edit')
                                                        <a class="dropdown-item"
                                                            href="{{ route('transactions.edit', $transaction->id) }}">Edit</a>
                                                    @endcan
                                                    @can('transaction-delete')
                                                        <div class="dropdown-divider"></div>
                                                        <form action="{{ route('transactions.destroy', $transaction->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button class="dropdown-item text-danger"
                                                                onclick="return confirm('Apakah anda yakin?')">Hapus</button>
                                                        </form>
                                                    @endcan
                                                </div>
                                            </div>
                                        </td>
                                    @endcanany
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div
                    class="d-flex flex-wrap align-items-center justify-content-between py-3 pe-0 fs-9 border-bottom border-translucent">
                    <div class="d-flex">
                        <p class="mb-0 d-none d-sm-block me-3 fw-semibold text-body" data-list-info="data-list-info">
                        </p>
                        <a class="fw-semibold" href="#!" data-list-view="*">View all<span
                                class="fas fa-angle-right ms-1" data-fa-transform="down-1"></span></a>
                        <a class="fw-semibold d-none" href="#!" data-list-view="less">View Less<span
                                class="fas fa-angle-right ms-1" data-fa-transform="down-1"></span></a>
                    </div>
                    <div class="d-flex">
                        <button class="page-link" data-list-pagination="prev"><span
                                class="fas fa-chevron-left"></span></button>
                        <ul class="mb-0 pagination"></ul>
                        <button class="page-link pe-0" data-list-pagination="next"><span
                                class="fas fa-chevron-right"></span></button>
                    </div>
                </div>
            </form>

        </div>
    </div>
</x-dash.layout>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const selectAllCheckbox = document.getElementById('select-all');
        const deleteButton = document.getElementById('delete-selected');
        const checkboxes = document.querySelectorAll('.select-item');
        let selectedItems = new Set();

        function updateCheckboxes() {
            checkboxes.forEach(checkbox => {
                if (selectedItems.has(checkbox.value)) {
                    checkbox.checked = true;
                } else {
                    checkbox.checked = false;
                }
            });
        }

        selectAllCheckbox.addEventListener('click', function(event) {
            const currentPageCheckboxes = document.querySelectorAll('.select-item');
            currentPageCheckboxes.forEach(checkbox => {
                checkbox.checked = event.target.checked;
                if (event.target.checked) {
                    selectedItems.add(checkbox.value);
                } else {
                    selectedItems.delete(checkbox.value);
                }
            });
            toggleDeleteButton();
        });

        checkboxes.forEach(function(checkbox) {
            checkbox.addEventListener('change', function() {
                if (checkbox.checked) {
                    selectedItems.add(checkbox.value);
                } else {
                    selectedItems.delete(checkbox.value);
                }
                toggleDeleteButton();
            });
        });

        function toggleDeleteButton() {
            deleteButton.disabled = selectedItems.size === 0;
        }

        // Initial check to set the button state on page load
        toggleDeleteButton();

        // Update the form submission to include all selected items
        document.getElementById('bulk-delete-form').addEventListener('submit', function(event) {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'transactionIds';
            input.value = Array.from(selectedItems).join(',');
            this.appendChild(input);
        });

        // Update checkboxes when the page changes
        document.querySelectorAll('.page-link').forEach(function(pageLink) {
            pageLink.addEventListener('click', function() {
                setTimeout(updateCheckboxes, 100); // Adjust the timeout as needed
            });
        });
    });
</script>
