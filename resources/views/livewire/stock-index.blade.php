<div class="container-fluid">

    <header class="page-header d-flex justify-content-between align-items-center mb-3">
        <h3 class="fw-bold me-3">{{ $titlePage }}</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Admin</a></li>
                <li class="breadcrumb-item active">Stocks</li>
            </ol>
        </nav>
    </header>

    <x-corporation-session-status />

    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Import Stock Data</h5>
                </div>
                <div class="card-body">
                    <p>Paste JSON data from the stock API to import or update stock information.</p>

                    <form wire:submit.prevent="getDataStock">
                        <div class="mb-3">
                            <label for="stockData" class="form-label fw-bold">Get Data from url : <a href="https://idx.co.id/primary/ListedCompany/GetTradingInfoDaily?code=SGER">idx.co.id</a></label>

                            <textarea wire:model="stockData" id="stockData" class="form-control" rows="10"
                                placeholder='{ "SecurityCode": "SGER", ... }'></textarea>
                            @error('stockData') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Import Data</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Latest Stock Data</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Code</th>
                                    <th>Price</th>
                                    <th>Change</th>
                                    <th>Open</th>
                                    <th>High</th>
                                    <th>Low</th>
                                    <th>Last Update</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($stocks as $stock)
                                <tr>
                                    <td><strong>{{ $stock->kode_saham }}</strong></td>
                                    <td>{{ number_format($stock->harga, 0, ',', '.') }}</td>
                                    <td class="{{ $stock->perubahan >= 0 ? 'text-success' : 'text-danger' }}">
                                        {{ $stock->perubahan }}
                                    </td>
                                    <td>{{ number_format($stock->pembukaan, 0, ',', '.') }}</td>
                                    <td>{{ number_format($stock->harga_tertinggi, 0, ',', '.') }}</td>
                                    <td>{{ number_format($stock->harga_terendah, 0, ',', '.') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($stock->waktu_pembaruan)->format('d M Y H:i') }}</td>

                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center">No stock data available.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
