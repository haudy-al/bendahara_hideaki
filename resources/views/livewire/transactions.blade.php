<div>
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Transaksi</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/admin">Admin</a></li>
                            <li class="breadcrumb-item active">Transaksi</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            @if ($statusBtnAdd == true)
                                <div class="d-inline-block">
                                    <button class="btn btn-danger btn-sm " wire:click="btnCloseAdd">Batal <i
                                            class="fa-solid fa-xmark"></i></button>

                                    @if ($typeAdd == 'uang_makan_siswa' || $typeAdd == 'pemasukan_lainnya')
                                        <select name="" id="" wire:model.live='typeAdd'
                                            class="form-control ms-3 dropdown-toggle">
                                            <option value="uang_makan_siswa">Uang Makan Siswa</option>
                                            <option value="pemasukan_lainnya">Pemasukan Lainnya</option>
                                        </select>
                                    @elseif ($typeAdd == 'input_expense')
                                        <select name="" id="" disabled
                                            class="form-control ms-3 dropdown-toggle">
                                            <option value="" selected>Pengeluaran</option>
                                        </select>
                                    @endif
                                </div>
                            @else
                                <button class="btn btn-primary btn-sm" wire:click="btnAdd">Tambah Pemasukan <i
                                        class="fa-solid fa-plus"></i></button>
                                <button class="btn btn-outline-danger btn-sm" wire:click="btnAdd('expense')">Tambah
                                    Pengeluaran <i class="fa-solid fa-plus"></i></button>
                            @endif

                        </h3>

                        <div class="card-tools">
                            <h4>
                                <b>Saldo : Rp.{{ number_format($saldo, 0, ',', '.') }}</b>
                            </h4>

                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0" style="height: 400px;">
                        @if ($statusBtnAdd == true)
                            <div class="card">
                                {{-- <div class="card-header">
                              <h3 class="card-title"></h3>
                            </div> --}}
                                <div class="card-body">
                                    @if ($typeAdd == 'uang_makan_siswa')
                                        <div class="mb-3">

                                            <form>
                                                <div class="row">

                                                    <div class="col-md-6">
                                                        <div class="mb-3 position-relative">
                                                            <label for="NamaU" class="form-label">Siswa</label>
                                                            <div class="input-group">

                                                                <select wire:model="siswa" id="selectOp"
                                                                    class="form-control searchSelect"
                                                                    @if (!empty($SearchSiswa)) disabled @endif>
                                                                    <option value=""
                                                                        @if (!$siswa) selected @endif>
                                                                        ----Pilih----</option>

                                                                    @foreach ($DataSiswa as $item)
                                                                        <option
                                                                            @if ($siswa == $item->id) selected @endif
                                                                            value="{{ $item->id }}">
                                                                            {{ $item->name }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                                <input type="text" placeholder="Cari Siswa..."
                                                                    class="form-control" wire:model.live="SearchSiswa">

                                                            </div>

                                                            @if (!empty($SearchSiswa))
                                                                <div class="mb-3 mt-3">
                                                                    @foreach ($DataSiswa as $item)
                                                                        <ul>
                                                                            <li><span
                                                                                    wire:click="setSiswa({{ $item->id }})">({{ $item->batch }}){{ $item->name }}</span>
                                                                            </li>
                                                                        </ul>
                                                                    @endforeach
                                                                </div>
                                                            @endif

                                                            @error('siswa')
                                                                <span class="text-danger">
                                                                    {{ $message }}
                                                                </span>
                                                            @enderror

                                                        </div>
                                                        <div class="mb-3">
                                                            <div>
                                                                <div class="input-group mb-3">
                                                                    <span class="input-group-text"
                                                                        id="basic-addon1">Rp.</span>
                                                                    <input disabled type="number"
                                                                        wire:model.live="amount" class="form-control"
                                                                        placeholder="Total Uang" aria-label="Total Uang"
                                                                        aria-describedby="basic-addon1">
                                                                </div>
                                                            </div>

                                                        </div>

                                                        <div class="mb-3">
                                                            <label for="startOfWeek" class="form-label">Mulai Minggu
                                                                Pembayaran</label>
                                                            <input type="date" class="form-control" id="cutomDate1"
                                                                wire:model="startOfWeek" onchange="validateDay(this)">

                                                            @error('startOfWeek')
                                                                <span class="text-danger">
                                                                    {{ $message }}
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="card">

                                                            <div class="card-body">
                                                                <div
                                                                    class="form-group clearfix mb-3 d-flex justify-content-between align-items-center">
                                                                    <div class="icheck-primary d-inline">
                                                                        <input type="checkbox" id="checkboxPrimary1"
                                                                            wire:model.live="check_senin">
                                                                        <label for="checkboxPrimary1">Senin</label>
                                                                    </div>
                                                                    <div>
                                                                        <input
                                                                            class="ms-3 w-75 custom-number-meal form-control"
                                                                            type="number" min="1" max="2"
                                                                            wire:model.live="count_meal_senin">
                                                                    </div>
                                                                </div>
                                                                <div
                                                                    class="form-group clearfix mb-3 d-flex justify-content-between align-items-center">
                                                                    <div class="icheck-primary d-inline">
                                                                        <input type="checkbox" id="checkboxPrimary2"
                                                                            wire:model.live="check_selasa">
                                                                        <label for="checkboxPrimary2">Selasa</label>
                                                                    </div>
                                                                    <div>
                                                                        <input
                                                                            class="ms-3 w-75 custom-number-meal form-control"
                                                                            type="number" min="1"
                                                                            max="2"
                                                                            wire:model.live="count_meal_selasa">
                                                                    </div>
                                                                </div>
                                                                <div
                                                                    class="form-group clearfix mb-3 d-flex justify-content-between align-items-center">
                                                                    <div class="icheck-primary d-inline">
                                                                        <input type="checkbox" id="checkboxPrimary3"
                                                                            wire:model.live="check_rabu">
                                                                        <label for="checkboxPrimary3">Rabu</label>
                                                                    </div>
                                                                    <div>
                                                                        <input
                                                                            class="ms-3 w-75 custom-number-meal form-control"
                                                                            type="number" min="1"
                                                                            max="2"
                                                                            wire:model.live="count_meal_rabu">
                                                                    </div>
                                                                </div>
                                                                <div
                                                                    class="form-group clearfix mb-3 d-flex justify-content-between align-items-center">
                                                                    <div class="icheck-primary d-inline">
                                                                        <input type="checkbox" id="checkboxPrimary4"
                                                                            wire:model.live="check_kamis">
                                                                        <label for="checkboxPrimary4">Kamis</label>
                                                                    </div>
                                                                    <div>
                                                                        <input
                                                                            class="ms-3 w-75 custom-number-meal form-control"
                                                                            type="number" min="1"
                                                                            max="2"
                                                                            wire:model.live="count_meal_kamis">
                                                                    </div>
                                                                </div>
                                                                <div
                                                                    class="form-group clearfix mb-3 d-flex justify-content-between align-items-center">
                                                                    <div class="icheck-primary d-inline">
                                                                        <input type="checkbox" id="checkboxPrimary5"
                                                                            wire:model.live="check_jumat">
                                                                        <label for="checkboxPrimary5">Jum'at</label>
                                                                    </div>
                                                                    <div>
                                                                        <input
                                                                            class="ms-3 w-75 custom-number-meal form-control"
                                                                            type="number" min="1"
                                                                            max="2"
                                                                            wire:model.live="count_meal_jumat">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>



                                                <button type="button" wire:click="submit"
                                                    class="btn btn-primary">Simpan</button>
                                            </form>

                                        </div>
                                    @elseif ($typeAdd == 'pemasukan_lainnya')
                                        <div class="mb-3">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="mb-3 position-relative">
                                                        <label for="NamaU" class="form-label">Siswa</label>
                                                        <div class="input-group">

                                                            <select wire:model="siswa" id="selectOp"
                                                                class="form-control searchSelect"
                                                                @if (!empty($SearchSiswa)) disabled @endif>
                                                                <option value=""
                                                                    @if (!$siswa) selected @endif>
                                                                    ----Pilih----</option>

                                                                @foreach ($DataSiswa as $item)
                                                                    <option
                                                                        @if ($siswa == $item->id) selected @endif
                                                                        value="{{ $item->id }}">{{ $item->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                            <input type="text" placeholder="Cari Siswa..."
                                                                class="form-control" wire:model.live="SearchSiswa">

                                                        </div>

                                                        @if (!empty($SearchSiswa))
                                                            <div class="mb-3 mt-3">
                                                                @foreach ($DataSiswa as $item)
                                                                    <ul>
                                                                        <li><span
                                                                                wire:click="setSiswa({{ $item->id }})">({{ $item->batch }}){{ $item->name }}</span>
                                                                        </li>
                                                                    </ul>
                                                                @endforeach
                                                            </div>
                                                        @endif

                                                        @error('siswa')
                                                            <span class="text-danger">
                                                                {{ $message }}
                                                            </span>
                                                        @enderror

                                                    </div>
                                                    <div class="mb-3">
                                                        <div>
                                                            <div class="input-group mb-3">
                                                                <span class="input-group-text"
                                                                    id="basic-addon1">Rp.</span>
                                                                <input type="number" wire:model.live="amountGlobal"
                                                                    class="form-control" placeholder="Total Uang"
                                                                    aria-label="Total Uang"
                                                                    aria-describedby="basic-addon1">
                                                            </div>
                                                            @error('amountGlobal')
                                                                <span class="text-danger">
                                                                    {{ $message }}
                                                                </span>
                                                            @enderror
                                                        </div>

                                                    </div>

                                                    <div class="mb-3">
                                                        <label for="NamaU" class="form-label">Tanggal</label>
                                                        <input type="date" class="form-control"
                                                            wire:model="dateIncome">
                                                        @error('dateIncome')
                                                            <span class="text-danger">
                                                                {{ $message }}
                                                            </span>
                                                        @enderror
                                                    </div>

                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="NamaU" class="form-label">Deskripsi</label>
                                                        <textarea type="date" class="form-control" wire:model="deskripsi"></textarea>
                                                        @error('deskripsi')
                                                            <span class="text-danger">
                                                                {{ $message }}
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <button class="btn btn-primary btn-sm" wire:click='AddIncomeLainnya'
                                                type="button">Simpan</button>
                                        </div>
                                    @elseif ($typeAdd = 'input_expense')
                                        <div class="mb-3">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="mb-3 position-relative">
                                                        <label for="NamaU" class="form-label">Siswa</label>
                                                        <div class="input-group">

                                                            <select wire:model="siswa" id="selectOp"
                                                                class="form-control searchSelect"
                                                                @if (!empty($SearchSiswa)) disabled @endif>
                                                                <option value=""
                                                                    @if (!$siswa) selected @endif>
                                                                    ----Pilih----</option>

                                                                @foreach ($DataSiswa as $item)
                                                                    <option
                                                                        @if ($siswa == $item->id) selected @endif
                                                                        value="{{ $item->id }}">
                                                                        {{ $item->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                            <input type="text" placeholder="Cari Siswa..."
                                                                class="form-control" wire:model.live="SearchSiswa">

                                                        </div>

                                                        @if (!empty($SearchSiswa))
                                                            <div class="mb-3 mt-3">
                                                                @foreach ($DataSiswa as $item)
                                                                    <ul>
                                                                        <li><span
                                                                                wire:click="setSiswa({{ $item->id }})">({{ $item->batch }}){{ $item->name }}</span>
                                                                        </li>
                                                                    </ul>
                                                                @endforeach
                                                            </div>
                                                        @endif

                                                        @error('siswa')
                                                            <span class="text-danger">
                                                                {{ $message }}
                                                            </span>
                                                        @enderror

                                                    </div>
                                                    <div class="mb-3">
                                                        <div>
                                                            <div class="input-group mb-3">
                                                                <span class="input-group-text"
                                                                    id="basic-addon1">Rp.</span>
                                                                <input type="number" wire:model.live="amountGlobal"
                                                                    class="form-control" placeholder="Total Uang"
                                                                    aria-label="Total Uang"
                                                                    aria-describedby="basic-addon1">
                                                            </div>
                                                            @error('amountGlobal')
                                                                <span class="text-danger">
                                                                    {{ $message }}
                                                                </span>
                                                            @enderror
                                                        </div>

                                                    </div>

                                                    <div class="mb-3">
                                                        <label for="NamaU" class="form-label">Tanggal</label>
                                                        <input type="date" class="form-control"
                                                            wire:model="dateIncome">
                                                        @error('dateIncome')
                                                            <span class="text-danger">
                                                                {{ $message }}
                                                            </span>
                                                        @enderror
                                                    </div>

                                                    <div class="mb-3">
                                                        <label for="NamaU" class="form-label">Jenis
                                                            Pengeluaran</label>

                                                        <select class="form-control" wire:model.live='type_amount'>
                                                            <option value="meal">Makanan</option>
                                                            <option value="others">Lainnya</option>
                                                        </select>

                                                        @error('type_amount')
                                                            <span class="text-danger">
                                                                {{ $message }}
                                                            </span>
                                                        @enderror
                                                    </div>

                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="NamaU" class="form-label">Deskripsi</label>
                                                        <textarea type="date" class="form-control" wire:model="deskripsi"></textarea>
                                                        @error('deskripsi')
                                                            <span class="text-danger">
                                                                {{ $message }}
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <button class="btn btn-primary btn-sm" wire:click='AddExpense'
                                                type="button">Simpan</button>
                                        </div>
                                    @endif
                                    {{-- <div class="form-group clearfix">
                                            <div class="icheck-primary d-inline">
                                                <input type="checkbox" id="checkboxPrimary1" checked>
                                                <label for="checkboxPrimary1">
                                                </label>
                                            </div>
                                            <div class="icheck-primary d-inline">
                                                <input type="checkbox" id="checkboxPrimary2">
                                                <label for="checkboxPrimary2">
                                                </label>
                                            </div>
                                            <div class="icheck-primary d-inline">
                                                <input type="checkbox" id="checkboxPrimary3" disabled>
                                                <label for="checkboxPrimary3">
                                                    Primary checkbox
                                                </label>
                                            </div>
                                        </div> 
                                    --}}
                                </div>
                                <!-- /.card-body -->

                            </div>
                        @endif
                        <div class="mb-3">
                            <input type="text" wire:model.live="search" class="form-control"
                                placeholder="Cari transaksi...">
                        </div>
                        <table class="table table-head-fixed text-nowrap">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama</th>
                                    <th>Jenis</th>
                                    <th>Tanggal</th>
                                    <th>Deskripsi</th>
                                    <th>Uang</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($DataTransaction as $key => $item)
                                    <tr>
                                        <td>{{ ($DataTransaction->currentPage() - 1) * $DataTransaction->perPage() + $key + 1 }}.
                                        </td>
                                        <td>{{ $item->user->name ?? '-' }}</td>
                                        <td>
                                            @php
                                                $colorStatus = 'danger';
                                                if ($item->type == 'income') {
                                                    $colorStatus = 'success';
                                                }
                                            @endphp

                                            <span class="badge bg-{{ $colorStatus }}">{{ $item->type }}</span>
                                        </td>
                                        <td id="tanggal-col">{{ $item->date }}</td>
                                        <td>{{ $item->description }}</td>
                                        <td>Rp.{{ number_format($item->amount, 0, ',', '.') }}</td>
                                        <td><Button onclick="confirmDelete({{ $item->id }})"
                                                class="btn btn-danger btn-sm"><i
                                                    class="fa-solid fa-trash-can"></i></Button></td>
                                    </tr>

                                    <script>
                                        function confirmDelete(itemId) {


                                            Swal.fire({
                                                title: 'Perhatian',
                                                text: "Yakin Menghapus Data Ini ?",
                                                icon: 'danger',
                                                showCancelButton: true,
                                                confirmButtonColor: '#3085d6',
                                                cancelButtonColor: '#d33',
                                                cancelButtonText: 'Batal',
                                                confirmButtonText: 'Ya'
                                            }).then((result) => {
                                                if (result.isConfirmed) {
                                                    Livewire.dispatch('DeleteTransactionEmit', {
                                                        "id": itemId
                                                    });
                                                    Swal.fire(
                                                        'Deleted!',
                                                        'Your file has been deleted.',
                                                        'success'
                                                    )
                                                }
                                            })
                                        }
                                    </script>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{ $DataTransaction->links('') }}
                    <!-- /.card-body -->
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    {{-- <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="col-md-4 col-12">
                    <div class="card">
                        <div class="card-body">
                            <h4><b>Saldo : Rp.{{ number_format($saldo, 0, ',', '.') }}</b> </h4>

                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div class="d-flex justify-content-between align-items-center w-100">
                            @if ($statusBtnAdd == true)
                                <button class="btn btn-danger btn-sm w-25" wire:click="btnCloseAdd">Batal <i
                                        class="fa-solid fa-xmark"></i></button>

                                @if ($typeAdd == 'uang_makan_siswa' || $typeAdd == 'pemasukan_lainnya')
                                    <div class="input-group ">
                                        <select name="" id="" wire:model.live='typeAdd'
                                            class="form-control ms-3 dropdown-toggle">
                                            <option value="uang_makan_siswa">Uang Makan Siswa</option>
                                            <option value="pemasukan_lainnya">Pemasukan Lainnya</option>
                                        </select>
                                        <span class="input-group-text" id="basic-addon1"></span>
                                    </div>
                                @elseif ($typeAdd == 'input_expense')
                                    <select name="" id="" disabled
                                        class="form-control ms-3 dropdown-toggle">
                                        <option value="" selected>Pengeluaran</option>
                                    </select>
                                @endif
                            @else
                                <button class="btn btn-primary btn-sm" wire:click="btnAdd">Tambah Pemasukan <i
                                        class="fa-solid fa-plus"></i></button>
                                <button class="btn btn-outline-danger btn-sm" wire:click="btnAdd('expense')">Tambah
                                    Pengeluaran <i class="fa-solid fa-plus"></i></button>
                            @endif
                        </div>

                        <!-- Elemen ini akan berada di pojok kanan atas -->
                        <div>
                        </div>
                    </div>
                    <div class="card-body">


                        @if ($statusBtnAdd == true)
                            @if ($typeAdd == 'uang_makan_siswa')
                                <div class="mb-3">

                                    <form>
                                        <div class="row">

                                            <div class="col-md-6">
                                                <div class="mb-3 position-relative">
                                                    <label for="NamaU" class="form-label">Siswa</label>
                                                    <div class="input-group">

                                                        <select wire:model="siswa" id="selectOp"
                                                            class="form-control searchSelect"
                                                            @if (!empty($SearchSiswa)) disabled @endif>
                                                            <option value=""
                                                                @if (!$siswa) selected @endif>
                                                                ----Pilih----</option>

                                                            @foreach ($DataSiswa as $item)
                                                                <option
                                                                    @if ($siswa == $item->id) selected @endif
                                                                    value="{{ $item->id }}">{{ $item->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        <input type="text" placeholder="Cari Siswa..."
                                                            class="form-control" wire:model.live="SearchSiswa">

                                                    </div>

                                                    @if (!empty($SearchSiswa))
                                                        <div class="mb-3 mt-3">
                                                            @foreach ($DataSiswa as $item)
                                                                <ul>
                                                                    <li><span
                                                                            wire:click="setSiswa({{ $item->id }})">({{ $item->batch }}){{ $item->name }}</span>
                                                                    </li>
                                                                </ul>
                                                            @endforeach
                                                        </div>
                                                    @endif

                                                    @error('siswa')
                                                        <span class="text-danger">
                                                            {{ $message }}
                                                        </span>
                                                    @enderror

                                                </div>
                                                <div class="mb-3">
                                                    <div>
                                                        <div class="input-group mb-3">
                                                            <span class="input-group-text" id="basic-addon1">Rp.</span>
                                                            <input disabled type="number" wire:model.live="amount"
                                                                class="form-control" placeholder="Total Uang"
                                                                aria-label="Total Uang" aria-describedby="basic-addon1">
                                                        </div>
                                                    </div>

                                                </div>

                                                <div class="mb-3">
                                                    <label for="startOfWeek" class="form-label">Mulai Minggu
                                                        Pembayaran</label>
                                                    <input type="date" class="form-control" id="cutomDate1"
                                                        wire:model="startOfWeek" onchange="validateDay(this)">

                                                    @error('startOfWeek')
                                                        <span class="text-danger">
                                                            {{ $message }}
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="card">

                                                    <div class="card-body">

                                                        <div
                                                            class="mb-3 d-flex justify-content-between align-items-center">
                                                            <div class="form-check ">
                                                                <label class="form-check-label"
                                                                    for="check-senin">Senin</label>
                                                                <input type="checkbox" class="form-check-input"
                                                                    id="check-senin" wire:model.live="check_senin">

                                                            </div>
                                                            <div>
                                                                <input class="ms-3 w-75 custom-number-meal"
                                                                    type="number" min="1" max="2"
                                                                    wire:model.live="count_meal_senin">
                                                            </div>
                                                        </div>

                                                        <div
                                                            class="mb-3 d-flex justify-content-between align-items-center">
                                                            <div class="form-check">
                                                                <label class="form-check-label"
                                                                    for="check-selasa">Selasa</label>
                                                                <input type="checkbox" class="form-check-input"
                                                                    id="check-selasa" wire:model.live="check_selasa">
                                                            </div>
                                                            <div>
                                                                <input class="ms-3 w-75 custom-number-meal"
                                                                    type="number" min="1" max="2"
                                                                    wire:model.live="count_meal_selasa">
                                                            </div>
                                                        </div>
                                                        <div
                                                            class="mb-3 d-flex justify-content-between align-items-center">
                                                            <div class="form-check">
                                                                <label class="form-check-label"
                                                                    for="check-rabu">Rabu</label>
                                                                <input type="checkbox" class="form-check-input"
                                                                    id="check-rabu" wire:model.live="check_rabu">
                                                            </div>
                                                            <div>
                                                                <input class="ms-3 w-75 custom-number-meal"
                                                                    type="number" min="1" max="2"
                                                                    wire:model.live="count_meal_rabu">
                                                            </div>
                                                        </div>
                                                        <div
                                                            class="mb-3 d-flex justify-content-between align-items-center">
                                                            <div class="form-check">
                                                                <label class="form-check-label"
                                                                    for="check-kamis">Kamis</label>
                                                                <input type="checkbox" class="form-check-input"
                                                                    id="check-kamis" wire:model.live="check_kamis">
                                                            </div>
                                                            <div>
                                                                <input class="ms-3 w-75 custom-number-meal"
                                                                    type="number" min="1" max="2"
                                                                    wire:model.live="count_meal_kamis">
                                                            </div>
                                                        </div>
                                                        <div
                                                            class="mb-3 d-flex justify-content-between align-items-center">
                                                            <div class="form-check">
                                                                <label class="form-check-label"
                                                                    for="check-jumat">Jum'at</label>
                                                                <input type="checkbox" class="form-check-input"
                                                                    id="check-jumat" wire:model.live="check_jumat">
                                                            </div>
                                                            <div>
                                                                <input class="ms-3 w-75 custom-number-meal"
                                                                    type="number" min="1" max="2"
                                                                    wire:model.live="count_meal_jumat">
                                                            </div>
                                                        </div>


                                                    </div>
                                                </div>
                                            </div>
                                        </div>



                                        <button type="button" wire:click="submit"
                                            class="btn btn-primary">Simpan</button>
                                    </form>

                                </div>
                            @elseif ($typeAdd == 'pemasukan_lainnya')
                                <div class="mb-3">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3 position-relative">
                                                <label for="NamaU" class="form-label">Siswa</label>
                                                <div class="input-group">

                                                    <select wire:model="siswa" id="selectOp"
                                                        class="form-control searchSelect"
                                                        @if (!empty($SearchSiswa)) disabled @endif>
                                                        <option value=""
                                                            @if (!$siswa) selected @endif>
                                                            ----Pilih----</option>

                                                        @foreach ($DataSiswa as $item)
                                                            <option @if ($siswa == $item->id) selected @endif
                                                                value="{{ $item->id }}">{{ $item->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <input type="text" placeholder="Cari Siswa..."
                                                        class="form-control" wire:model.live="SearchSiswa">

                                                </div>

                                                @if (!empty($SearchSiswa))
                                                    <div class="mb-3 mt-3">
                                                        @foreach ($DataSiswa as $item)
                                                            <ul>
                                                                <li><span
                                                                        wire:click="setSiswa({{ $item->id }})">({{ $item->batch }}){{ $item->name }}</span>
                                                                </li>
                                                            </ul>
                                                        @endforeach
                                                    </div>
                                                @endif

                                                @error('siswa')
                                                    <span class="text-danger">
                                                        {{ $message }}
                                                    </span>
                                                @enderror

                                            </div>
                                            <div class="mb-3">
                                                <div>
                                                    <div class="input-group mb-3">
                                                        <span class="input-group-text" id="basic-addon1">Rp.</span>
                                                        <input type="number" wire:model.live="amountGlobal"
                                                            class="form-control" placeholder="Total Uang"
                                                            aria-label="Total Uang" aria-describedby="basic-addon1">
                                                    </div>
                                                    @error('amountGlobal')
                                                        <span class="text-danger">
                                                            {{ $message }}
                                                        </span>
                                                    @enderror
                                                </div>

                                            </div>

                                            <div class="mb-3">
                                                <label for="NamaU" class="form-label">Tanggal</label>
                                                <input type="date" class="form-control" wire:model="dateIncome">
                                                @error('dateIncome')
                                                    <span class="text-danger">
                                                        {{ $message }}
                                                    </span>
                                                @enderror
                                            </div>

                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="NamaU" class="form-label">Deskripsi</label>
                                                <textarea type="date" class="form-control" wire:model="deskripsi"></textarea>
                                                @error('deskripsi')
                                                    <span class="text-danger">
                                                        {{ $message }}
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <button class="btn btn-primary btn-sm" wire:click='AddIncomeLainnya'
                                        type="button">Simpan</button>
                                </div>
                            @elseif ($typeAdd = 'input_expense')
                                <div class="mb-3">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3 position-relative">
                                                <label for="NamaU" class="form-label">Siswa</label>
                                                <div class="input-group">

                                                    <select wire:model="siswa" id="selectOp"
                                                        class="form-control searchSelect"
                                                        @if (!empty($SearchSiswa)) disabled @endif>
                                                        <option value=""
                                                            @if (!$siswa) selected @endif>
                                                            ----Pilih----</option>

                                                        @foreach ($DataSiswa as $item)
                                                            <option @if ($siswa == $item->id) selected @endif
                                                                value="{{ $item->id }}">{{ $item->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <input type="text" placeholder="Cari Siswa..."
                                                        class="form-control" wire:model.live="SearchSiswa">

                                                </div>

                                                @if (!empty($SearchSiswa))
                                                    <div class="mb-3 mt-3">
                                                        @foreach ($DataSiswa as $item)
                                                            <ul>
                                                                <li><span
                                                                        wire:click="setSiswa({{ $item->id }})">({{ $item->batch }}){{ $item->name }}</span>
                                                                </li>
                                                            </ul>
                                                        @endforeach
                                                    </div>
                                                @endif

                                                @error('siswa')
                                                    <span class="text-danger">
                                                        {{ $message }}
                                                    </span>
                                                @enderror

                                            </div>
                                            <div class="mb-3">
                                                <div>
                                                    <div class="input-group mb-3">
                                                        <span class="input-group-text" id="basic-addon1">Rp.</span>
                                                        <input type="number" wire:model.live="amountGlobal"
                                                            class="form-control" placeholder="Total Uang"
                                                            aria-label="Total Uang" aria-describedby="basic-addon1">
                                                    </div>
                                                    @error('amountGlobal')
                                                        <span class="text-danger">
                                                            {{ $message }}
                                                        </span>
                                                    @enderror
                                                </div>

                                            </div>

                                            <div class="mb-3">
                                                <label for="NamaU" class="form-label">Tanggal</label>
                                                <input type="date" class="form-control" wire:model="dateIncome">
                                                @error('dateIncome')
                                                    <span class="text-danger">
                                                        {{ $message }}
                                                    </span>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label for="NamaU" class="form-label">Jenis Pengeluaran</label>

                                                <select class="form-control" wire:model.live='type_amount'>
                                                    <option value="meal">Makanan</option>
                                                    <option value="others">Lainnya</option>
                                                </select>

                                                @error('type_amount')
                                                    <span class="text-danger">
                                                        {{ $message }}
                                                    </span>
                                                @enderror
                                            </div>

                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="NamaU" class="form-label">Deskripsi</label>
                                                <textarea type="date" class="form-control" wire:model="deskripsi"></textarea>
                                                @error('deskripsi')
                                                    <span class="text-danger">
                                                        {{ $message }}
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <button class="btn btn-primary btn-sm" wire:click='AddExpense'
                                        type="button">Simpan</button>
                                </div>
                            @endif
                        @endif

                        <div class="row">
                            <div class="col-md-4 col-6">
                                <div class="mb-3">
                                    <input type="text" wire:model.live="search" class="form-control"
                                        placeholder="Cari transaksi...">
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table id="" class="table table-bar">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nama</th>
                                        <th>Jenis</th>
                                        <th>Tanggal</th>
                                        <th>Deskripsi</th>
                                        <th>Uang</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($DataTransaction as $key => $item)
                                        <tr>
                                            <td>{{ ($DataTransaction->currentPage() - 1) * $DataTransaction->perPage() + $key + 1 }}.
                                            </td>
                                            <td>{{ $item->user->name ?? '-' }}</td>
                                            <td><span
                                                    class="custom-status-bar-{{ $item->type }}">{{ $item->type }}</span>
                                            </td>
                                            <td id="tanggal-col">{{ $item->date }}</td>
                                            <td>{{ $item->description }}</td>
                                            <td>Rp.{{ number_format($item->amount, 0, ',', '.') }}</td>
                                            <td><Button onclick="confirmDelete({{ $item->id }})"
                                                    class="btn btn-danger btn-sm"><i
                                                        class="fa-solid fa-trash-can"></i></Button></td>
                                        </tr>

                                        <script>
                                            function confirmDelete(itemId) {


                                                Swal.fire({
                                                    title: 'Perhatian',
                                                    text: "Yakin Menghapus Data Ini ?",
                                                    icon: 'danger',
                                                    showCancelButton: true,
                                                    confirmButtonColor: '#3085d6',
                                                    cancelButtonColor: '#d33',
                                                    cancelButtonText: 'Batal',
                                                    confirmButtonText: 'Ya'
                                                }).then((result) => {
                                                    if (result.isConfirmed) {
                                                        Livewire.dispatch('DeleteTransactionEmit', {
                                                            "id": itemId
                                                        });
                                                        Swal.fire(
                                                            'Deleted!',
                                                            'Your file has been deleted.',
                                                            'success'
                                                        )
                                                    }
                                                })
                                            }
                                        </script>
                                    @endforeach

                                </tbody>

                            </table>
                            {{ $DataTransaction->links('') }}

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
    <script>
        function validateDay(input) {
            const selectedDate = new Date(input.value);
            const day = selectedDate.getDay(); // 0 = Minggu, 1 = Senin, ..., 6 = Sabtu
            if (day !== 0) {
                alert('Silakan pilih hari Minggu sebagai awal minggu pembayaran.');
                input.value = ''; // Reset input jika bukan hari Minggu
            }
        }
    </script>
    <script>
        document.querySelectorAll("input[data-type='currency']").forEach(input => {
            input.addEventListener('keyup', function() {
                let rawValue = this.value.replace(/\D/g, '');
                this.value = rawValue.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
            });
        });

        $(document).ready(function() {
            $('.searchSelect').select2();
        });
    </script>


</div>
