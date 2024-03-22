<?php

namespace App\Http\Controllers;

use App\Models\Pengumuman;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $pengumuman = Pengumuman::latest()->get();
        $batas_waktu = Carbon::now();

        return view('pages.dashboard.index', compact('pengumuman', 'batas_waktu'));
    }
}
