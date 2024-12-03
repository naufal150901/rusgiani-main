<?php

namespace App\Http\Controllers\Dashboard\Item;

use Illuminate\View\View;
use Illuminate\Support\Str;
use App\Models\Item\OutgoingItem;
use App\Traits\LogsActivity;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Item\StoreOutgoingItemRequest;
use App\Http\Requests\Dashboard\Item\UpdateOutgoingItemRequest;
use Illuminate\Foundation\Validation\ValidatesRequests;

class OutgoingItemController extends Controller
{
    use ValidatesRequests;
    use LogsActivity;

    function __construct()
    {
        $this->middleware('permission:outgoing-item-list|outgoing-item-create|outgoing-item-edit|outgoing-item-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:outgoing-item-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:outgoing-item-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:outgoing-item-delete', ['only' => ['destroy', 'bulkDestroy']]);
        $this->middleware('permission:outgoing-item-download', ['only' => ['download', 'index']]);
    }

    public function index(): View
    {
        $title = 'Gas Keluar';
        $items = OutgoingItem::all();
        return view('dashboard.items.outgoing_items.index', compact('title', 'items'));
    }

    public function create()
    {
        return view('dashboard.items.outgoing_items.create');
    }

    public function store(StoreOutgoingItemRequest $request)
    {
        $validatedData = $request->validated();
        $validatedData['uuid'] = (string) Str::uuid();
        $validatedData['unit_price'] = str_replace(['Rp', ' ', ',', '.', "\xC2\xA0"], '', $validatedData['unit_price']);
        $validatedData['total_revenue'] = $validatedData['quantity_out'] * $validatedData['unit_price'];
        OutgoingItem::create($validatedData);
        return redirect()->route('outgoing-items.index')->with('success', 'Barang keluar berhasil ditambahkan.');
    }

    public function show(OutgoingItem $outgoingItem)
    {
        return view('dashboard.items.outgoing_items.show', compact('outgoingItem'));
    }

    public function edit(OutgoingItem $outgoingItem)
    {
        return view('dashboard.items.outgoing_items.edit', compact('outgoingItem'));
    }

    public function update(UpdateOutgoingItemRequest $request, OutgoingItem $outgoingItem)
    {
        $validatedData = $request->validated();
        $validatedData['unit_price'] = str_replace(['Rp', ' ', ',', '.', "\xC2\xA0"], '', $validatedData['unit_price']);
        $validatedData['unit_price'] = round($validatedData['unit_price']);
        $validatedData['total_revenue'] = round($validatedData['quantity_out'] * $validatedData['unit_price']);
        $outgoingItem->update($validatedData);
        return redirect()->route('outgoing-items.index')->with('success', 'Barang keluar berhasil diperbarui.');
    }

    public function destroy(OutgoingItem $outgoingItem)
    {
        $outgoingItem->delete();
        return redirect()->route('outgoing-items.index')->with('success', 'Barang keluar berhasil dihapus.');
    }
}
