<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Yajra\DataTables\Facades\DataTables;

class PermissionController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware(['permission:permissions.index']);
    // } 

    /**
     * function index
     *
     * @return void
     */
    public function index()
    {
        if (request()->ajax()) {
            $data = Permission::query();
            return DataTables::of($data)

                ->make();
        }

        return view('pages.permission.index');
    }
}
