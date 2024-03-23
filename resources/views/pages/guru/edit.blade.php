@extends('layouts.main')
@section('title')
    Data Guru
@endsection


@section('content')
    <div class="row">
        <div class="col-xxl-3">
            <div class="card">
                <div class="card-body p-0">
                    <div class="user-profile-img">
                        <img src="{{ asset('Admin/dist/assets/images/pattern-bg.jpg') }}"
                            class="profile-img profile-foreground-img rounded-top" style="height: 120px;" alt="">

                    </div>
                    <!-- end user-profile-img -->

                    <div class="p-4 pt-0">

                        <div class="mt-n5 position-relative text-center border-bottom pb-3">
                            @if ($guru->foto)
                                <img src="{{ url('storage/foto_guru/' . $guru->foto) }}" alt=""
                                    class="avatar-xl rounded-circle img-thumbnail" style="object-fit: cover;">
                            @else
                                <img src="{{ asset('Admin/dist/assets/images/users/avatar-3.jpg') }}" alt=""
                                    class="avatar-xl rounded-circle img-thumbnail">
                            @endif

                            <div class="mt-3">
                                <h5 class="mb-1">{{ $guru->users->name ?? 'Nama Guru' }}</h5>
                                <p class="text-muted mb-0">
                                    {{ $guru->asal_sekolah ?? '-' }}
                                </p>
                            </div>

                        </div>

                        <div class="table-responsive mt-3 border-bottom pb-3">
                            <table class="table align-middle table-sm table-nowrap table-borderless table-centered mb-0">
                                <tbody>
                                    <tr>
                                        <th class="fw-bold">
                                            Username :</th>
                                        <td class="text-muted">{{ $guru->users->username ?? '0' }}</td>
                                    </tr>
                                    <tr>
                                        <th class="fw-bold">
                                            MGMP :</th>
                                        <td class="text-muted">{{ $guru->mgmp ?? '0' }}</td>
                                    </tr>
                                    <!-- end tr -->
                                </tbody><!-- end tbody -->
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xxl-9">
            <div class="card">
                <div class="card-body">
                    <!-- Nav tabs -->
                    <ul class="nav nav-pills nav-justified" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" href="{{ route('guru.edit', $guru->id) }}" role="tab">
                                <span>Data Guru</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Tab content -->
            <div class="tab-content">
                <div class="tab-pane active" id="edit" role="tabpanel">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="font-size-16 mb-3">Data Guru</h5>
                            <form action="{{ route('guru.update', $guru->id) }}" enctype="multipart/form-data"
                                method="POST">
                                @csrf
                                @method('put')

                                <div class="row mt-2">
                                    <div class="col-4">
                                        <label for="formrow-firstname-input" class="form-label">Nama</label>
                                        <input type="text" placeholder="" name="name" id="formrow-firstname-input"
                                            value="{{ old('name', $guru->users->name) }}"
                                            class="form-control @error('name') is-invalid @enderror">
                                        @error('name')
                                            <div class="invalid-feedback" style="display: block">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-4">
                                        <label for="formrow-firstname-input" class="form-label">Email</label>
                                        <input type="email" placeholder="" name="email" id="formrow-firstname-input"
                                            value="{{ old('email', $guru->users->email) }}"
                                            class="form-control @error('email') is-invalid @enderror">
                                        @error('email')
                                            <div class="invalid-feedback" style="display: block">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-4">
                                        <label for="formrow-firstname-input" class="form-label">Foto</label>
                                        <input type="file" placeholder="" name="foto" id="formrow-firstname-input"
                                            value="" class="form-control @error('foto') is-invalid @enderror">
                                        @error('foto')
                                            <div class="invalid-feedback" style="display: block">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-6">
                                        <div id="informasi" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel"
                                            aria-hidden="true" data-bs-scroll="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content ">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="myModalLabel">Informasi</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>Jika anda mengubah <b>Data MGMP</b> berarti anda mengubah
                                                            username saat login aplikasi.</p>
                                                    </div>
                                                </div><!-- /.modal-content -->
                                            </div><!-- /.modal-dialog -->
                                        </div><!-- /.modal -->
                                        <label for="formrow-firstname-input" class="form-label">MGMP <i
                                                class="bx bx-info-circle text-danger"data-bs-toggle="modal"
                                                data-bs-target="#informasi"></i></label>
                                        <input type="text" placeholder="" name="mgmp" id="formrow-firstname-input"
                                            value="{{ old('mgmp', $guru->mgmp) }}"
                                            class="form-control @error('mgmp') is-invalid @enderror">
                                        @error('mgmp')
                                            <div class="invalid-feedback" style="display: block">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-6">
                                        <label for="formrow-firstname-input" class="form-label">Asal Sekolah</label>
                                        <input type="text" placeholder="" name="asal_sekolah" id="asal_sekolah"
                                            value="{{ old('asal_sekolah', $guru->asal_sekolah) }}"
                                            class="form-control @error('asal_sekolah') is-invalid @enderror">
                                        @error('asal_sekolah')
                                            <div class="invalid-feedback" style="display: block">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mt-2">
                                    <div class="col-6">
                                        <label for="formrow-firstname-input" class="form-label">User CBT</label>
                                        <input type="text" placeholder="" name="user_cbt" id="user_cbt"
                                            value="{{ old('user_cbt', $guru->user_cbt) }}"
                                            class="form-control @error('user_cbt') is-invalid @enderror">
                                        @error('user_cbt')
                                            <div class="invalid-feedback" style="display: block">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-6">
                                        <label for="formrow-firstname-input" class="form-label">Password CBT</label>
                                        <input type="text" placeholder="" name="password_cbt" id="password_cbt"
                                            value="{{ old('password_cbt', $guru->password_cbt) }}"
                                            class="form-control @error('password_cbt') is-invalid @enderror">
                                        @error('password_cbt')
                                            <div class="invalid-feedback" style="display: block">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="float-end mt-4">
                                    <button type="button" onclick="goBack()"
                                        class="btn btn-secondary btn-sm btn-flat w-sm"><i class="bx bx-arrow-back"></i>
                                        Kembali</button>
                                    <button type="submit" class="btn btn-success btn-sm btn-flat w-sm"><i
                                            class="bx bxs-send"></i>
                                        Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>
@endsection
