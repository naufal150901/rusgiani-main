<?php

namespace App\Models\Transaction;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinancialTransaction extends Model
{
    use HasFactory;
    protected $table = 'financial_transactions';
    protected $fillable = [
        'uuid',
        'transaction_date',
        'transaction_type',
        'transaction_description',
        'agent_client_name',
        'unit_quantity',
        'unit_price',
        'total_amount',
        'payment_method',
        'payment_status',
        'expense_category',
        'additional_notes',
    ];
}
