<?php
namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class TransactionsExport implements FromCollection, WithHeadings, WithColumnFormatting
{
    protected $transactions;

    public function __construct($transactions)
    {
        $this->transactions = $transactions;
    }

    public function collection()
    {
        // Separate transactions by type_amount
        $groupedTransactions = $this->transactions->groupBy(function ($transaction) {
            return $transaction->type_amount == 'others' ? uniqid() : $transaction->user_id;
        })->map(function ($transactions, $key) {
            if ($transactions->first()->type_amount == 'others') {
                return $transactions->map(function ($transaction) {
                    return [
                        'id' => $transaction->id,
                        'user_name' => $transaction->user->name,
                        'date' => $transaction->date,
                        'amount' => $transaction->amount,
                        'description' => $transaction->description,
                        'type' => $transaction->type,
                        'type_amount' => $transaction->type_amount,
                        'created_at' => $transaction->created_at,
                        'updated_at' => $transaction->updated_at,
                    ];
                });
            } else {
                $first = $transactions->first();
                $totalAmount = $transactions->sum('amount');
                return [[
                    'id' => $first->id,
                    'user_name' => $first->user->name,
                    'date' => $first->date,
                    'amount' => $totalAmount,
                    'description' => $first->description,
                    'type' => $first->type,
                    'type_amount' => $first->type_amount,
                    'created_at' => $first->created_at,
                    'updated_at' => $first->updated_at,
                ]];
            }
        })->flatten(1);

        // Calculate total amount
        $totalAmount = $this->transactions->sum('amount');
        
        // Add total amount row
        $groupedTransactions->push([
            'id' => '',
            'user_name' => '',
            'date' => '',
            'amount' => $totalAmount,
            'description' => 'Total Amount',
            'type' => '',
            'type_amount' => '',
            'created_at' => '',
            'updated_at' => '',
        ]);

        return $groupedTransactions->values();
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
            'Type Amount',
            'Created At',
            'Updated At',
        ];
    }

    public function columnFormats(): array
    {
        return [
            'D' => NumberFormat::FORMAT_NUMBER_00, // Assuming 'D' is the column for 'Amount'
        ];
    }
}

