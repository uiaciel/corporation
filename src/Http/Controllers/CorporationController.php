<?php

namespace Uiaciel\Corporation\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Uiaciel\Corporation\Models\Announcement;
use Uiaciel\Corporation\Models\Report;

class CorporationController extends Controller
{

    public function announcement($slug)
    {
        $announcement = Announcement::where('slug', $slug)->first();
        $announcements = Announcement::orderBy('datepublish', 'desc')->get();

        return view('frontend::page.announcement', [
            'announcement' => $announcement,
            'announcements' => $announcements,
        ]);
    }

    public function acc()
    {
        $acc = Report::where('category', 'Audit Committee Charter')->orderBy('datepublish', 'desc')->get();

        return view('frontend::page.acc', compact('acc'));
    }

    public function share()
    {
        return view('frontend::page.share');
    }

    public function report($slug)
    {
        $report = Report::where('slug', $slug)->first();
        return view('frontend.report', compact('report'));
    }

    public function financial()
    {

        return view('frontend::page.financial');
    }
}
