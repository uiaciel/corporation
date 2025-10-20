<?php

namespace Uiaciel\Corporation\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;
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
    public $status = 'Draf';
    public $datepublish;

    protected $rules = [
        'title' => 'required|min:3',
        'category' => 'required',
        'content' => 'required',
        'image' => 'nullable|image|max:2048',
        'pdf' => 'nullable|mimes:pdf|max:5120',
        'homepage' => 'required|in:Yes,No',
        'status' => 'required|in:Publish,Draf',
        'datepublish' => 'required|date',
    ];

    public function mount()
    {
        $this->datepublish = now()->format('Y-m-d');
    }

    public function save()
    {
        $validatedData = $this->validate();

        // Process image if uploaded
        if ($this->image) {
            $validatedData['image'] = $this->image->store('announcements', 'public');
        }

        // Process PDF if uploaded
        if ($this->pdf) {
            $validatedData['pdf'] = $this->pdf->store('announcements', 'public');
        }

        // Add slug
        $validatedData['slug'] = Str::slug($this->title);

        // Create announcement
        Announcement::create($validatedData);

        session()->flash('success', 'Announcement created successfully.');
        return $this->redirect(route('admin.announcement.index'), navigate: true);
    }

    public function render()
    {
        return view('corporation::livewire.announcement-create');
    }
}
