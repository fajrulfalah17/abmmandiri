<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Kegiatan;
use App\Models\KisiSoal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class KisiSoalController extends Controller
{
    public function index()
    {
        $data = KisiSoal::with('kegiatan')->get();
        $user = Auth::user()->id;
        $idGuru = null;
        if(Auth::user()->guru)
        {
            $guru = Guru::where('users_id', $user)->first();
            $idGuru = $guru->id;
        }
        if($idGuru)
        {
            if (request()->ajax()) {
                $query = KisiSoal::with('kegiatan', 'guru')->where('guru_id', $idGuru);
    
                return DataTables::of($query)
                    ->addColumn('guru', function($item){
                        if ($item->guru) {
                            return '<h6>' . $item->guru->users->name . '</h6>';
                        } else {
                            return '<h6>Admin</h6>'; // Jika tidak ada, kembalikan tanda strip (-)
                        }
                    })
                    ->addColumn('download', function($item){
                        return '
                            <a href="' .route('downloadKisiSoal', $item->id).'">
                                <button type="button" class="btn btn-primary btn-sm"><i class="fa fa-download" aria-hidden="true"></i> Download
                                </button>
                            </a>
                        ';
                    })
                    ->addColumn('action', function ($item) {
                        $editButton = '';
                        $deleteButton = '';
                            if (Gate::allows('guru.edit')) {
                                $editButton = '<a href="' . route('kisi-kisi.edit', $item->id) . '" class="btn btn-warning btn-sm shadow-sm mr-1" title="Edit"><i class="fas fa-pen"></i></a>';
                            }
                            if (Gate::allows('guru.delete')) {
                                $deleteButton = '<button type="button" class="btn btn-danger btn-sm waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#hapusModal_' . $item->id .'"><i class="fas fa-trash-alt"></i></button>';
                            }
                            return '
                                ' . $editButton . $deleteButton .'
                            ';
                    })
                    ->rawColumns(['action', 'download', 'guru'])
                    ->make();
            }
            return view('pages.kisi-kisi.index', compact('data'));
        }
        if (request()->ajax()) {
            $query = KisiSoal::with('kegiatan')->get();

            return DataTables::of($query)
                ->addColumn('guru', function($item){
                    if ($item->guru) {
                        return '<h6>' . $item->guru->users->name . '</h6>';
                    } else {
                        return '<h6>Admin</h6>'; // Jika tidak ada, kembalikan tanda strip (-)
                    }
                })
                ->addColumn('download', function($item){
                    return '
                        <a href="' .route('downloadKisiSoal', $item->id).'">
                            <button type="button" class="btn btn-primary btn-sm"><i class="fa fa-download" aria-hidden="true"></i> Download
                            </button>
                        </a>
                    ';
                })
                ->addColumn('action', function ($item) {
                    $editButton = '';
                    $deleteButton = '';
                        if (Gate::allows('guru.edit')) {
                            $editButton = '<a href="' . route('kisi-kisi.edit', $item->id) . '" class="btn btn-warning btn-sm shadow-sm mr-1" title="Edit"><i class="fas fa-pen"></i></a>';
                        }
                        if (Gate::allows('guru.delete')) {
                            $deleteButton = '<button type="button" class="btn btn-danger btn-sm waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#hapusModal_' . $item->id .'"><i class="fas fa-trash-alt"></i></button>';
                        }
                        return '
                            ' . $editButton . $deleteButton .'
                        ';
                })
                ->rawColumns(['action', 'download', 'guru'])
                ->make();
        }
        return view('pages.kisi-kisi.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kegiatan = Kegiatan::latest()->get();
        $user = Auth::user()->id;
        $idGuru = null;
        if(Auth::user()->guru)
        {
            $guru = Guru::where('users_id', $user)->first();
            $idGuru = $guru->id;
        }

        return view('pages.kisi-kisi.create', compact('kegiatan', 'idGuru'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kegiatan_id' => 'required',
            'kisi_kisi'=>'required|mimes:doc,docx'
        ]);

        DB::beginTransaction();
        try {

            $dokumen = $request->file('kisi_kisi');
            $dokumen->storeAs('public/kisi_kisi', $dokumen->hashName());

            $kisi = KisiSoal::create([
                'kegiatan_id'      => $request->input('kegiatan_id'),
                'kisi_kisi'     => $dokumen->hashName(),
                'guru_id'      => $request->input('guru_id'),
            ]);

            $kisi->save();
            DB::commit();
            
            //redirect dengan pesan sukses
            Alert::toast('Kisi Kisi Berhasil Disimpan!','success');
            return redirect()->route('kisi-kisi.index');
                
        } catch (\Throwable $e) {
            DB::rollback();
            //redirect dengan pesan error
            Alert::toast($e->getMessage(),'error')->autoClose(5000);
            return Redirect::back();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $kisi = KisiSoal::findOrFail($id);
        $kegiatan = Kegiatan::latest()->get();
        $user = Auth::user()->id;
        $idGuru = null;
        if(Auth::user()->guru)
        {
            $guru = Guru::where('users_id', $user)->first();
            $idGuru = $guru->id;
        }

        return view('pages.kisi-kisi.edit', compact('kisi', 'kegiatan', 'idGuru'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
{
    $request->validate([
        'kegiatan_id' => 'required',
        'kisi_kisi'   => 'nullable|file|mimes:doc,docx|max:2048', // Ubah menjadi 'nullable' agar tidak wajib diisi
    ]);

    $kisi = KisiSoal::findOrFail($id);

    DB::beginTransaction();
    try {
        if ($request->hasFile('kisi_kisi')) {
            $dokumen = $request->file('kisi_kisi');
            if ($kisi->kisi_kisi) {
                Storage::delete('public/kisi_kisi/' . $kisi->kisi_kisi);
            }
            $nama_file = $dokumen->hashName();
            $dokumen->storeAs('public/kisi_kisi', $nama_file);

            $kisi->update([
                'kegiatan_id' => $request->input('kegiatan_id'),
                'kisi_kisi'   => $nama_file,
                'guru_id'      => $request->input('guru_id'),
            ]);
        } else {
            // Jika tidak ada file yang diunggah
            $kisi->update([
                'guru_id'      => $request->input('guru_id'),
                'kegiatan_id' => $request->input('kegiatan_id'),
            ]);
        }

        DB::commit();
        
        // Redirect dengan pesan sukses
        Alert::toast('Kisi Kisi Berhasil Diupdate!','success');
        return redirect()->route('kisi-kisi.index');
            
    } catch (\Throwable $e) {
        DB::rollback();
        // Redirect dengan pesan error
        return redirect()->back()->with('error', $e->getMessage())->withInput();
    }
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $kisi = KisiSoal::findOrFail($id);
        if($kisi){
            $kisi->delete();
            //redirect dengan pesan sukses
            Alert::toast('Kisi Kisi Berhasil Dihapus!','warning');
            return Redirect::back();
        }else{
            //redirect dengan pesan error
            Alert::toast('Kisi Gagal Dihapus!','error');
            return Redirect::back();
        }
    }

    public function print($id)
    {
        $data = KisiSoal::findOrFail($id);
        $namaBerkas = $data->kisi_kisi;

        return Storage::download('public/kisi_kisi/' . $namaBerkas);
    }
}
