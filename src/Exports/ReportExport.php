<?php

namespace Uiaciel\Corporation\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Uiaciel\Corporation\Models\Report;

class ReportExport implements FromQuery, WithHeadings, WithMapping
{
    use Exportable;
    public function query()
    {
        return Report::query();
    }

    public function headings(): array
    {
        return [
            'title',
            'slug',
            'category',
            'content',
            'image',
            'pdf',
            'datepublish',
            'status',
            'hit',
        ];
    }

    public function map($reports): array
    {
        return [
            $reports->title,
            $reports->slug,
            $reports->category,
            $reports->content,
            $reports->image,
            $reports->pdf,
            $reports->datepublish,
            $reports->status,
            $reports->hit,
        ];
    }
}
