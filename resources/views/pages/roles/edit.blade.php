@extends('layouts.main')

@section('title')
    Edit Roles
@endsection

@section('content')
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">

                <form action="{{ route('roles.update', $roles->id) }}" enctype="multipart/form-data" method="POST">
                    @csrf
                    @method('put')
                    <div class="mb-3">
                        <label for="formrow-firstname-input" class="form-label">Nama Roles</label>
                        <input type="text" class="form-control" placeholder="" name="name"
                            value="{{ old('name', $roles->name) }}" id="formrow-firstname-input">
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <label class="font-weight-bold">Permissions :</label>
                            <br>
                            <input type="checkbox" name="select-all" id="select-all" class="form-check-input" /> <label
                                for="form-check-label">SELECT
                                ALL</label><br>

                            <table>
                                <tr>
                                    @php
                                        $sortedPermissions = $permissions->sortBy('name');
                                        $prevPrefix = ''; // variabel untuk melacak awalan izin sebelumnya
                                    @endphp
                                    @foreach ($sortedPermissions as $index => $permission)
                                        @php
                                            $currentPrefix = explode('.', $permission->name)[0]; // mengambil awalan izin saat ini
                                        @endphp
                                        @if ($currentPrefix != $prevPrefix && $index != 0)
                                </tr>
                                <tr> <!-- tutup baris sebelumnya dan buka baris baru jika awalan berbeda -->
                                    @endif
                                    <td>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" name="permissions[]"
                                                value="{{ $permission->name }}" id="check-{{ $permission->id }}"
                                                @if ($roles->permissions->contains($permission)) checked @endif>
                                            <label class="form-check-label" for="check-{{ $permission->id }}">
                                                {{ $permission->name }}
                                            </label>
                                        </div>
                                    </td>
                                    @php
                                        $prevPrefix = $currentPrefix; // update awalan izin sebelumnya
                                    @endphp
                                    @endforeach
                                </tr>
                            </table>

                        </div>
                    </div>
                    <div class="float-end mt-2">
                        <button type="button" onclick="goBack()" class="btn btn-secondary btn-sm btn-flat w-sm"><i
                                class="bx bx-arrow-back"></i>
                            Kembali</button>
                        <button type="submit" class="btn btn-success btn-sm btn-flat w-sm"><i class="bx bxs-send"></i>
                            Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('addon-script')
    <script>
        $('#select-all').click(function(event) {
            if (this.checked) {
                // Iterate each checkbox
                $(':checkbox').each(function() {
                    this.checked = true;
                });
            } else {
                $(':checkbox').each(function() {
                    this.checked = false;
                });
            }
        });
    </script>
    <script>
        function goBack() {
            window.history.back();
        }
    </script>
@endpush
