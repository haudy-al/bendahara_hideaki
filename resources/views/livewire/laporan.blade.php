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
                            <li class="breadcrumb-item active">Laporan</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div id="header" class="header-xyza">
                    <div class="card custom-l-card">
                        <div class="card-body">
                            
                            <div class="row">
                                {{-- <div class="col-md-4">
                                    <div>
                                        <label for="month">Month:</label>
                                        <input class="form-control" type="month" id="month" wire:model.live="month">
                                    </div>
                                </div> --}}
                                <div class="col-md-4">
                                    <div>
                                        <label for="week">Tanggal Transaksi:</label>
                                        <input type="date" id="sunday-date" class="form-control" wire:model.live="date" >
                                        {{-- <select class="form-control" id="week" wire:model.live="week">
                                            <option value="1">First Week</option>
                                            <option value="2">Second Week</option>
                                            <option value="3">Third Week</option>
                                            <option value="4">Fourth Week</option>
                                        </select> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <span>Laporan Pemasukan Mingguan</span>
                        </h3>

                        <div class="card-tools">
                            <button class="btn btn-success btn-sm" wire:click="export">Export to Excel</button>

                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0" style="height: 400px;">


                        <table class="table table-head-fixed text-nowrap">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama</th>
                                    <th>Jenis</th>
                                    <th>Tanggal</th>
                                    <th>Deskripsi</th>
                                    <th>Uang</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $groupedTransactions = $DataTransaction->groupBy(function ($transaction) {
                                        return $transaction->type_amount == 'others' ? uniqid() : $transaction->user_id;
                                    });
                                    $totalAmount = 0;
                                    $number = 1;
                                @endphp

                                @foreach ($groupedTransactions as $group)
                                    @if ($group->first()->type_amount == 'others')
                                        @foreach ($group as $item)
                                            <tr>
                                                <td>{{ $number++ }}</td>
                                                <td>{{ $item->user->name ?? '-' }} ({{ $item->user->batch }})</td>
                                                <td><span
                                                        class="custom-status-bar-{{ $item->type }}">{{ $item->type }}</span>
                                                </td>
                                                <td id="tanggal-col">{{ $item->date }}</td>
                                                <td>{{ $item->description }}</td>
                                                <td>Rp.{{ number_format($item->amount, 0, ',', '.') }}</td>

                                            </tr>
                                            @php
                                                $totalAmount += $item->amount;
                                            @endphp
                                        @endforeach
                                    @else
                                        @php
                                            $first = $group->first();
                                            $sumAmount = $group->sum('amount');
                                            $totalAmount += $sumAmount;
                                        @endphp
                                        <tr>
                                            <td>{{ $number++ }}</td>
                                            <td>{{ $first->user->name ?? '-' }} ({{ $first->user->batch }})</td>
                                            <td><span
                                                    class="custom-status-bar-{{ $first->type }}">{{ $first->type }}</span>
                                            </td>
                                            <td id="tanggal-col">{{ $first->date }}</td>
                                            <td>{{ $first->description }}</td>
                                            <td>Rp.{{ number_format($sumAmount, 0, ',', '.') }}</td>

                                        </tr>
                                    @endif
                                @endforeach

                                <!-- Total Amount Row -->
                               
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer">
                        <tr>
                            <td colspan="5" class="text-right"><strong>Total Amount</strong></td>
                            <td>Rp.{{ number_format($totalAmount, 0, ',', '.') }}</td>
                            
                        </tr>
                    </div>

                    <!-- /.card-body -->
                </div>
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <span>Laporan Pengeluaran Mingguan</span>
                        </h3>

                        <div class="card-tools">
                            <button class="btn btn-success btn-sm" wire:click="export('expense')">Export to
                                Excel</button>

                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0" style="height: 400px;">


                        <table class="table table-head-fixed text-nowrap">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama</th>
                                    <th>Jenis</th>
                                    <th>Tanggal</th>
                                    <th>Deskripsi</th>
                                    <th>Uang</th>
                                </tr>
                            </thead>
                            <tbody>

                                @php
                                    $totalAmountExpense = 0;
                                @endphp

                                @foreach ($DataTransactionsExpense as $key => $item)
                                    <tr>
                                        <td>{{ ++$key }}.
                                        </td>
                                        <td>{{ $item->user->name ?? '-' }} ({{ $item->user->batch ?? '-' }})</td>
                                        <td><span
                                                class="custom-status-bar-{{ $item->type }}">{{ $item->type }}</span>
                                        </td>
                                        <td id="tanggal-col">{{ $item->date }}</td>
                                        <td>{{ $item->description }}</td>
                                        <td>Rp.{{ number_format($item->amount, 0, ',', '.') }}</td>

                                    </tr>

                                    @php
                                        $totalAmountExpense += $item->amount;
                                    @endphp
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer">
                        <tr>
                            <td colspan="5" class="text-right"><strong>Total Amount</strong></td>
                            <td>Rp.{{ number_format($totalAmountExpense, 0, ',', '.') }}</td>
                            
                        </tr>
                    </div>


                    <!-- /.card-body -->
                </div>
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            Laporan Pemasukan Bulanan
                        </h3>

                        <div class="card-tools">
                            <button class="btn btn-success btn-sm" wire:click="exportMonth('income')">Export to
                                Excel</button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0" style="height: 400px;">


                        <table class="table table-head-fixed text-nowrap">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama</th>
                                    <th>Jenis</th>
                                    <th>Tanggal</th>
                                    <th>Deskripsi</th>
                                    <th>Uang</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $groupedTransactionMonthIncome = $DataTransactionMonthIncome->groupBy(function (
                                        $transactionMonthIncome,
                                    ) {
                                        return $transactionMonthIncome->type_amount == 'others'
                                            ? uniqid()
                                            : $transactionMonthIncome->user_id;
                                    });
                                    $totalAmountMonthIncome = 0;
                                    $numberMonthIncome = 1;
                                @endphp

                                @foreach ($groupedTransactionMonthIncome as $group)
                                    @if ($group->first()->type_amount == 'others')
                                        @foreach ($group as $item)
                                            <tr>
                                                <td>{{ $numberMonthIncome++ }}</td>
                                                <td>{{ $item->user->name ?? '-' }} ({{ $item->user->batch }})</td>
                                                <td><span
                                                        class="custom-status-bar-{{ $item->type }}">{{ $item->type }}</span>
                                                </td>
                                                <td id="tanggal-col">{{ $item->date }}</td>
                                                <td>{{ $item->description }}</td>
                                                <td>Rp.{{ number_format($item->amount, 0, ',', '.') }}</td>

                                            </tr>
                                            @php
                                                $totalAmountMonthIncome += $item->amount;
                                            @endphp
                                        @endforeach
                                    @else
                                        @php
                                            $first = $group->first();
                                            $sumAmountMonthIncome = $group->sum('amount');
                                            $totalAmountMonthIncome += $sumAmountMonthIncome;
                                        @endphp
                                        <tr>
                                            <td>{{ $numberMonthIncome++ }}</td>
                                            <td>{{ $first->user->name ?? '-' }} ({{ $first->user->batch }})</td>
                                            <td><span
                                                    class="custom-status-bar-{{ $first->type }}">{{ $first->type }}</span>
                                            </td>
                                            <td id="tanggal-col">{{ $first->date }}</td>
                                            <td>{{ $first->description }}</td>
                                            <td>Rp.{{ number_format($sumAmountMonthIncome, 0, ',', '.') }}</td>

                                        </tr>
                                    @endif
                                @endforeach

                                <!-- Total Amount Row -->
                               
                            </tbody>
                        </table>
                    </div>

                    <div class="card-footer">
                        <tr>
                            <td colspan="5" class="text-right"><strong>Total Amount</strong></td>
                            <td>Rp.{{ number_format($totalAmountMonthIncome, 0, ',', '.') }}</td>
                            
                        </tr>
                    </div>
                    <!-- /.card-body -->
                </div>
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            Laporan Pengeluaran Bulanan
                        </h3>

                        <div class="card-tools">
                            <button class="btn btn-success btn-sm" wire:click="exportMonth('expense')">Export to Excel</button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0" style="height: 400px;">


                        <table class="table table-head-fixed text-nowrap">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama</th>
                                    <th>Jenis</th>
                                    <th>Tanggal</th>
                                    <th>Deskripsi</th>
                                    <th>Uang</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $groupedTransactionMonthExpense = $DataTransactionMonthExpense->groupBy(function ($transactionMonthIncome) {
                                        return $transactionMonthIncome->type_amount == 'others' ? uniqid() : $transactionMonthIncome->user_id;
                                    });
                                    $totalAmountMonthIncome = 0;
                                    $numberMonthIncome = 1;
                                @endphp
                    
                                @foreach ($groupedTransactionMonthExpense as $group)
                                    @if ($group->first()->type_amount == 'others' || $group->first()->type == 'expense')
                                        @foreach ($group as $item)
                                            <tr>
                                                <td>{{ $numberMonthIncome++ }}</td>
                                                <td>{{ $item->user->name ?? '-' }} ({{ $item->user->batch }})</td>
                                                <td><span class="custom-status-bar-{{ $item->type }}">{{ $item->type }}</span></td>
                                                <td id="tanggal-col">{{ $item->date }}</td>
                                                <td>{{ $item->description }}</td>
                                                <td>Rp.{{ number_format($item->amount, 0, ',', '.') }}</td>
                                                
                                            </tr>
                                            @php
                                                $totalAmountMonthIncome += $item->amount;
                                            @endphp
                                        @endforeach
                                    @else
                                        @php
                                            $first = $group->first();
                                            $sumAmountMonthIncome = $group->sum('amount');
                                            $totalAmountMonthIncome += $sumAmountMonthIncome;
                                        @endphp
                                        <tr>
                                            <td>{{ $numberMonthIncome++ }}</td>
                                            <td>{{ $first->user->name ?? '-' }} ({{ $first->user->batch }})</td>
                                            <td><span class="custom-status-bar-{{ $first->type }}">{{ $first->type }}</span></td>
                                            <td id="tanggal-col">{{ $first->date }}</td>
                                            <td>{{ $first->description }}</td>
                                            <td>Rp.{{ number_format($sumAmountMonthIncome, 0, ',', '.') }}</td>
                                            
                                        </tr>
                                    @endif
                                @endforeach
                                                    
                            </tbody>
                            
                        </table>
                    </div>


                    <!-- /.card-body -->
                    <div class="card-footer">
                        <tr>
                           
                            <td colspan="5" class="text-right"><strong>Total Amount</strong></td>
                            <td>Rp.{{ number_format($totalAmountMonthIncome, 0, ',', '.') }}</td>
                            
                        </tr>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>

    <script>
        window.onscroll = function() {myFunction()};

        var header = document.getElementById("header");
        var sticky = header.offsetTop;

        function myFunction() {
            if (window.pageYOffset > sticky) {
                header.classList.add("fixed-xyza");
            } else {
                header.classList.remove("fixed-xyza");
            }
        }

        function validateDay(input) {
            const selectedDate = new Date(input.value);
            const day = selectedDate.getDay(); // 0 = Minggu, 1 = Senin, ..., 6 = Sabtu
            if (day !== 0) {
                alert('Silakan pilih hari Minggu sebagai awal minggu pembayaran.');
                input.value = ''; // Reset input jika bukan hari Minggu
            }
        }
    </script>


</div>
