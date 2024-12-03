<?php

namespace App\Http\Requests\Dashboard\Item;

use Illuminate\Foundation\Http\FormRequest;

class UpdateIncomingItemRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
    {
        // Check if the user has the 'create financial transaction' permission
        return $this->user()->can('incoming-item-edit');
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules()
    {
        return [
            'uuid' => 'required|string|unique:outgoing_items,uuid',
            'out_date' => 'required|date',
            'gas_type' => 'required|string',
            'quantity_out' => 'required|integer',
            'unit_price' => 'required|numeric',
            'total_revenue' => 'required|numeric',
            'recipient' => 'required|string',
            'shipment_number' => 'required|string',
            'shipment_method' => 'required|string',
            'warehouse_location' => 'required|string',
            'shipment_status' => 'required|string|in:dalam_pengiriman,transit',
            'additional_notes' => 'nullable|string',
        ];
    }
}
