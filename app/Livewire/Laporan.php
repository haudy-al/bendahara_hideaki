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
    public $date;
    function mount()
    {
        $this->month = Carbon::now()->format('Y-m');
        $this->week = Carbon::now()->weekOfYear;
    }


    public function render()
    {
        // dd($this->getTransactionMonthIncome());

        if ($this->date) {
            $date = Carbon::create($this->date);

            $this->month = $date->format('Y-m');
        }

        return view('livewire.laporan', [
            'DataTransaction' => $this->getTransaction('income'),
            'DataTransactionsExpense' => $this->getTransaction('expense'),
            'DataTransactionMonthIncome' => $this->getTransactionMonth('income'),
            'DataTransactionMonthExpense' => $this->getTransactionMonth('expense'),
        ]);
    }

    public function updatedDate()
    {
        $date = Carbon::create($this->date);

        if ($date->dayOfWeek !== Carbon::SUNDAY) {
            $this->date = null;
            $this->dispatch('danger', ['message' => 'Silahkan Pilih Hari Minggu']);

        }
    }

    function getTransaction($type)
    {
        // $startOfMonth = Carbon::create($this->month)->startOfMonth();
        // $startDate = $startOfMonth->copy()->addWeeks($this->week - 1);

        // $endDate = $startDate->copy()->addDays(5);

        if ($this->date) {
            $this->updatedDate();
            
        }

        $startDate = Carbon::create($this->date);
        $endDate = $startDate->copy()->addDays(6);

        $DataTransactions = Transaction::with(['user' => function ($query) {
            $query->orderBy('batch', 'DESC');
        }])
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
        // $startOfMonth = Carbon::create($this->month)->startOfMonth();
        // $startDate = $startOfMonth->copy()->addWeeks($this->week - 1);
        // $endDate = $startDate->copy()->endOfWeek();

        $startDate = Carbon::create($this->date);
        $endDate = $startDate->copy()->addDays(6);

        $transactions = Transaction::with(['user' => function ($query) {
            $query->orderBy('batch', 'DESC');
        }])
            ->where('type', $type)
            ->whereBetween('date', [$startDate, $endDate])
            ->get();

        return Excel::download(new TransactionsExport($transactions, $type), 'transactions_' . $this->date . '.xlsx');
    }

    public function exportMonth($type = 'income')
    {
        [$year, $month] = explode('-', $this->month);

        $transactions = Transaction::with('user')
            ->where('type', $type)
            ->whereYear('date', $year)
            ->whereMonth('date', $month)
            ->get();

        return Excel::download(new TransactionsExport($transactions, $type), 'transactions_' . $this->month . '.xlsx');
    }
}
