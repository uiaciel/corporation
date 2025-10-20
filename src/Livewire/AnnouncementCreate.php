<?php

namespace Uiaciel\Corporation\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;
use Spatie\PdfToImage\Pdf;
use Illuminate\Support\Facades\Storage;
use Uiaciel\Corporation\Models\Announcement;

class AnnouncementCreate extends Component
{
    use WithFileUploads;

    public $title;
    public $category;
    public $content;
    public $image;
    public $pdf;
    public $homepage = 'No';
    public $status = 'Publish';
    public $datepublish;

    public $pdfPreview;
    public $coverPreview;
    public $storedPdfPath;
    public $storedImagePath;
    public $categories;

    protected $rules = [
        'title' => 'required|min:3',
        'category' => 'required',
        'content' => 'nullable',
        'image' => 'nullable|image|max:51200',
        'pdf' => 'nullable|mimes:pdf|max:102400',
        'homepage' => 'required|in:Yes,No',
        'status' => 'required|in:Publish,Draf',
        'datepublish' => 'required|date',
    ];

    public function mount()
    {
        $this->datepublish = now()->format('Y-m-d');
        $this->categories = Announcement::distinct()->pluck('category')->toArray();
    }

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

    public function save()
    {
        $this->validate();

        // Save the announcement to the database
        $announcement = new Announcement();
        $announcement->title = $this->title;
        $announcement->slug = Str::slug($this->title);
        $announcement->category = $this->category;
        $announcement->content = $this->content;
        $announcement->homepage = $this->homepage;
        $announcement->datepublish = $this->datepublish;
        $announcement->status = $this->status;

        // Move PDF file from temp to reports folder
        if ($this->storedPdfPath) {
            $newPdfPath = 'announcements/' . basename($this->storedPdfPath);
            Storage::disk('public')->move($this->storedPdfPath, $newPdfPath);
            $announcement->pdf = $newPdfPath; // Update database with new path
        }

        // Move image file from temp to images folder
        if ($this->storedImagePath) {
            $newImagePath = 'images/' . basename($this->storedImagePath);
            Storage::disk('public')->move($this->storedImagePath, $newImagePath);
            $announcement->image = $newImagePath; // Update database with new path
        }

        $announcement->save();

        session()->flash('message', 'Announcement created successfully.');
        return $this->redirect(route('admin.announcement.index'), navigate: true);

    }

    public function render()
    {
        return view('corporation::livewire.announcement-create');
    }
}
