<?php

namespace App\Http\Controllers;

use App\Models\BankSoal;
use App\Models\Kegiatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Redirect;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class BankSoalController extends Controller
{
    public function index()
    {
        $data = BankSoal::latest()->get();

        if (request()->ajax()) {
            $query = BankSoal::with('kegiatan')->get();

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
                            $editButton = '<a href="' . route('bank-soal.edit', $item->id). '" class="btn btn-warning btn-sm shadow-sm mr-1" title="Edit"><i class="fas fa-pen"></i></a>';
                        }
                        if (Gate::allows('operator.delete')) {
                            $deleteButton = '<button type="button" class="btn btn-danger btn-sm waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#hapusModal_' . $item->id .'"><i class="fas fa-trash-alt"></i></button>';
                        }
                        return '
                            ' . $editButton . $deleteButton .'
                        ';
                    // return '
                        
                    //     <button type="button" class="btn btn-danger btn-sm waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#hapusModal_' . $item->id .'"><i class="fas fa-trash-alt"></i></button>
                    // ';
                })
                ->rawColumns(['action', 'deskripsi'])
                ->make();
        }
        return view('pages.bank-soal.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kegiatan = Kegiatan::latest()->get();
        return view('pages.bank-soal.create', compact('kegiatan'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kegiatan_id' => 'required',
            'link' => 'required',
        ]);


        DB::beginTransaction();
        try {
            $bank_soal = BankSoal::create([
                'kegiatan_id'      => $request->input('kegiatan_id'),
                'link'     => $request->input('link'),
                'deskripsi'     => $request->input('deskripsi'),
            ]);

            $bank_soal->save();
            DB::commit();
            
            //redirect dengan pesan sukses
            Alert::toast('Bank_soal Berhasil Disimpan!','success');
            return redirect()->route('bank-soal.index');
                
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
        $kegiatan = Kegiatan::latest()->get();
        $bank_soal = BankSoal::findOrFail($id);

        return view('pages.bank-soal.edit', compact('bank_soal', 'kegiatan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'kegiatan_id' => 'required',
            'link' => 'required',
        ]);

        $bank_soal = BankSoal::findOrFail($id);
        DB::beginTransaction();
        try {
            $bank_soal->update([
                'kegiatan_id'      => $request->input('kegiatan_id'),
                'link'     => $request->input('link'),
                'deskripsi'     => $request->input('deskripsi'),

            ]);

            DB::commit();
            
            //redirect dengan pesan sukses
            Alert::toast('Bank_soal Berhasil Diupdate!','success');
            return redirect()->route('bank-soal.index');
                
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
        $bank_soal = BankSoal::findOrFail($id);
        if($bank_soal){
            $bank_soal->delete();
            //redirect dengan pesan sukses
            Alert::toast('Bank_soal Berhasil Dihapus!','warning');
            return Redirect::back();
        }else{
            //redirect dengan pesan error
            Alert::toast('Bank_soal Gagal Dihapus!','error');
            return Redirect::back();
        }
    }
}
