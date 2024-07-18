<?php

namespace App\Livewire;

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
        // $defaultWeek = Carbon::now()->weekOfYear;
        // $defaultMonth = Carbon::now()->format('Y-m');;

        // if ($this->week) {
        //     $defaultWeek = $this->week;
        // }if ($this->month) {
        //     $defaultMonth = $this->month;
        // }

        $startOfMonth = Carbon::create($this->month)->startOfMonth();
        $startDate = $startOfMonth->copy()->addWeeks($this->week - 1);
        $endDate = $startDate->copy()->endOfWeek();

        $DataTransactions = Transaction::with('user')
            ->where('type', 'income')
            ->whereBetween('date', [$startDate, $endDate])
            ->get();

        // dd($DataTransactions);


        return view('livewire.laporan', [
            'DataTransaction' => $DataTransactions
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

        return Excel::download(new TransactionsExport($transactions), 'transactions_week_' . $this->week . '.xlsx');
    }
}
