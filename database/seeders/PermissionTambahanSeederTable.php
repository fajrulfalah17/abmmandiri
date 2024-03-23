<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTambahanSeederTable extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::create(['name' => 'operator.index']);
        Permission::create(['name' => 'operator.create']);
        Permission::create(['name' => 'operator.edit']);
        Permission::create(['name' => 'operator.delete']);

        Permission::create(['name' => 'guru.index']);
        Permission::create(['name' => 'guru.create']);
        Permission::create(['name' => 'guru.edit']);
        Permission::create(['name' => 'guru.delete']);

        Permission::create(['name' => 'kegiatan.index']);
        Permission::create(['name' => 'kegiatan.create']);
        Permission::create(['name' => 'kegiatan.edit']);
        Permission::create(['name' => 'kegiatan.delete']);
    }
}
