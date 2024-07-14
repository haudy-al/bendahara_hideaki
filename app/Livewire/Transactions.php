<?php

namespace App\Livewire;

use App\Models\Transaction;
use App\Models\User;
use Livewire\Component;
use Carbon\Carbon;
use Livewire\WithPagination;

class Transactions extends Component
{
    use WithPagination;

    public $statusBtnAdd = false;
    public $typeAdd = 'uang_makan_siswa';
    public $startOfWeek;
    public $search;
    public $SearchSiswa;

    public $displayAmount = '';
    public $amount = 0;
    public $amountGlobal = 0;
    public $siswa = '';
    public $dateIncome;
    public $deskripsi = '';

    public $price_meal = 5000;

    public $check_senin = true;
    public $check_selasa = true;
    public $check_rabu = true;
    public $check_kamis = true;
    public $check_jumat = true;

    public $count_meal_senin = 2;
    public $count_meal_selasa = 2;
    public $count_meal_rabu = 2;
    public $count_meal_kamis = 2;
    public $count_meal_jumat = 2;

    protected $listeners = ['DeleteTransactionEmit' => 'DeleteTransaction'];


    public function mount()
    {
        $this->updateTotalAmount();
    }

    function getDataTransaction()
    {
        $DataTransaction = Transaction::orderBy('created_at', 'DESC')->paginate(10);
        return $DataTransaction;
    }

    function searchDataTransaction()
    {
        $transactions = Transaction::whereHas('user', function ($query) {
            $query->where('name', 'like', '%' . $this->search . '%');
        })
            ->orWhere('description', 'like', '%' . $this->search . '%')
            ->orWhere('amount', 'like', '%' . $this->search . '%')
            ->orderBy('date', 'DESC')
            ->paginate(10);
        return $transactions;
    }

    public function render()
    {
        $DataTransaction = $this->getDataTransaction();
        if ($this->search) {
            $DataTransaction = $this->searchDataTransaction();
        }

        $dataSiswa = User::all();
        if ($this->SearchSiswa) {
            $dataSiswa = User::where('name', 'like', '%' . $this->SearchSiswa . '%')
                ->limit(5)
                ->get();
        }

        return view('livewire.transactions', [
            'DataTransaction' => $DataTransaction,
            'DataSiswa' => $dataSiswa,
            'saldo' => $this->saldo()
        ]);
    }

    function callRender()
    {
        $this->render();
    }

    function setSiswa($id)
    {

        $this->siswa = $id;
        $this->SearchSiswa = '';
    }

    function saldo()
    {
        $income = Transaction::where('type', 'income')->sum('amount');
        $expense = Transaction::where('type', 'expense')->sum('amount');
        return $income - $expense;
    }

    function btnAdd($type = 'income')
    {
        $this->statusBtnAdd = true;
        if ($type == 'income') {
            $this->typeAdd = 'uang_makan_siswa';
        } elseif ($type = 'expense') {
            $this->typeAdd = 'input_expense';
        }
    }

    function btnCloseAdd()
    {
        $this->statusBtnAdd = false;
        $this->typeAdd = 'uang_makan_siswa';
    }



    public function updated($propertyName)
    {
        $this->updateTotalAmount();
    }

    public function updateTotalAmount()
    {
        $days = [
            'senin' => $this->check_senin ? $this->count_meal_senin : 0,
            'selasa' => $this->check_selasa ? $this->count_meal_selasa : 0,
            'rabu' => $this->check_rabu ? $this->count_meal_rabu : 0,
            'kamis' => $this->check_kamis ? $this->count_meal_kamis : 0,
            'jumat' => $this->check_jumat ? $this->count_meal_jumat : 0,
        ];

        $totalMeals = array_sum($days);
        $this->amount = $totalMeals * $this->price_meal;
    }

