@extends('layouts.main')

@section('title')
    Tambah User Admin
@endsection

@section('content')
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">

                <h6>Form Tambah User Admin :</h6>

                <form action="{{ route('user-admin.update', $user->id) }}" enctype="multipart/form-data" method="POST">
                    @csrf
                    @method('put')

                    <div class="row mt-2">
                        <div class="col-4">
                            <label for="formrow-firstname-input" class="form-label">Nama User</label>
                            <input type="text" placeholder="" name="name"
                                id="formrow-firstname-input"  value="{{ old('name', $user->name) }}" class="form-control @error('name') is-invalid @enderror">
                                @error('name')
                                <div class="invalid-feedback" style="display: block">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-4">
                            <label for="formrow-firstname-input" class="form-label">Username Login</label>
                            <input type="text" placeholder="" name="username"
                                id="formrow-firstname-input"  value="{{ old('username', $user->username) }}" class="form-control @error('username') is-invalid @enderror">
                                @error('username')
                                <div class="invalid-feedback" style="display: block">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-4">
                            <label for="formrow-firstname-input" class="form-label">Email</label>
                            <input type="email" placeholder="" name="email"
                                id="formrow-firstname-input"  value="{{ old('email', $user->email) }}" class="form-control @error('email') is-invalid @enderror">

                                @error('email')
                                <div class="invalid-feedback" style="display: block">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="col-md-6">
                            <label>Password</label>
                            <input type="password" name="password" value="{{ old('password') }}"
                                placeholder="Masukkan Password"
                                class="form-control @error('password') is-invalid @enderror">

                            @error('password')
                                <div class="invalid-feedback" style="display: block">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label>Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" value="{{ old('password_confirmation') }}"
                                placeholder="Masukkan Konfirmasi Password" class="form-control">
                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="col-12">
                            <label class="font-weight-bold">Role</label>
                            <br>
                            @foreach ($roles as $role)
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" name="role[]"
                                            value="{{ $role->name }}" id="check-{{ $role->id }}"
                                            {{ $user->roles->contains($role->id) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="check-{{ $role->id }}">
                                            {{ $role->name }}
                                        </label>
                                    </div>
                                @endforeach
                        </div>
                    </div>

                    <div class="col-md-6" style="display: none;">
                        <div class="form-group">
                            <select name="posisi" id="">
                                <option value="ADMIN"selected>ADMIN</option>
                                <option value="PEJABAT">PEJABAT</option>
                                <option value="GURU">GURU</option>
                                <option value="MADRASAH">MADRASAH</option>

                            </select>
                        </div>
                    </div>

                    <div class="float-end mt-2">
                        <button type="button" onclick="goBack()" class="btn btn-secondary btn-sm btn-flat w-sm"><i
                                class="bx bx-arrow-back"></i>
                            Kembali</button>
                        <button type="submit" class="btn btn-success btn-sm btn-flat w-sm"><i class="bx bxs-send"></i>
                            Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection


@push('addon-script')
    <script>
        function goBack() {
            window.history.back();
        }
    </script>
@endpush