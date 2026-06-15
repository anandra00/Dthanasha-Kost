<?php

namespace App\Http\Controllers;

use App\Models\Kamar;
use App\Models\Pengaturan;
use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    public function index()
    {
        $kamars = Kamar::orderBy('nomor_kamar', 'asc')->get();
        $waAdmin = Pengaturan::where('kunci', 'wa_admin')->value('nilai') ?? '6281234567890';

        // Count totals
        $totalKamar = Kamar::count();
        $kamarKosong = Kamar::where('status_kamar', 'Kosong')->count();
        $kamarTerisi = Kamar::where('status_kamar', 'Terisi')->count();

        // Unique types for promotion
        $types = Kamar::select('jenis_kamar')->distinct()->pluck('jenis_kamar');

        return view('landing', compact('kamars', 'waAdmin', 'totalKamar', 'kamarKosong', 'kamarTerisi', 'types'));
    }
}
