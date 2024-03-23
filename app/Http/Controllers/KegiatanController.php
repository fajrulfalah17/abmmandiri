<?php

namespace App\Http\Controllers;

use App\Models\Kegiatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Redirect;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class KegiatanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Kegiatan::latest()->get();

        if (request()->ajax()) {
            $query = Kegiatan::query();

            return DataTables::of($query)
                ->addColumn('action', function ($item) {
                    $editButton = '';
                    $deleteButton = '';
                        if (Gate::allows('kegiatan.edit')) {
                            $editButton = '<a href="' . route('kegiatan.edit', $item->id). '" class="btn btn-warning btn-sm shadow-sm mr-1" title="Edit"><i class="fas fa-pen"></i></a>';
                        }
                        if (Gate::allows('kegiatan.delete')) {
                            $deleteButton = '<button type="button" class="btn btn-danger btn-sm waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#hapusModal_' . $item->id .'"><i class="fas fa-trash-alt"></i></button>';
                        }
                        return '
                            ' . $editButton . $deleteButton .'
                        ';
                })
                ->rawColumns(['action'])
                ->make();
        }
        return view('pages.kegiatan.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.kegiatan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|min:3',
        ]);


        DB::beginTransaction();
        try {
            $kegiatan = Kegiatan::create([
                'nama'      => $request->input('nama'),
            ]);

            $kegiatan->save();
            DB::commit();
            
            //redirect dengan pesan sukses
            Alert::toast('Kegiatan Berhasil Disimpan!','success');
            return redirect()->route('kegiatan.index');
                
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
        $kegiatan = Kegiatan::findOrFail($id);

        return view('pages.kegiatan.edit', compact('kegiatan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama' => 'required|min:3',
        ]);

        $kegiatan = Kegiatan::findOrFail($id);

        DB::beginTransaction();
        try {
            $kegiatan->update([
                'nama'      => $request->input('nama'),
            ]);

            DB::commit();
            
            //redirect dengan pesan sukses
            Alert::toast('Kegiatan Berhasil Diupdate!','success');
            return redirect()->route('kegiatan.index');
                
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
        $kegiatan = Kegiatan::findOrFail($id);
        if($kegiatan){
            $kegiatan->delete();
            //redirect dengan pesan sukses
            Alert::toast('Kegiatan Berhasil Dihapus!','warning');
            return Redirect::back();
        }else{
            //redirect dengan pesan error
            Alert::toast('Kegiatan Gagal Dihapus!','error');
            return Redirect::back();
        }
    }
}
