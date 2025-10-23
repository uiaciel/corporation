<?php

namespace Uiaciel\Corporation\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Str;
use Uiaciel\Corporation\Models\Announcement;
use Carbon\Carbon;

class AnnouncementImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new Announcement([
            'title' => $row['title'],
            'slug' => $row['slug'] ?? Str::slug($row['title']),
            'category' => $row['category'],
            'content' => $row['content'],
            'image' => $row['image'],
            'pdf' => $row['pdf'],
            'homepage' => $row['homepage'],
            'datepublish' => Carbon::parse($row['datepublish'])->format('Y-m-d'),
            'status' => $row['status'],
        ]);
    }
}
