<?php

namespace App\Livewire;

use App\Exports\TransactionsExport;
use App\Models\Transaction;
use Carbon\Carbon;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;

class Laporan extends Component
{
    public $month;
    public $week;

    public function render()
    {
        return view('livewire.laporan');
    }



    public function export()
    {
        $startOfMonth = Carbon::create($this->month)->startOfMonth();
        $startDate = $startOfMonth->copy()->addWeeks($this->week - 1);
        $endDate = $startDate->copy()->endOfWeek();

        $transactions = Transaction::with('user')
            ->where('type', 'income')

            ->whereBetween('date', [$startDate, $endDate])
            ->get();

        return Excel::download(new TransactionsExport($transactions), 'transactions_week_' . $this->week . '.xlsx');
    }
}
