<?php

namespace Uiaciel\Corporation\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Uiaciel\Corporation\Models\Report;
use Carbon\Carbon;

class ReportImport implements ToModel, WithHeadingRow
{

    public function model(array $row)
    {
        if (empty($row['title']) || empty($row['slug'])) {
            return NULL;
        }

        return new Report([
            'title' => $row['title'],
            'slug' => $row['slug'],
            'category' => $row['category'],
            'content' => $row['content'],
            'image' => $row['image'],
            'pdf' => $row['pdf'],
            'status' => $row['status'],
            'datepublish' => Carbon::parse($row['datepublish'])->format('Y-m-d'),
            'hit' => $row['hit'],
            // Assuming created_at and updated_at are not typically imported or are handled by Eloquent timestamps
            // If they are present and need specific formatting, uncomment and adjust:
            'created_at' => isset($row['created_at']) ? Carbon::parse($row['created_at']) : now(),
            'updated_at' => isset($row['updated_at']) ? Carbon::parse($row['updated_at']) : now(),
        ]);
    }

}
