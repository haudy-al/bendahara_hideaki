<?php

namespace App\Livewire;

use App\Models\Transaction;
use Livewire\Component;

class Dashboard extends Component
{
    public function render()
{
    $pengeluaran = Transaction::where('type', 'expense')->sum('amount');
    $pemasukan = Transaction::where('type', 'income')->sum('amount');

    $monthlyData = Transaction::selectRaw('YEAR(date) year, MONTH(date) month, SUM(CASE WHEN type = "income" THEN amount ELSE 0 END) as total_income, SUM(CASE WHEN type = "expense" THEN amount ELSE 0 END) as total_expense')
        ->groupBy('year', 'month')
        ->get();

    $months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

    return view('livewire.dashboard', compact('pengeluaran', 'pemasukan', 'monthlyData', 'months'));
}
}
