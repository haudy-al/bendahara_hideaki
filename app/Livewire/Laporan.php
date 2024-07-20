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
        // dd($this->getTransactionMonthIncome());

        return view('livewire.laporan', [
            'DataTransaction' => $this->getTransaction('income'),
            'DataTransactionsExpense' => $this->getTransaction('expense'),
            'DataTransactionMonthIncome' => $this->getTransactionMonth('income'),
            'DataTransactionMonthExpense' => $this->getTransactionMonth('expense'),
        ]);
    }

    function getTransaction($type) {
        $startOfMonth = Carbon::create($this->month)->startOfMonth();
        $startDate = $startOfMonth->copy()->addWeeks($this->week - 1);
        $endDate = $startDate->copy()->endOfWeek();

        $DataTransactions = Transaction::with('user')
            ->where('type', $type)
            ->whereBetween('date', [$startDate, $endDate])
            ->get();

        return $DataTransactions;
    }

    function getTransactionMonth($type)
    {
        [$year, $month] = explode('-', $this->month);


        $transactions = Transaction::with('user')
            ->where('type', $type)
            ->whereYear('date', $year)
            ->whereMonth('date', $month)
            ->get();

        return $transactions;
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

        return Excel::download(new TransactionsExport($transactions, $type), 'transactions_' . $this->month . '__week_' . $this->week . '.xlsx');
    }

    public function exportMonth($type = 'income')
    {
        [$year, $month] = explode('-', $this->month);

        $transactions = Transaction::with('user')
            ->where('type', $type)
            ->whereYear('date', $year)
            ->whereMonth('date', $month)
            ->get();

        return Excel::download(new TransactionsExport($transactions, $type), 'transactions_' . $this->month . '__week_' . '.xlsx');
    }
}
