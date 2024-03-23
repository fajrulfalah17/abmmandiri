<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class GuruController extends Controller
{
    public function index()
    {
        $data = Guru::latest()->get();
        $roles = Auth::user()->getRoleNames()->toArray();
        $isAdmin = in_array("admin", $roles);
        $isGuru = in_array("guru", $roles);

        if($isAdmin)
        {
            if (request()->ajax()) {
                $query = Guru::with('users')->get();
    
                return DataTables::of($query)
                    ->addColumn('action', function ($item) {
                        $editButton = '';
                        // $deleteButton = '';
                            if (Gate::allows('guru.edit')) {
                                $editButton = '<a href="' . route('guru.edit', $item->id). '" class="btn btn-warning btn-sm shadow-sm mr-1" title="Edit"><i class="fas fa-pen"></i></a>';
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
            return view('pages.guru.index', compact('data'));
        }

        else if($isGuru) {
            
            $userId = Auth::user()->id;
            $guru = Guru::with('users')->where('users_id', $userId)->first();

            return view('pages.guru.edit', compact('guru'));
                
        }
    }

    public function edit($id)
    {
        $guru = Guru::with('users')->findOrFail($id);

        return view('pages.guru.edit', compact('guru'));
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        $guru = Guru::with('users')->findOrFail($id);
        $foto = $request->file('foto');

        $request->validate([
            'email'     => 'required|email|unique:users,email,'.$guru->users->id,
            'foto'      => 'image|max:1024'
        ]);

        try {
            if($request->hasFile('foto'))
            {
                if ($guru->foto) {
                    Storage::delete('public/foto_guru/' . $guru->foto);
                }
                $nama_file = $foto->hashName();
                $foto->storeAs('public/foto_guru', $nama_file);
    
                $guru->update([
                    'asal_sekolah'        => $request->input('asal_sekolah'),
                    'mgmp'                => $request->input('mgmp'),
                    'user_cbt'            => $request->input('user_cbt'),
                    'password_cbt'        => $request->input('password_cbt'),
                    'foto'                => $foto->hashName()
                ]);
                
                $guru->users()->update([
                    'email'     => $request->input('email'),
                    'username'     => $request->input('mgmp'),
                    'name'     => $request->input('name'),
                ]);
            }
            $guru->update([
                'asal_sekolah'        => $request->input('asal_sekolah'),
                'mgmp'                => $request->input('mgmp'),
                'user_cbt'            => $request->input('user_cbt'),
                'password_cbt'        => $request->input('password_cbt'),
            ]);
            
            $guru->users()->update([
                'email'     => $request->input('email'),
                'username'     => $request->input('mgmp'),
                'name'     => $request->input('name'),
            ]);
    
            DB::commit();
            
            //redirect dengan pesan sukses
            Alert::toast('Data Guru Berhasil Diupdate!','success');
            return Redirect::back();
                
        } catch (\Throwable $e) {
            DB::rollback();
            //redirect dengan pesan error
            Alert::toast('Gagal update data. Pesan error: ' . $e->getMessage(), 'error')->autoClose(5000);
            return Redirect::back();
        }
    }
}
