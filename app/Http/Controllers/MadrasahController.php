<?php

namespace App\Http\Controllers;

use App\Models\Madrasah;
use App\Models\RdmMadrasah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class MadrasahController extends Controller
{
    public function index()
    {
        $data = Madrasah::latest()->get();
        $roles = Auth::user()->getRoleNames()->toArray();
        $isAdmin = in_array("admin", $roles);
        $isMadrasah = in_array("madrasah", $roles);

        if($isAdmin)
        {
            if (request()->ajax()) {
                $query = Madrasah::with('users')->get();
    
                return DataTables::of($query)
                    ->addColumn('action', function ($item) {
                        $editButton = '';
                        // $deleteButton = '';
                            if (Gate::allows('madrasah.edit')) {
                                $editButton = '<a href="' . route('madrasah.edit', $item->id). '" class="btn btn-warning btn-sm shadow-sm mr-1" title="Edit"><i class="fas fa-pen"></i></a>';
                            }
                            // if (Gate::allows('kegiatan.delete')) {
                            //     $deleteButton = '<button type="button" class="btn btn-danger btn-sm waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#hapusModal_' . $item->id .'"><i class="fas fa-trash-alt"></i></button>';
                            // }
                            return '
                                ' . $editButton .'
                            ';
                        // return '
                            
                        //     <button type="button" class="btn btn-danger btn-sm waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#hapusModal_' . $item->id .'"><i class="fas fa-trash-alt"></i></button>
                        // ';
                    })
                    ->rawColumns(['action'])
                    ->make();
            }
            return view('pages.madrasah.index', compact('data'));
        }

        else if($isMadrasah) {
            
            $userId = Auth::user()->id;
            $madrasah = Madrasah::with('users')->where('users_id', $userId)->first();

            return view('pages.madrasah.edit', compact('madrasah'));
                
        }
    }

    public function edit($id)
    {
        $madrasah = Madrasah::with('users')->findOrFail($id);

        return view('pages.madrasah.edit', compact('madrasah'));
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        $madrasah = Madrasah::with('users')->findOrFail($id);

        $request->validate([
            'email'     => 'required|email|unique:users,email,'.$madrasah->users->id
        ]);

        try {
            $madrasah->update([
                'npsn'        => $request->input('npsn'),
                'nsm'     => $request->input('nsm'),
                'siswa_tujuh'              => $request->input('siswa_tujuh'),
                'siswa_delapan'               => $request->input('siswa_delapan'),
                'siswa_sembilan'         => $request->input('siswa_sembilan'),
                'alamat'   => $request->input('alamat'),
            ]);
            
            $madrasah->users()->update([
                'email'     => $request->input('email'),
                'username'     => $request->input('nsm'),
                'name'     => $request->input('name'),
            ]);

            // Update atau buat detail jika belum ada
            if ($madrasah->details) {
                $madrasah->details->update([]);
            } else {
                $madrasah->details()->create([]);
            }

            // Update atau buat detail jika belum ada
            if ($madrasah->mora) {
                $madrasah->mora->update([]);
            } else {
                $madrasah->mora()->create([]);
            }

            // Update atau buat detail jika belum ada
            if ($madrasah->rdm) {
                $madrasah->rdm->update([]);
            } else {
                $madrasah->rdm()->create([]);
            }
    
            DB::commit();
            
            //redirect dengan pesan sukses
            Alert::toast('Data Madrasah Berhasil Diupdate!','success');
            return Redirect::back();
                
        } catch (\Throwable $e) {
            DB::rollback();
            //redirect dengan pesan error
            Alert::toast('Gagal update data. Pesan error: ' . $e->getMessage(), 'error')->autoClose(5000);
            return Redirect::back();
        }
    }

    public function details($id)
    {
        $madrasah = Madrasah::with('users', 'details')->findOrFail($id);

        return view('pages.madrasah.details', compact('madrasah'));
    }

    public function updateDetails(Request $request, $id)
    {
        DB::beginTransaction();

        $madrasah = Madrasah::with('details')->findOrFail($id);
        $foto = $request->file('foto');
        try {
            if($request->hasFile('foto'))
            {
                if ($madrasah->details->foto) {
                    Storage::delete('public/foto_madrasah/' . $madrasah->details->foto);
                }
                $nama_file = $foto->hashName();
                $foto->storeAs('public/foto_madrasah', $nama_file);
                
                $madrasah->details()->update([
                    'foto'              => $foto->hashName(),
                    'kamad'             => $request->input('kamad'),
                    'nip'               => $request->input('nip'),
                    'telepon_kamad'     => $request->input('telepon_kamad'),
                    'op_satu'           => $request->input('op_satu'),
                    'telepon_op_satu'   => $request->input('telepon_op_satu'),
                    'op_dua'            => $request->input('op_dua'),
                    'telepon_op_dua'    => $request->input('telepon_op_dua'),
                    'teknisi'           => $request->input('teknisi'),
                    'telepon_teknisi'   => $request->input('telepon_teknisi'),
                ]);
            }
            $madrasah->details()->update([
                'kamad'             => $request->input('kamad'),
                'nip'               => $request->input('nip'),
                'telepon_kamad'     => $request->input('telepon_kamad'),
                'op_satu'           => $request->input('op_satu'),
                'telepon_op_satu'   => $request->input('telepon_op_satu'),
                'op_dua'            => $request->input('op_dua'),
                'telepon_op_dua'    => $request->input('telepon_op_dua'),
                'teknisi'           => $request->input('teknisi'),
                'telepon_teknisi'   => $request->input('telepon_teknisi'),
            ]);
    
            DB::commit();
            
            //redirect dengan pesan sukses
            Alert::toast('Tim Teknis Berhasil Diupdate!','success');
            return Redirect::back();
                
        } catch (\Throwable $e) {
            DB::rollback();
            //redirect dengan pesan error
            Alert::toast('Gagal update data. Pesan error: ' . $e->getMessage(), 'error')->autoClose(5000);
            return Redirect::back();
        }
    }

    public function mora($id)
    {
        $madrasah = Madrasah::with('users', 'mora')->findOrFail($id);

        return view('pages.madrasah.mora', compact('madrasah'));
    }

    public function updateMora(Request $request, $id)
    {
        DB::beginTransaction();

        $madrasah = Madrasah::with('mora')->findOrFail($id);
        try {
            $input = $request->all();
            $madrasah->mora->update($input);
    
            DB::commit();
            
            //redirect dengan pesan sukses
            Alert::toast('Data Mora Berhasil Diupdate!','success');
            return Redirect::back();
                
        } catch (\Throwable $e) {
            DB::rollback();
            //redirect dengan pesan error
            Alert::toast('Gagal update data. Pesan error: ' . $e->getMessage(), 'error')->autoClose(5000);
            return Redirect::back();
        }
    }

    public function rdm($id)
    {
        $madrasah = Madrasah::with('users', 'rdm')->findOrFail($id);

        return view('pages.madrasah.rdm', compact('madrasah'));
    }

    public function updateRdm(Request $request, $id)
    {
        DB::beginTransaction();

        $madrasah = Madrasah::with('rdm')->findOrFail($id);
        try {
            $input = $request->all();
            $madrasah->rdm->update($input);
    
            DB::commit();
            
            //redirect dengan pesan sukses
            Alert::toast('Data RDM Berhasil Diupdate!','success');
            return Redirect::back();
                
        } catch (\Throwable $e) {
            DB::rollback();
            //redirect dengan pesan error
            Alert::toast('Gagal update data. Pesan error: ' . $e->getMessage(), 'error')->autoClose(5000);
            return Redirect::back();
        }
    }
}
