<?php

namespace App\Livewire;

use App\Exports\TransactionsExpenseExport;
use App\Exports\TransactionsExport;
use App\Models\Transaction;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class Laporan extends Component
{
    use WithPagination;
    public $month;
    public $week;
    function mount()
    {
        $this->month = Carbon::now()->format('Y-m');
        $this->week = Carbon::now()->weekOfYear;
    }


    public function render()
    {
        

        $startOfMonth = Carbon::create($this->month)->startOfMonth();
        $startDate = $startOfMonth->copy()->addWeeks($this->week - 1);
        $endDate = $startDate->copy()->endOfWeek();

        $DataTransactions = Transaction::with('user')
            ->where('type', 'income')
            ->whereBetween('date', [$startDate, $endDate])
            ->get();

        $DataTransactionsExpense = Transaction::with('user')
            ->where('type', 'expense')
            ->whereBetween('date', [$startDate, $endDate])
            ->get();

        // dd($DataTransactions);

        return view('livewire.laporan', [
            'DataTransaction' => $DataTransactions,
            'DataTransactionsExpense' => $DataTransactionsExpense,
        ]);
    }

    public function export($type = 'income')
    {
        $startOfMonth = Carbon::create($this->month)->startOfMonth();
        $startDate = $startOfMonth->copy()->addWeeks($this->week - 1);
        $endDate = $startDate->copy()->endOfWeek();

        $transactions = Transaction::with('user')
            ->where('type', $type)
            ->whereBetween('date', [$startDate, $endDate])
            ->get();

            return Excel::download(new TransactionsExport($transactions,$type), 'transactions_'.$this->month.'__week_' . $this->week . '.xlsx');
 
    }

}
