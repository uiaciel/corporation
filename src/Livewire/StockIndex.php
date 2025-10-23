<?php

namespace Uiaciel\Corporation\Livewire;

use Livewire\Component;
use Uiaciel\Corporation\Models\Stock;

class StockIndex extends Component
{
    public $stockData;
    public $titlePage = "Stock Market";
    public $stocks;

    public function mount()
    {
        $this->loadStocks();
    }

    public function getDataStock()
    {
        $data = json_decode($this->stockData, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            session()->flash('error', 'Invalid JSON format.');
            return;
        }

        $stock = Stock::firstOrNew(['kode_saham' => $data['SecurityCode']]);

        $stock->fill([
            'harga' => $data['ClosingPrice'],
            'perubahan' => $data['Change'],
            'waktu_pembaruan' => $data['DTCreate'],
            'pembukaan' => $data['OpeningPrice'],
            'penutupan_sebelumnya' => $data['PreviousPrice'],
            'offer' => $data['BestOfferPrice'],
            'bid' => $data['BestBidPrice'],
            'harga_terendah' => $data['LowestPrice'],
            'harga_tertinggi' => $data['HighestPrice'],
            'volume' => $data['TradedVolume'],
            'nilai_transaksi' => $data['TradedValue'],
            'frekuensi' => $data['TradedFrequency'],
        ]);

        $stock->save();

        session()->flash('success', 'Stock data imported successfully!');
        $this->stockData = ''; // Clear the textarea
        $this->loadStocks(); // Refresh the table
    }

    public function loadStocks()
    {
        $this->stocks = Stock::orderBy('waktu_pembaruan', 'desc')->get();
    }

    public function render()
    {
        $this->loadStocks();
        return view('corporation::livewire.stock-index');
    }
}
