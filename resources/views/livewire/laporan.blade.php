<div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        Laporan
                    </div>
    
                    <div class="card-body">
                        
                        <div class="mb-3">
                            <div>
                                <label for="month">Month:</label>
                                <input type="month" id="month" wire:model="month">
                            </div>
                        
                            <div>
                                <label for="week">Week:</label>
                                <select id="week" wire:model="week">
                                    <option value="1">First Week</option>
                                    <option value="2">Second Week</option>
                                    <option value="3">Third Week</option>
                                    <option value="4">Fourth Week</option>
                                </select>
                            </div>
                        
                            <button wire:click="export">Export to Excel</button>
                        </div>
                        
                    </div>
                        
                </div>
            </div>
        </div>
    </div>
</div>