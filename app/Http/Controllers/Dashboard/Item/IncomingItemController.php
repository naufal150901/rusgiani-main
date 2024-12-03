<?php

namespace App\Http\Controllers\Dashboard\Item;

use Illuminate\View\View;
use Illuminate\Support\Str;
use App\Traits\LogsActivity;
use App\Models\Item\IncomingItem;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOutgoingItemRequest;
use App\Http\Requests\UpdateOutgoingItemRequest;
use App\Models\Transaction\FinancialTransaction;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Http\Requests\Dashboard\Transaction\StoreFinancialTransactionRequest;
use App\Http\Requests\Dashboard\Transaction\UpdateFinancialTransactionRequest;

class IncomingItemController extends Controller
{
    use ValidatesRequests;
    use LogsActivity;

    function __construct()
    {
        $this->middleware('permission:incoming-item-list|incoming-item-create|incoming-item-edit|incoming-item-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:incoming-item-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:incoming-item-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:incoming-item-delete', ['only' => ['destroy', 'bulkDestroy']]);
        $this->middleware('permission:incoming-item-download', ['only' => ['download', 'index']]);
    }

    public function index(): View
    {
        $title = 'Transaksi Keuangan';
        $transactions = FinancialTransaction::all();
        return view('dashboard.transactions.index', compact('title', 'transactions'));
    }

    public function create()
    {
        return view('dashboard.transactions.create');
    }

    public function store(StoreFinancialTransactionRequest $request)
    {
        $validatedData = $request->validated();
        $validatedData['uuid'] = (string) Str::uuid();
        $validatedData['unit_price'] = str_replace(['Rp', ' ', ',', '.', "\xC2\xA0"], '', $validatedData['unit_price']);
        $validatedData['total_amount'] = $validatedData['unit_quantity'] * $validatedData['unit_price'];
        FinancialTransaction::create($validatedData);
        return redirect()->route('transactions.index')->with('success', 'Transaksi Keuangan berhasil ditambahkan.');
    }

    public function show(FinancialTransaction $financialTransaction)
    {
        return view('dashboard.transactions.show', compact('financialTransaction'));
    }

    public function edit(FinancialTransaction $transaction)
    {
        return view('dashboard.transactions.edit', compact('transaction'));
    }

    public function update(UpdateFinancialTransactionRequest $request, FinancialTransaction $transaction)
    {
        $validatedData = $request->validated();
        $validatedData['unit_price'] = str_replace(['Rp', ' ', ',', '.', "\xC2\xA0"], '', $validatedData['unit_price']);
        $validatedData['unit_price'] = round($validatedData['unit_price']);
        $validatedData['total_amount'] = round($validatedData['unit_quantity'] * $validatedData['unit_price']);
        $transaction->update($validatedData);
        return redirect()->route('transactions.index')->with('success', 'Transaksi Keuangan berhasil diperbarui.');
    }

    public function destroy(FinancialTransaction $financialTransaction)
    {
        $financialTransaction->delete();
        return redirect()->route('transactions.index')->with('success', 'Transaksi Keuangan berhasil dihapus.');
    }
}
