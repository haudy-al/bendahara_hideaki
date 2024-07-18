<?php
namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class TransactionsExport implements FromCollection, WithHeadings, WithStyles, WithColumnWidths
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
            'user_name' => '',
            'date' => '',
            'amount' => $totalAmount,
            'description' => 'Total Amount',
            'type' => '',
            'type_amount' => '',
            'created_at' => '',
            'updated_at' => '',
        ]);

        // Add sequence number
        $groupedTransactionsWithNumber = $groupedTransactions->values()->map(function ($item, $key) {
            return array_merge(['number' => $key + 1], $item);
        });

        return $groupedTransactionsWithNumber;
    }

    public function headings(): array
    {
        return [
            'No',
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

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:I1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'color' => ['rgb' => '079707'],
            ],
        ]);

        // Auto size columns
        foreach (range('A', 'I') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        return [];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 5,
            'B' => 20,
            'C' => 15,
            'D' => 15,
            'E' => 30,
            'F' => 15,
            'G' => 15,
            'H' => 20,
            'I' => 20,
        ];
    }
}
