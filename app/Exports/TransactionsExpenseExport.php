<?php

namespace App\Exports;

use App\Models\Transaction;
use Maatwebsite\Excel\Concerns\FromCollection;

class TransactionsExpenseExport implements FromCollection
{
    protected $transactions;

    public function __construct($transactions)
    {
        $this->transactions = $transactions;
    }

    public function collection()
    {
        return $this->transactions->map(function ($transaction) {
            return [
                'id' => $transaction->id,
                'user_name' => $transaction->user->name,
                'date' => $transaction->date,
                'amount' => $transaction->amount,
                'description' => $transaction->description,
                'type' => $transaction->type,
                'created_at' => $transaction->created_at,
                'updated_at' => $transaction->updated_at,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'ID',
            'User Name',
            'Date',
            'Amount',
            'Description',
            'Type',
            'Created At',
            'Updated At',
        ];
    }
}
