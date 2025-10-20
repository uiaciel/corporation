<?php

namespace Uiaciel\Corporation\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Uiaciel\Corporation\Models\Announcement;

class AnnouncementExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Announcement::select('id', 'title', 'slug', 'category', 'content', 'image', 'pdf', 'homepage', 'datepublish', 'status')->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Title',
            'Slug',
            'Category',
            'Content',
            'Image',
            'PDF',
            'Homepage',
            'Date Publish',
            'Status'
        ];
    }
}
