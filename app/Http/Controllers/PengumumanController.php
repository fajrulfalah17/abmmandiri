<?php

namespace App\Http\Controllers;

use App\Models\Pengumuman;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Redirect;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class PengumumanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Pengumuman::orderBy('tanggal', 'desc')->get();
        if (request()->ajax()) {
            $query = Pengumuman::orderBy('tanggal', 'desc')->get();

            return DataTables::of($query)
                ->addColumn('countdown', function($item){
                    $batas_waktu = Carbon::now();
                    if($batas_waktu < $item->tanggal){
                        return '<span class="badge bg-warning"><i class="bx bx-hourglass bx-spin font-size-16 align-middle me-2"></i>Belum Terlaksana</span>';
                    } else {
                        return '<span class="badge bg-success"><i class="bx bx-check-double font-size-16 align-middle me-2"></i> Terlaksana</span>';
                        // return '<span class="badge badge-success">Terlaksana</span>';
                    }
                })
                ->addColumn('action', function ($item) {
                    $editButton = '';
                    $deleteButton = '';
                        if (Gate::allows('pengumuman.edit')) {
                            $editButton = '<a href="' . route('pengumuman.edit', $item->id). '" class="btn btn-warning btn-sm shadow-sm mr-1" title="Edit"><i class="fas fa-pen"></i></a>';
                        }
                        if (Gate::allows('pengumuman.delete')) {
                            $deleteButton = '<button type="button" class="btn btn-danger btn-sm waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#hapusModal_' . $item->id .'"><i class="fas fa-trash-alt"></i></button>';
                        }
                        return '
                            ' . $editButton . $deleteButton .'
                        ';
                })
                ->rawColumns(['action', 'countdown'])
                ->make();
        }
        return view('pages.pengumuman.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.pengumuman.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required',
            'isi' => 'required',
            'tanggal' => 'required',
            'jam' => 'required',
        ]);


        DB::beginTransaction();
        try {
            $pengumuman = Pengumuman::create([
                'judul'      => $request->input('judul'),
                'isi'     => $request->input('isi'),
                'tanggal'  => $request->input('tanggal'),
                'jam'    => $request->input('jam')
            ]);

            $pengumuman->save();
            DB::commit();
            
            //redirect dengan pesan sukses
            Alert::toast('Pengumuman Berhasil Disimpan!','success');
            return redirect()->route('pengumuman.index');
                
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
        $pengumuman = Pengumuman::findOrFail($id);

        return view('pages.pengumuman.edit', compact('pengumuman'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'judul' => 'required',
            'isi' => 'required',
            'tanggal' => 'required',
            'jam' => 'required',
        ]);

        $pengumuman = Pengumuman::findOrFail($id);
        DB::beginTransaction();
        try {
            $pengumuman->update([
                'judul'      => $request->input('judul'),
                'isi'     => $request->input('isi'),
                'tanggal'  => $request->input('tanggal'),
                'jam'    => $request->input('jam')
            ]);

            DB::commit();
            
            //redirect dengan pesan sukses
            Alert::toast('Pengumuman Berhasil Diupdate!','success');
            return redirect()->route('pengumuman.index');
                
        } catch (\Throwable $e) {
            DB::rollback();
            //redirect dengan pesan error
            Alert::toast($e->getMessage(),'error')->autoClose(5000);
            return Redirect::back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $pengumuman = Pengumuman::findOrFail($id);
        if($pengumuman){
            $pengumuman->delete();
            //redirect dengan pesan sukses
            Alert::toast('Pengumuman Berhasil Dihapus!','warning');
            return Redirect::back();
        }else{
            //redirect dengan pesan error
            Alert::toast('Pengumuman Gagal Dihapus!','error');
            return Redirect::back();
        }
    }
}
