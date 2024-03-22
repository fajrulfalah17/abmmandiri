<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use RealRashid\SweetAlert\Facades\Alert;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function index()
    {
        $users = User::latest()->get();

        if (request()->ajax()) {
            // $query = User::query()->where('posisi', 'ADMIN')->where('id', '<>', 1);
            $query = User::query();

            return DataTables::of($query)
                ->addColumn('action', function ($item) {
                    return '
                        <a href="' . route('user-admin.edit', $item->id). '" class="btn btn-warning btn-sm shadow-sm mr-1" title="Edit"><i class="fas fa-pen"></i></a>
                        <button type="button" class="btn btn-danger btn-sm waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#hapusModal_' . $item->id .'"><i class="fas fa-trash-alt"></i></button>
                    ';
                })
                ->rawColumns(['action'])
                ->make();
        }
        
        return view('pages.users.index', compact('users'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::orderBy('name', 'asc')->get();
        return view('pages.users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:5',
            'username' => 'required|min:5',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
        ]);


        DB::beginTransaction();
        try {
            $users = User::create([
                'name'      => $request->input('name'),
                'email'     => $request->input('email'),
                'username'  => $request->input('username'),
                'password'  => bcrypt($request->input('password')),
                'posisi'    => $request->input('posisi')
            ]);
    
            //assign role
            $users->assignRole($request->input('role'));

            $users->save();
            DB::commit();
            
            //redirect dengan pesan sukses
            Alert::toast('Users Berhasil Disimpan!','success');
            return redirect()->route('user-admin.index');
                
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
        $user= User::findOrFail($id);
        $roles = Role::orderBy('name', 'asc')->get();
        return view('pages.users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|min:5',
            'username' => 'required|min:5',
            'email'     => 'required|email|unique:users,email,'.$user->id
        ]);

        DB::beginTransaction();
        try {
            if($request->input('password') == "") {
                $user->update([
                    'name'      => $request->input('name'),
                    'email'     => $request->input('email'),
                    'username'  => $request->input('username'),
                    'posisi'    => $request->input('posisi')

                ]);
            } else {
                $user->update([
                    'name'      => $request->input('name'),
                    'email'     => $request->input('email'),
                    'username'  => $request->input('username'),
                    'posisi'    => $request->input('posisi'),
                    'password'  => bcrypt($request->input('password'))
                ]);
            }
    
            //assign role
            $user->syncRoles($request->input('role'));
    
            DB::commit();
            
            //redirect dengan pesan sukses
            Alert::toast('Users Berhasil Diupdate!','success');
            return redirect()->route('user-admin.index');
                
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
        $users = User::findOrFail($id);
        $permissions = $users->permissions;
        $users->revokePermissionTo($permissions);
        $users->delete();

        if($users){
            //redirect dengan pesan sukses
            Alert::toast('Users Berhasil Dihapus!','warning');
            return Redirect::back();
        }else{
            //redirect dengan pesan error
            Alert::toast('Users Gagal Dihapus!','error');
            return Redirect::back();
        }
    }
}
