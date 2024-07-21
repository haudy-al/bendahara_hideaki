<?php

namespace App\Livewire;

use App\Models\Transaction;
use App\Models\User;
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
        $saldo = $this->saldo();
        $totalSiswa = count($this->siswa());
        return view('livewire.dashboard', compact('pengeluaran', 'pemasukan', 'monthlyData', 'months','saldo','totalSiswa'));
    }
    function saldo()
    {
        $income = Transaction::where('type', 'income')->sum('amount');
        $expense = Transaction::where('type', 'expense')->sum('amount');
        return $income - $expense;
    }

    function siswa()
    {
        $data = User::all();
        return $data;
    }
}
