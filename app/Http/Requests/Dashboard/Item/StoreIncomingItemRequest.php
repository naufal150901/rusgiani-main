<?php

namespace App\Http\Requests\Dashboard\Item;

use Illuminate\Foundation\Http\FormRequest;

class StoreIncomingItemRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
    {
        // Check if the user has the 'create financial transaction' permission
        return $this->user()->can('incoming-item-create');
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules()
    {
        return [
            'uuid' => 'required|string|unique:incoming_items,uuid',
            'in_date' => 'required|date',
            'gas_type' => 'required|string',
            'quantity_in' => 'required|integer',
            'unit_price' => 'required|numeric',
            'total_cost' => 'required|numeric',
            'supplier' => 'required|string',
            'batch_number' => 'nullable|string',
            'warehouse_location' => 'nullable|string',
            'additional_notes' => 'nullable|string',
        ];
    }
}
