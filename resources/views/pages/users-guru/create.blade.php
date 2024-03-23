@extends('layouts.main')

@section('title')
    Tambah User Guru
@endsection

@section('content')
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">

                <h6>Form Tambah User Guru :</h6>

                <form action="{{ route('user-guru.store') }}" enctype="multipart/form-data" method="POST">
                    @csrf
                    <div class="row mt-2">
                        <div class="col-4">
                            <label for="formrow-firstname-input" class="form-label">Nama User</label>
                            <input type="text" placeholder="" name="name"
                                id="formrow-firstname-input"  value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror">
                                @error('name')
                                <div class="invalid-feedback" style="display: block">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-4">
                            <label for="formrow-firstname-input" class="form-label">Username Login</label>
                            <input type="text" placeholder="" name="username"
                                id="username"  value="{{ old('username') }}" class="form-control @error('username') is-invalid @enderror">
                                @error('username')
                                <div class="invalid-feedback" style="display: block">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-4">
                            <label for="formrow-firstname-input" class="form-label">Email</label>
                            <input type="email" placeholder="" name="email"
                                id="formrow-firstname-input"  value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror">

                                @error('email')
                                <div class="invalid-feedback" style="display: block">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="col-6">
                            <label for="formrow-firstname-input" class="form-label">MGMP Guru</label>
                            <input type="text" placeholder="" name="mgmp"
                                id="mgmp"  value="{{ old('mgmp') }}" class="form-control @error('mgmp') is-invalid @enderror" readonly>
                                @error('mgmp')
                                <div class="invalid-feedback" style="display: block">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-6">
                            <label for="formrow-firstname-input" class="form-label">Asal Sekolah</label>
                            <input type="text" placeholder="" name="asal_sekolah"
                                id="formrow-firstname-input"  value="{{ old('asal_sekolah') }}" class="form-control @error('asal_sekolah') is-invalid @enderror">
                                @error('asal_sekolah')
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
                                        value="{{ $role->name }}" id="check-{{ $role->id }}" required>
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
                                <option value="GURU"selected>GURU</option>
                                <option value="PEJABAT">PEJABAT</option>
                                <option value="MADRASAH">MADRASAH</option>
                                <option value="ADMIN">ADMIN</option>

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
    <script>
        $(document).ready(function() {
            $('#username').on('input', function() {
                var usernameValue = $(this).val();
                $('#mgmp').val(usernameValue);
            });
        });
    </script>
@endpush
