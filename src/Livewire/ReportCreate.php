<?php

namespace Uiaciel\Corporation\Livewire;

use Livewire\Component;
use Uiaciel\Corporation\Models\Report;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Spatie\PdfToImage\Pdf;

class ReportCreate extends Component
{
    use WithFileUploads;

    public $title;
    public $category;
    public $datepublish;
    public $status;
    public $content;
    public $pdf = null;
    public $pdfPreview;
    public $coverPreview;
    public $storedPdfPath;
    public $storedImagePath;
    public $hit;
    public $image;
    public $errorMessage;
    public $categories;

    public function mount()
    {
        $this->title = '';
        $this->category = '';
        $this->datepublish = now()->format('Y-m-d');
        $this->status = 'Publish';
        $this->content = '';
        $this->pdf;
        $this->hit = '';
        $this->image = '';
        $this->categories = Report::distinct()->pluck('category')->toArray();
    }

    protected $rules = [
        'title' => 'required|max:255',
        'category' => 'required|max:255',
        'content' => 'nullable',
        'image' => 'nullable|image|max:51200',
        'pdf' => 'required|mimes:pdf|max:102400',
        'datepublish' => 'required|date',
        'status' => 'nullable',
        'hit' => 'nullable',
    ];

    public function updatedPdf()
    {
        $this->validateOnly('pdf');

        if ($this->pdf) {
            $originalFilename = $this->pdf->getClientOriginalName();
            $time = time();
            $filename = Str::slug(pathinfo($originalFilename, PATHINFO_FILENAME)) . '_' . $time . '.pdf';
            $pdfPath = $this->pdf->storeAs('temp', $filename, 'public');

            $this->pdfPreview = '/storage/' . $pdfPath;
            $this->storedPdfPath = $pdfPath;

            try {
                $pdfFullPath = Storage::disk('public')->path($pdfPath);
                $imagePath = 'temp/' . Str::slug(pathinfo($originalFilename, PATHINFO_FILENAME)) . '_' . $time . '_cover.webp';

                (new Pdf($pdfFullPath))->selectPage(1)
                    ->format(\Spatie\PdfToImage\Enums\OutputFormat::Webp)
                    ->save(Storage::disk('public')->path($imagePath));

                $this->coverPreview = '/storage/' . $imagePath;
                $this->storedImagePath = $imagePath;
            } catch (\Exception $e) {
                $this->addError('pdf', 'Failed to generate cover image.');
            }
        }
    }

    public function store()
    {
        $this->validate();

        $report = new Report;
        $report->title = $this->title;
        $report->slug = Str::slug($this->title);
        $report->category = $this->category;
        $report->datepublish = $this->datepublish;
        $report->status = $this->status;

        if ($this->storedPdfPath) {
            $newPdfPath = 'reports/' . basename($this->storedPdfPath);
            Storage::disk('public')->move($this->storedPdfPath, $newPdfPath);
            $report->pdf = $newPdfPath;
        }

        // Move image file from temp to images folder
        if ($this->storedImagePath) {
            $newImagePath = 'reports/' . basename($this->storedImagePath);
            Storage::disk('public')->move($this->storedImagePath, $newImagePath);
            $report->image = $newImagePath;
        }

        $report->save();

        session()->flash('message', 'Report created successfully.');
        return $this->redirect('/admin/corporation/reports');
    }

    public function render()
    {
        return view('corporation::livewire.report-create');
    }
}