    public function saveTransactions()
    {
        $this->validate([
            'siswa' => 'required',
            'startOfWeek' => 'required'
        ], [
            'siswa.required' => 'Data Siswa Wajib Diisi',
            'startOfWeek.required' => 'Data Tanggal Wajib Diisi'
        ]);
        $days = ['senin', 'selasa', 'rabu', 'kamis', 'jumat'];
        $startOfWeek = new Carbon($this->startOfWeek);
        $nextWeek = $startOfWeek->copy()->addWeek();

        foreach ($days as $day) {
            if ($this->{'check_' . $day}) {
                $nextDay = $nextWeek->copy()->startOfWeek()->addDays(array_search($day, $days));
                $transaction = new Transaction();
                $transaction->user_id = $this->siswa;
                $transaction->date = $nextDay;
                $transaction->amount = $this->{'count_meal_' . $day} * $this->price_meal;
                $transaction->description = 'Uang makan';
                $transaction->type = 'income';
                $transaction->save();
            }
        }

        $this->startOfWeek = null;
        $this->statusBtnAdd = false;
        $this->siswa = '';

        $this->dispatch('success', ['message' => 'Data Berhasil Ditambahkan']);
    }

    public function validateDay($date)
    {
        $selectedDate = new Carbon($date);
        $day = $selectedDate->dayOfWeek; // 0 = Minggu, 1 = Senin, ..., 6 = Sabtu
        if ($day !== 0) {
            session()->flash('error', 'Silakan pilih hari Minggu sebagai awal minggu pembayaran.');
        }
    }

    function submit()
    {
        // dd($this->all());
        $this->saveTransactions();
    }

    function AddIncomeLainnya()
    {
        $this->validate([
            'siswa' => 'required',
            'dateIncome' => 'required',
            'amountGlobal' => 'required',
            'deskripsi' => 'required'
        ], [
            'siswa.required' => 'Data Siswa Wajib Diisi',
            'dateIncome.required' => 'Data Tanggal Wajib Diisi',
            'deskripsi.required' => 'Data deskripsi Wajib Diisi',
            'amountGlobal.required' => 'Jumlah Uang Wajib Diisi'
        ]);

        $transaction = new Transaction();
        $transaction->user_id = $this->siswa;
        $transaction->date = $this->dateIncome;
        $transaction->amount = $this->amountGlobal;
        $transaction->description = $this->deskripsi;
        $transaction->type = 'income';
        $transaction->save();

        $this->dateIncome = null;
        $this->statusBtnAdd = false;
        $this->siswa = '';
        $this->amountGlobal = 0;
        $this->deskripsi = '';

        $this->dispatch('success', ['message' => 'Data Berhasil Ditambahkan']);
    }

    function AddExpense()
    {
        $this->validate([
            'siswa' => 'required',
            'dateIncome' => 'required',
            'amountGlobal' => 'required',
            'deskripsi' => 'required'
        ], [
            'siswa.required' => 'Data Siswa Wajib Diisi',
            'dateIncome.required' => 'Data Tanggal Wajib Diisi',
            'deskripsi.required' => 'Data deskripsi Wajib Diisi',
            'amountGlobal.required' => 'Jumlah Uang Wajib Diisi'
        ]);

        $transaction = new Transaction();
        $transaction->user_id = $this->siswa;
        $transaction->date = $this->dateIncome;
        $transaction->amount = $this->amountGlobal;
        $transaction->description = $this->deskripsi;
        $transaction->type = 'expense';
        $transaction->save();

        $this->dateIncome = null;
        $this->statusBtnAdd = false;
        $this->siswa = '';
        $this->amountGlobal = 0;
        $this->deskripsi = '';

        $this->dispatch('success', ['message' => 'Data Berhasil Ditambahkan']);
    }

    function DeleteTransaction($id)
    {
        $data = Transaction::where('id', $id)->get()->first();
        if ($data) {
            $data->delete();
        }

        $this->dispatch('danger', ['message' => 'Data Berhasil Dihapus']);
    }
}
