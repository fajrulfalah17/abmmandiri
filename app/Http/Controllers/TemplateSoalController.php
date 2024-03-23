<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Kegiatan;
use App\Models\TemplateSoal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class TemplateSoalController extends Controller
{
    public function index()
    {
        $data = TemplateSoal::with('kegiatan')->get();
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
                $query = TemplateSoal::with('kegiatan', 'guru')->where('guru_id', $idGuru);
    
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
                            <a href="' .route('downloadTemplateSoal', $item->id).'">
                                <button type="button" class="btn btn-primary btn-sm"><i class="fa fa-download" aria-hidden="true"></i> Download
                                </button>
                            </a>
                        ';
                    })
                    ->addColumn('action', function ($item) {
                        $editButton = '';
                        $deleteButton = '';
                            if (Gate::allows('guru.edit')) {
                                $editButton = '<a href="' . route('template-soal.edit', $item->id) . '" class="btn btn-warning btn-sm shadow-sm mr-1" title="Edit"><i class="fas fa-pen"></i></a>';
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
            return view('pages.template-soal.index', compact('data'));
        }
        if (request()->ajax()) {
            $query = TemplateSoal::with('kegiatan', 'guru')->get();

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
                        <a href="' .route('downloadTemplateSoal', $item->id).'">
                            <button type="button" class="btn btn-primary btn-sm"><i class="fa fa-download" aria-hidden="true"></i> Download
                            </button>
                        </a>
                    ';
                })
                ->addColumn('action', function ($item) {
                    $editButton = '';
                    $deleteButton = '';
                        if (Gate::allows('guru.edit')) {
                            $editButton = '<a href="' . route('template-soal.edit', $item->id) . '" class="btn btn-warning btn-sm shadow-sm mr-1" title="Edit"><i class="fas fa-pen"></i></a>';
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
        return view('pages.template-soal.index', compact('data'));
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

        return view('pages.template-soal.create', compact('kegiatan', 'idGuru'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kegiatan_id' => 'required',
            'soal'=>'required|mimes:doc,docx'
        ]);

        DB::beginTransaction();
        try {

            $dokumen = $request->file('soal');
            $dokumen->storeAs('public/soal', $dokumen->hashName());

            $template_soal = TemplateSoal::create([
                'kegiatan_id'      => $request->input('kegiatan_id'),
                'guru_id'      => $request->input('guru_id'),
                'soal'     => $dokumen->hashName(),
            ]);

            $template_soal->save();
            DB::commit();
            
            //redirect dengan pesan sukses
            Alert::toast('Template Soal Berhasil Disimpan!','success');
            return redirect()->route('template-soal.index');
                
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
        $template_soal = TemplateSoal::findOrFail($id);
        $kegiatan = Kegiatan::latest()->get();
        $user = Auth::user()->id;
        $idGuru = null;
        if(Auth::user()->guru)
        {
            $guru = Guru::where('users_id', $user)->first();
            $idGuru = $guru->id;
        }


        return view('pages.template-soal.edit', compact('template_soal', 'kegiatan', 'idGuru'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
{
    $request->validate([
        'kegiatan_id' => 'required',
        'soal'   => 'nullable|file|mimes:doc,docx|max:2048', // Ubah menjadi 'nullable' agar tidak wajib diisi
    ]);

    $template_soal = TemplateSoal::findOrFail($id);

    DB::beginTransaction();
    try {
        if ($request->hasFile('soal')) {
            $dokumen = $request->file('soal');
            if ($template_soal->soal) {
                Storage::delete('public/soal/' . $template_soal->soal);
            }
            $nama_file = $dokumen->hashName();
            $dokumen->storeAs('public/soal', $nama_file);

            $template_soal->update([
                'kegiatan_id' => $request->input('kegiatan_id'),
                'guru_id'      => $request->input('guru_id'),
                'soal'   => $nama_file,
            ]);
        } else {
            // Jika tidak ada file yang diunggah
            $template_soal->update([
                'guru_id'      => $request->input('guru_id'),
                'kegiatan_id' => $request->input('kegiatan_id'),
            ]);
        }

        DB::commit();
        
        // Redirect dengan pesan sukses
        Alert::toast('Template Soal Berhasil Diupdate!','success');
        return redirect()->route('template-soal.index');
            
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
        $template_soal = TemplateSoal::findOrFail($id);
        if($template_soal){
            $template_soal->delete();
            //redirect dengan pesan sukses
            Alert::toast('Template Soal Berhasil Dihapus!','warning');
            return Redirect::back();
        }else{
            //redirect dengan pesan error
            Alert::toast('Template Soal Gagal Dihapus!','error');
            return Redirect::back();
        }
    }

    public function print($id)
    {
        $data = TemplateSoal::findOrFail($id);
        $namaBerkas = $data->soal;

        return Storage::download('public/soal/' . $namaBerkas);
    }
}
