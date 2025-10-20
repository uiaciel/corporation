<?php

namespace Uiaciel\Corporation\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Uiaciel\Corporation\Models\Announcement;
use Maatwebsite\Excel\Facades\Excel;
use Uiaciel\Corporation\Exports\AnnouncementExport;
use Uiaciel\Corporation\Imports\AnnouncementImport;
use App\Models\Setting;

class AnnouncementIndex extends Component
{
    use WithFileUploads;

    public $announcementz;
    public $editAnnouncementId = null;
    public $editTitle;
    public $editCategory;
    public $editLink;
    public $editPdf;
    public $editHomepage;
    public $editStatus;
    public $editDatepublish;
    public $editImage;
    public $titlePage = 'Announcement';

    public $importFile;
    public $setting;
    public $date;

    public $search = '';
    public $filterHomepage = false;
    public $filterStatus = false;
    public $filterDateModified = false;

    public function listAnnouncement()
    {
        // build query with search & filters
        $query = Announcement::query();

        // search by title
        if (!empty($this->search)) {
            $query->where('title', 'like', '%' . $this->search . '%');
        }

        // apply ordering for homepage filter: put homepage='Yes' first
        if ($this->filterHomepage) {
            // CASE ensures 'Yes' appear first
            $query->orderByRaw("CASE WHEN homepage = 'Yes' THEN 0 ELSE 1 END");
        }

        // apply ordering for status filter: put Publish first
        if ($this->filterStatus) {
            // handle possible capitalization differences
            $query->orderByRaw("CASE WHEN LOWER(status) = 'publish' THEN 0 ELSE 1 END");
        }

        // apply ordering for date modified: newest updated first
        if ($this->filterDateModified) {
            $query->orderBy('updated_at', 'desc');
        }

        // if no explicit ordering applied, order by newest created
        if (!$this->filterHomepage && !$this->filterStatus && !$this->filterDateModified) {
            $query->orderBy('id', 'desc');
        }

        $this->announcementz = $query->get();
    }

    public function mount()
    {
        $this->setting = Setting::first();
        $this->listAnnouncement();
        $this->date = now()->format('d-m-Y');
    }

    public function updated($property)
    {
        if (in_array($property, ['search', 'filterHomepage', 'filterStatus', 'filterDateModified'])) {
            $this->listAnnouncement();
        }
    }

    public function filterByHomepage()
    {
        $this->filterHomepage = ! $this->filterHomepage;
        $this->listAnnouncement();
    }

    public function filterByStatus()
    {
        $this->filterStatus = ! $this->filterStatus;
        $this->listAnnouncement();
    }

    public function filterByDateModified()
    {
        $this->filterDateModified = ! $this->filterDateModified;
        $this->listAnnouncement();
    }

    public function changestatus($id)
    {
        $announcement = Announcement::find($id);

        if ($announcement) {
            $announcement->status = 'Draf';
            $announcement->save();

            session()->flash('success', 'Announcement status changed to Draft.');
        }
    }

    public function dataImport()
    {
        $this->validate([
            'importFile' => 'required|file|mimes:xlsx,xls,csv|max:10240', // Max 10MB
        ]);

        Excel::import(new AnnouncementImport, $this->importFile);

        session()->flash('success', 'Announcement imported successfully!');
        $this->redirect(route('admin.announcement.index'), navigate: true);
    }

    public function dataExport()
    {
        $sanitizedUrl = str_replace('/', '-', $this->setting->url);
        $fileName = 'backup-Announcement-' . $sanitizedUrl . '-' . $this->date . '.xlsx';

        return Excel::download(new AnnouncementExport, $fileName,  \Maatwebsite\Excel\Excel::XLSX);
    }

    public function showEditModal($id)
    {
        $menu = Announcement::find($id);
        if ($menu) {
            $this->editAnnouncementId = $menu->id;
            $this->editTitle = $menu->title;
            $this->editCategory = $menu->category;
            $this->editPdf = $menu->pdf;
            $this->editImage = $menu->image;
            $this->editHomepage = $menu->homepage;
            $this->editDatepublish = $menu->datepublish;
            $this->editStatus = $menu->status;
            $this->dispatch('showEditMenuModal');
        }
    }

    public function updateAnnouncement()
    {
        $this->validate([
            'editTitle' => 'required|string|max:255',
            'editCategory' => 'required|string|max:255',
            'editHomepage' => 'required|in:Yes,No',
            'editStatus' => 'required|in:Publish,Draf',
            'editDatepublish' => 'required|date',
        ]);

        $announcement = Announcement::find($this->editAnnouncementId);

        if ($announcement) {
            $announcement->update([
                'title' => $this->editTitle,
                'category' => $this->editCategory,
                'homepage' => $this->editHomepage,
                'status' => $this->editStatus,
                'datepublish' => $this->editDatepublish,
            ]);

            $this->dispatch('hideEditMenuModal');
            $this->listAnnouncement();
            session()->flash('message', 'Announcement updated successfully.');

            $this->reset(['editAnnouncementId', 'editTitle', 'editCategory', 'editPdf', 'editImage', 'editHomepage', 'editStatus', 'editDatepublish']);
        } else {
            session()->flash('error', 'Announcement not found.');
        }
    }

    public function delete($id)
    {
        $announcement = Announcement::find($id);

        if ($announcement) {
            $announcement->delete();
            session()->flash('success', 'Announcement Deleted Successfully.');
        }
    }

    public function render()
    {
        return view('corporation::livewire.announcement-index');
    }
}
