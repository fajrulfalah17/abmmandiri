<?php

namespace App\Http\Controllers;

use App\Models\PanduanOp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Redirect;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class PanduanOpController extends Controller
{
    public function index()
    {
        $data = PanduanOp::latest()->get();

        if (request()->ajax()) {
            $query = PanduanOp::query();

            return DataTables::of($query)
                ->addColumn('deskripsi', function($item) {
                    return '
                       '. $item->deskripsi .'
                    ';
                })
                ->addColumn('action', function ($item) {
                    $editButton = '';
                    $deleteButton = '';
                        if (Gate::allows('operator.edit')) {
                            $editButton = '<a href="' . route('panduan-operator.edit', $item->id). '" class="btn btn-warning btn-sm shadow-sm mr-1" title="Edit"><i class="fas fa-pen"></i></a>';
                        }
                        if (Gate::allows('operator.delete')) {
                            $deleteButton = '<button type="button" class="btn btn-danger btn-sm waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#hapusModal_' . $item->id .'"><i class="fas fa-trash-alt"></i></button>';
                        }
                        return '
                            ' . $editButton . $deleteButton .'
                        ';
                })
                ->rawColumns(['action', 'deskripsi'])
                ->make();
        }
        return view('pages.panduan-operator.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.panduan-operator.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required',
            'link' => 'required',
        ]);


        DB::beginTransaction();
        try {
            $panduan = PanduanOp::create([
                'judul'      => $request->input('judul'),
                'link'     => $request->input('link'),
                'deskripsi'     => $request->input('deskripsi'),
            ]);

            $panduan->save();
            DB::commit();
            
            //redirect dengan pesan sukses
            Alert::toast('Panduan Berhasil Disimpan!','success');
            return redirect()->route('panduan-operator.index');
                
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
        $panduan = PanduanOp::findOrFail($id);

        return view('pages.panduan-operator.edit', compact('panduan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'judul' => 'required',
            'link' => 'required',
            
        ]);

        $panduan = PanduanOp::findOrFail($id);
        DB::beginTransaction();
        try {
            $panduan->update([
                'judul'      => $request->input('judul'),
                'link'     => $request->input('link'),
                'deskripsi'     => $request->input('deskripsi'),

            ]);

            DB::commit();
            
            //redirect dengan pesan sukses
            Alert::toast('Panduan Berhasil Diupdate!','success');
            return redirect()->route('panduan-operator.index');
                
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
        $panduan = PanduanOp::findOrFail($id);
        if($panduan){
            $panduan->delete();
            //redirect dengan pesan sukses
            Alert::toast('Panduan Berhasil Dihapus!','warning');
            return Redirect::back();
        }else{
            //redirect dengan pesan error
            Alert::toast('Panduan Gagal Dihapus!','error');
            return Redirect::back();
        }
    }
}
