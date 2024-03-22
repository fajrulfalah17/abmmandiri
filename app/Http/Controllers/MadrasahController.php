<?php

namespace App\Http\Controllers;

use App\Models\Madrasah;
use App\Models\RdmMadrasah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class MadrasahController extends Controller
{
    public function index()
    {
        $data = Madrasah::latest()->get();

        if (request()->ajax()) {
            // $query = User::query()->where('posisi', 'ADMIN')->where('id', '<>', 1);
            $query = Madrasah::with('users')->get();

            return DataTables::of($query)
                ->addColumn('action', function ($item) {
                    return '
                        <a href="' . route('madrasah.edit', $item->id). '" class="btn btn-warning btn-sm shadow-sm mr-1" title="Edit"><i class="fas fa-pen"></i></a>
                        <button type="button" class="btn btn-danger btn-sm waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#hapusModal_' . $item->id .'"><i class="fas fa-trash-alt"></i></button>
                    ';
                })
                ->rawColumns(['action'])
                ->make();
        }
        
        return view('pages.madrasah.index', compact('data'));
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
            // if($request->file('foto')) {
            //     $foto = $request->file('foto');
            //     $foto->storeAs('public/foto_siswa', $foto->hashName());

            //     $user->update([
            //         'nama_depan'        => $request->input('nama_depan'),
            //         'nama_belakang'     => $request->input('nama_belakang'),
            //         'nisn'              => $request->input('nisn'),
            //         'nik'               => $request->input('nik'),
            //         'nis_local'         => $request->input('nis_local'),
            //         'kewarganegaraan'   => $request->input('kewarganegaraan'),
            //         'tempat_lahir'      => $request->input('tempat_lahir'),
            //         'tanggal_lahir'     => $request->input('tanggal_lahir'),
            //         'gender'            => $request->input('gender'), 
            //         'saudara'           => $request->input('saudara'),
            //         'anak_ke'           => $request->input('anak_ke'),
            //         'telepon'           => $request->input('telepon'),
            //         'main_classes_id'   => $request->input('main_classes_id'),
            //         'years_id'          => $request->input('years_id'),
            //         'status'            => $request->input('status'),
            //         'jurusan'           => $request->input('jurusan'), 
            //         'foto'              => $foto->hashName()
            //     ]);

            //     $user->users()->update([
            //         'email'     => $request->input('email'),
            //     ]);
            // }
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
        try {
            $input = $request->all();
            $madrasah->details->update($input);
    
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
