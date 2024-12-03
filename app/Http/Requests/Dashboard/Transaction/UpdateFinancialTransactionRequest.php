<?php

namespace App\Http\Requests\Dashboard\Transaction;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFinancialTransactionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
    {
        // Check if the user has the 'edit financial transaction' permission
        return $this->user()->can('transaction-edit');
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules()
    {
        return [
            'transaction_date' => 'required|date',
            'transaction_type' => 'required|string',
            'transaction_description' => 'required|string',
            'agent_client_name' => 'required|string',
            'unit_quantity' => 'required|integer',
            'unit_price' => 'required|string',
            'payment_method' => 'required|string',
            'payment_status' => 'required|string|in:Paid,Unpaid,Partial',
            'expense_category' => 'nullable|string',
            'additional_notes' => 'nullable|string',
        ];
    }
}
