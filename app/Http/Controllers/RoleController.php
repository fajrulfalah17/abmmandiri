<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use RealRashid\SweetAlert\Facades\Alert;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::latest()->get();
        if (request()->ajax()) {
            $query = Role::query();

            return DataTables::of($query)
                ->addColumn('action', function ($item) {
                    // Cek jika peran (roles) adalah "SuperAdmin"
                    // if ($item->name !== 'SuperAdmin') {
                        // <div class="btn-group btn-group-sm">
                        return '
                                <a href="' . route('roles.edit', $item->id). '" class="btn btn-warning btn-sm shadow-sm mr-1" title="Edit"><i class="fas fa-pen"></i></a>
                                <button type="button" class="btn btn-danger btn-sm waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#hapusRoles_' . $item->id .'"><i class="fas fa-trash-alt"></i></button>
                                ';
                                // </div>
                    // } else {
                        // Jika peran adalah "SuperAdmin", hanya tampilkan tombol "Edit"
                    //     return '
                    //         <div class="btn-group btn-group-sm">
                    //             <a href="' . route('admin.roles.edit', $item->id). '" class="btn btn-info btn-sm shadow-sm mr-1" title="Edit"><i class="fas fa-pen"></i></a>
                    //         </div>
                    //     ';
                    // }
                })
                ->rawColumns(['action'])
                ->make();
        }

        
        return view('pages.roles.index', compact('roles'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $permissions = Permission::latest()->get();
        return view('pages.roles.create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $roles = Role::create([
                'name'      => $request->input('name')
            ]);

            // assign permission to role
            $roles->syncPermissions($request->input('permissions'));

            $roles->save();
            DB::commit();
            
            //redirect dengan pesan sukses
            Alert::toast('Roles Berhasil Disimpan!','success');
            return redirect()->route('roles.index');
                
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
        $roles = Role::findOrFail($id);
        $permissions = Permission::latest()->get();

        return view('pages.roles.edit', compact('roles', 'permissions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        DB::beginTransaction();

        $roles = Role::findOrFail($id);
        try {
            $roles->update([
                'name'      => $request->input('name')
            ]);

            //assign permission to role
            $roles->syncPermissions($request->input('permissions'));


            // $roles->save();
            DB::commit();
            
            //redirect dengan pesan sukses
            Alert::toast('Roles Berhasil Diupdate!','success');
            return redirect()->route('roles.index');
                
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
        $roles = Role::findOrFail($id);
        $permissions = $roles->permissions;
        $roles->revokePermissionTo($permissions);
        $roles->delete();

        if($roles){
            //redirect dengan pesan sukses
            Alert::toast('Roles Berhasil Dihapus!','warning');
            return Redirect::back();
        }else{
            //redirect dengan pesan error
            Alert::toast('Roles Gagal Dihapus!','error');
            return Redirect::back();
        }
    }
}
