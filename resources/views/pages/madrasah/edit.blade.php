@extends('layouts.main')
@section('title')
    Data Madrasah
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
                            @if ($madrasah->details->foto)
                                <img src="{{ url('storage/foto_madrasah/' . $madrasah->details->foto) }}" alt=""
                                    class="avatar-xl rounded-circle img-thumbnail" style="object-fit: cover;">
                            @else
                                <img src="{{ asset('Admin/dist/assets/images/logo-dark-sm.png') }}" alt=""
                                    class="avatar-xl rounded-circle img-thumbnail">
                            @endif

                            <div class="mt-3">
                                <h5 class="mb-1">{{ $madrasah->details->kamad ?? 'Kepala Madrasah' }}</h5>
                                <p class="text-muted mb-0">
                                    {{-- <i class="bx bxs-star text-warning font-size-14"></i>
                                    <i class="bx bxs-star text-warning font-size-14"></i>
                                    <i class="bx bxs-star text-warning font-size-14"></i>
                                    <i class="bx bxs-star text-warning font-size-14"></i>
                                    <i class="bx bxs-star-half text-warning font-size-14"></i> --}}
                                    Nip. {{ $madrasah->details->kamad ?? '-' }}
                                </p>
                                <p>{{ $madrasah->details->telepon_kamad ?? '-' }}</p>
                            </div>

                        </div>

                        <div class="table-responsive mt-3 border-bottom pb-3">
                            <table class="table align-middle table-sm table-nowrap table-borderless table-centered mb-0">
                                <tbody>
                                    <tr>
                                        <th class="fw-bold">
                                            Teknisi :</th>
                                        <td class="text-muted">{{ $madrasah->details->teknisi ?? 'Teknisi' }}</td>
                                    </tr>
                                    <tr>
                                        <th class="fw-bold">Telepon :</th>
                                        <td class="text-muted">{{ $madrasah->details->telepon_teknisi ?? '-' }}</td>
                                    </tr>
                                    <!-- end tr -->
                                    <tr>
                                        <th class="fw-bold">
                                            Operator 1 :</th>
                                        <td class="text-muted">{{ $madrasah->details->op_satu ?? 'Operator 1' }}</td>
                                    </tr>
                                    <tr>
                                        <th class="fw-bold">Telepon :</th>
                                        <td class="text-muted">{{ $madrasah->details->telepon_op_satu ?? '-' }}</td>
                                    </tr>
                                    <!-- end tr -->
                                    <tr>
                                        <th class="fw-bold">
                                            Operator 2 :</th>
                                        <td class="text-muted">{{ $madrasah->details->op_dua ?? 'Operator 2' }}</td>
                                    </tr>
                                    <tr>
                                        <th class="fw-bold">Telepon :</th>
                                        <td class="text-muted">{{ $madrasah->details->telepon_op_dua ?? '-' }}</td>
                                    </tr>
                                    <!-- end tr -->
                                </tbody><!-- end tbody -->
                            </table>
                        </div>

                        <div class="p-3 mt-3">
                            <div class="row text-center">
                                <div class="col-4 border-end">
                                    <div class="p-1">
                                        <h5 class="mb-1">{{ $madrasah->siswa_tujuh ?? 0 }}</h5>
                                        <p class="text-muted mb-0">Kelas 7</p>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="p-1">
                                        <h5 class="mb-1">{{ $madrasah->siswa_delapan ?? 0 }}</h5>
                                        <p class="text-muted mb-0">Kelas 8</p>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="p-1">
                                        <h5 class="mb-1">{{ $madrasah->siswa_sembilan ?? 0 }}</h5>
                                        <p class="text-muted mb-0">Kelas 9</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @php
                            $tujuh = $madrasah->siswa_tujuh ?? 0;
                            $delapan = $madrasah->siswa_delapan ?? 0;
                            $sembilan = $madrasah->siswa_sembilan ?? 0;

                            $total = $tujuh + $delapan + $sembilan;

                        @endphp

                        <div class="pt-2 text-center border-bottom pb-4">
                            <a href="" class="btn btn-primary waves-effect waves-light btn-sm">Total Siswa :
                                {{ $total }}</a>
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
                            <a class="nav-link active" href="{{ route('madrasah.edit', $madrasah->id) }}" role="tab">
                                <span>Data Madrasah</span>
                            </a>
                        </li>
                        @if ($madrasah->details)
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('details-madrasah', $madrasah->id) }}" role="tab">
                                    <span>Tim Teknis</span>
                                </a>
                            </li>
                        @endif

                        @if ($madrasah->mora)
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('mora-madrasah', $madrasah->id) }}" role="tab">
                                    <span>Pelasanaan</span>
                                </a>
                            </li>
                        @endif
                        @if ($madrasah->rdm)
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('rdm-madrasah', $madrasah->id) }}" role="tab">
                                    <span>RDM</span>
                                </a>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>

            <!-- Tab content -->
            <div class="tab-content">
                <div class="tab-pane active" id="edit" role="tabpanel">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="font-size-16 mb-3">Data Madrasah</h5>
                            <form action="{{ route('madrasah.update', $madrasah->id) }}" enctype="multipart/form-data"
                                method="POST">
                                @csrf
                                @method('put')

                                <div class="row mt-2">
                                    <div class="col-6">
                                        <label for="formrow-firstname-input" class="form-label">Nama Madrasah</label>
                                        <input type="text" placeholder="" name="name" id="formrow-firstname-input"
                                            value="{{ old('name', $madrasah->users->name) }}"
                                            class="form-control @error('name') is-invalid @enderror">
                                        @error('name')
                                            <div class="invalid-feedback" style="display: block">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-6">
                                        <label for="formrow-firstname-input" class="form-label">Email Madrasah</label>
                                        <input type="email" placeholder="" name="email" id="formrow-firstname-input"
                                            value="{{ old('email', $madrasah->users->email) }}"
                                            class="form-control @error('email') is-invalid @enderror">
                                        @error('email')
                                            <div class="invalid-feedback" style="display: block">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-12">
                                        <label for="formrow-firstname-input" class="form-label">Alamat Madrasah</label>
                                        <input type="text" placeholder="" name="alamat" id="alamat"
                                            value="{{ old('alamat', $madrasah->alamat) }}"
                                            class="form-control @error('alamat') is-invalid @enderror">
                                        @error('alamat')
                                            <div class="invalid-feedback" style="display: block">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-6">
                                        <div id="informasi" class="modal fade" tabindex="-1"
                                            aria-labelledby="myModalLabel" aria-hidden="true" data-bs-scroll="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content ">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="myModalLabel">Informasi</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>Jika anda mengubah <b>NSM Madrasah</b> berarti anda mengubah
                                                            username saat login aplikasi.</p>
                                                    </div>
                                                </div><!-- /.modal-content -->
                                            </div><!-- /.modal-dialog -->
                                        </div><!-- /.modal -->
                                        <label for="formrow-firstname-input" class="form-label">NSM Madrasah <i
                                                class="bx bx-info-circle text-danger"data-bs-toggle="modal"
                                                data-bs-target="#informasi"></i></label>
                                        <input type="text" placeholder="" name="nsm" id="formrow-firstname-input"
                                            value="{{ old('nsm', $madrasah->nsm) }}"
                                            class="form-control @error('nsm') is-invalid @enderror">
                                        @error('nsm')
                                            <div class="invalid-feedback" style="display: block">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-6">
                                        <label for="formrow-firstname-input" class="form-label">NPSN Madrasah</label>
                                        <input type="text" placeholder="" name="npsn" id="formrow-firstname-input"
                                            value="{{ old('npsn', $madrasah->npsn) }}"
                                            class="form-control @error('npsn') is-invalid @enderror">
                                        @error('npsn')
                                            <div class="invalid-feedback" style="display: block">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mt-2">
                                    <div class="col-3">
                                        <label for="formrow-firstname-input" class="form-label">Siswa Kelas 7</label>
                                        <input type="text" placeholder="" name="siswa_tujuh" id="siswa_tujuh"
                                            value="{{ old('siswa_tujuh', $madrasah->siswa_tujuh) }}"
                                            class="form-control @error('siswa_tujuh') is-invalid @enderror">
                                        @error('siswa_tujuh')
                                            <div class="invalid-feedback" style="display: block">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-3">
                                        <label for="formrow-firstname-input" class="form-label">Siswa Kelas 8</label>
                                        <input type="text" placeholder="" name="siswa_delapan" id="siswa_delapan"
                                            value="{{ old('siswa_delapan', $madrasah->siswa_delapan) }}"
                                            class="form-control @error('siswa_delapan') is-invalid @enderror">
                                        @error('siswa_delapan')
                                            <div class="invalid-feedback" style="display: block">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-3">
                                        <label for="formrow-firstname-input" class="form-label">Siswa Kelas 9</label>
                                        <input type="text" placeholder="" name="siswa_sembilan" id="siswa_sembilan"
                                            value="{{ old('siswa_sembilan', $madrasah->siswa_sembilan) }}"
                                            class="form-control @error('siswa_sembilan') is-invalid @enderror">
                                        @error('siswa_sembilan')
                                            <div class="invalid-feedback" style="display: block">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-3">
                                        <label for="formrow-firstname-input" class="form-label">Total Siswa</label>
                                        <input type="text" placeholder="" value="{{ $total }}" readonly
                                            class="form-control">
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
