<?php

namespace Uiaciel\Corporation\Livewire;

use App\Models\Setting;
use Livewire\Component;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;
use Uiaciel\Corporation\Exports\ReportExport;
use Uiaciel\Corporation\Imports\ReportImport;
use Uiaciel\Corporation\Models\Report;

class ReportIndex extends Component
{

    use WithFileUploads;

    public $reportx, $editTitle, $editCategory, $editDatepublish, $editStatus, $editPdf, $editImage;
    public $editReportId = null;
    public $titlePage = 'Reports';

    public $importFile;
    public $setting;
    public $date;

    public function listReport()
    {
        $this->reportx = Report::All();
    }

    public function mount()
    {
        $this->setting = Setting::first();
        $this->listReport();

        $this->date = now()->format('d-m-Y');
    }

    public function dataImport()
    {
        $this->validate([
            'importFile' => 'required|file|mimes:xlsx,xls,csv|max:10240', // Max 10MB
        ]);

        Excel::import(new ReportImport, $this->importFile);

        session()->flash('success', 'Report imported successfully!');
        $this->redirect(route('admin.report.index'), navigate: true);
    }

    public function dataExport()
    {

        $sanitizedUrl = str_replace('/', '-', $this->setting->url);
        $fileName = 'backup-Report-' . $sanitizedUrl . '-' . $this->date . '.xlsx';

        return Excel::download(new ReportExport, $fileName,  \Maatwebsite\Excel\Excel::XLSX);
    }

    public function showEditModal($id)
    {
        $menu = Report::find($id);
        if ($menu) {
            $this->editReportId = $menu->id;
            $this->editTitle = $menu->title;
            $this->editCategory = $menu->category;
            $this->editImage = $menu->image;
            $this->editPdf = $menu->pdf;
            $this->editDatepublish = $menu->datepublish;
            $this->editStatus = $menu->status;
            $this->dispatch('showEditMenuModal');
        }
    }

    public function updateReport()
    {
        $this->validate([
            'editTitle' => 'required|string|max:255',
            'editCategory' => 'required|string|max:255',
            'editStatus' => 'required|in:Publish,Unpublish',
            'editDatepublish' => 'required|date',
        ]);

        $report = Report::find($this->editReportId);

        if ($report) {

            $report->update([
                'title' => $this->editTitle,
                'category' => $this->editCategory,
                'status' => $this->editStatus,
                'datepublish' => $this->editDatepublish,
                // Properti 'pdf' dan 'image' dipertahankan jika tidak ada logika upload baru
            ]);

            $this->dispatch('hideEditMenuModal');
            $this->listReport();
            session()->flash('message', 'Report updated successfully.');
            $this->reset(['editReportId', 'editTitle', 'editCategory', 'editStatus', 'editDatepublish']);
        } else {
            session()->flash('error', 'Report not found.');
        }
    }

    public function delete($id)
    {
        $report = Report::find($id);

        if ($report) {
            $report->delete();

            session()->flash('success', 'Report Deleted Successfully.');
            return $this->redirect('/admin/reports', navigate: true);
        }
    }

    public function render()
    {
        return view('corporation::livewire.report-index');
    }
}
