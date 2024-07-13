<div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="col-4">
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

                                <div class="input-group ">
                                    <select name="" id="" wire:model.live='type_income' class="form-control ms-3 dropdown-toggle">
                                        <option value="uang_makan_siswa">Uang Makan Siswa</option>
                                        <option value="pemasukan_lainnya">Pemasukan Lainnya</option>
                                    </select>
                                    <span class="input-group-text" id="basic-addon1"></span>
                                </div>
                            @else
                                <button class="btn btn-primary btn-sm" wire:click="btnAdd">Tambah Pemasukan <i
                                        class="fa-solid fa-plus"></i></button>
                            @endif
                        </div>

                        <!-- Elemen ini akan berada di pojok kanan atas -->
                        <div>
                        </div>
                    </div>
                    <div class="card-body">

                        @if ($statusBtnAdd == true)
                            @if ($type_income == 'uang_makan_siswa')
                            <div class="mb-3">

                                <form>
                                    <div class="row">

                                        <div class="col-md-6">
                                            <div class="mb-3 position-relative">
                                                <label for="NamaU" class="form-label">Siswa</label>
                                                <select wire:model.live="siswa" id="" class="form-control">
                                                    <option value="" selected>----Pilih----</option>
                                                    @foreach ($DataSiswa as $item)
                                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                    @endforeach
                                                </select>
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

                                                    <div class="mb-3 d-flex justify-content-between align-items-center">
                                                        <div class="form-check ">
                                                            <label class="form-check-label"
                                                                for="check-senin">Senin</label>
                                                            <input type="checkbox" class="form-check-input"
                                                                id="check-senin" wire:model.live="check_senin">

                                                        </div>
                                                        <div>
                                                            <input class="ms-3 w-50 custom-number-meal" type="number"
                                                                min="1" max="2"
                                                                wire:model.live="count_meal_senin">
                                                        </div>
                                                    </div>

                                                    <div class="mb-3 d-flex justify-content-between align-items-center">
                                                        <div class="form-check">
                                                            <label class="form-check-label"
                                                                for="check-selasa">Selasa</label>
                                                            <input type="checkbox" class="form-check-input"
                                                                id="check-selasa" wire:model.live="check_selasa">
                                                        </div>
                                                        <div>
                                                            <input class="ms-3 w-50 custom-number-meal" type="number"
                                                                min="1" max="2"
                                                                wire:model.live="count_meal_selasa">
                                                        </div>
                                                    </div>
                                                    <div class="mb-3 d-flex justify-content-between align-items-center">
                                                        <div class="form-check">
                                                            <label class="form-check-label"
                                                                for="check-rabu">Rabu</label>
                                                            <input type="checkbox" class="form-check-input"
                                                                id="check-rabu" wire:model.live="check_rabu">
                                                        </div>
                                                        <div>
                                                            <input class="ms-3 w-50 custom-number-meal" type="number"
                                                                min="1" max="2"
                                                                wire:model.live="count_meal_rabu">
                                                        </div>
                                                    </div>
                                                    <div class="mb-3 d-flex justify-content-between align-items-center">
                                                        <div class="form-check">
                                                            <label class="form-check-label"
                                                                for="check-kamis">Kamis</label>
                                                            <input type="checkbox" class="form-check-input"
                                                                id="check-kamis" wire:model.live="check_kamis">
                                                        </div>
                                                        <div>
                                                            <input class="ms-3 w-50 custom-number-meal" type="number"
                                                                min="1" max="2"
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
                                                            <input class="ms-3 w-50 custom-number-meal" type="number"
                                                                min="1" max="2"
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
                            @endif
                        @endif

                        <div class="row">
                            <div class="col-4">
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
                                            <td>{{ ($DataTransaction->currentPage() - 1) * $DataTransaction->perPage() + $key + 1 }}.</td>
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
                                                if (confirm('Apakah Anda yakin ingin menghapus item ini?')) {
                                                    Livewire.dispatch('DeleteTransactionEmit', {
                                                        "id": itemId
                                                    });
                                                }
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
    </div>
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
    </script>


</div>
