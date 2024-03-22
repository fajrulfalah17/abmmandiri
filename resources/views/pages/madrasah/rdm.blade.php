@extends('layouts.main')
@section('title')
    Data RDM
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
                            <img src="{{ asset('Admin/dist/assets/images/users/avatar-3.jpg') }}" alt=""
                                class="avatar-xl rounded-circle img-thumbnail">

                            <div class="mt-3">
                                <h5 class="mb-1">{{ $madrasah->details->kamad ?? 'Kepala Madrasah' }}</h5>
                                <p class="text-muted mb-0">
                                    {{-- <i class="bx bxs-star text-warning font-size-14"></i>
                                    <i class="bx bxs-star text-warning font-size-14"></i>
                                    <i class="bx bxs-star text-warning font-size-14"></i>
                                    <i class="bx bxs-star text-warning font-size-14"></i>
                                    <i class="bx bxs-star-half text-warning font-size-14"></i> --}}
                                    Nip. {{ $madrasah->details->nip ?? '-' }}
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
                            <a class="nav-link" href="{{ route('madrasah.edit', $madrasah->id) }}" role="tab">
                                <span>Data Madrasah</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('details-madrasah', $madrasah->id) }}" role="tab">
                                <span>Tim Teknis</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('mora-madrasah', $madrasah->id) }}" role="tab">
                                <span>Pelasanaan</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="{{ route('rdm-madrasah', $madrasah->id) }}" role="tab">
                                <span>RDM</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Tab content -->
            <div class="tab-content">
                <div class="tab-pane active" id="overview" role="tabpanel">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="font-size-16 mb-3">Data RDM</h5>
                            <form action="{{ route('madrasah.updateRdm', $madrasah->id) }}" enctype="multipart/form-data"
                                method="POST">
                                @csrf
                                @method('put')

                                <div class="row mt-2">
                                    <div class="col-4">
                                        <label for="formrow-firstname-input" class="form-label">PAS 7 8 9</label>
                                        <select name="jenis_server_rdm" class="form-select">
                                            <option value="">Pilih</option>
                                            <option value="KERTAS"
                                                {{ $madrasah->rdm->jenis_server_rdm == 'KERTAS' ? 'selected' : '' }}>
                                                Kertas</option>
                                            <option value="LOKAL"
                                                {{ $madrasah->rdm->jenis_server_rdm == 'LOKAL' ? 'selected' : '' }}>
                                                Server Lokal</option>
                                            <option value="MANDIRI"
                                                {{ $madrasah->rdm->jenis_server_rdm == 'MANDIRI' ? 'selected' : '' }}>
                                                Hosting Mandiri</option>
                                            <option value="MAARIF"
                                                {{ $madrasah->rdm->jenis_server_rdm == 'MAARIF' ? 'selected' : '' }}>
                                                Hosting Ma`arif</option>
                                        </select>
                                    </div>

                                    <div class="col-4">
                                        <label for="formrow-firstname-input" class="form-label">User RDM</label>
                                        <input type="text" placeholder="" name="user_rdm"
                                            id="formrow-firstname-input"
                                            value="{{ old('user_rdm', $madrasah->rdm->user_rdm) }}"
                                            class="form-control">
                                    </div>
                                    <div class="col-4">
                                        <label for="formrow-firstname-input" class="form-label">Password RDM</label>
                                        <input type="text" placeholder="" name="password_rdm"
                                            id="formrow-firstname-input"
                                            value="{{ old('password_rdm', $madrasah->rdm->password_rdm) }}"
                                            class="form-control">
                                    </div>
                                </div>

                                <div class="row mt-2">
                                    <div class="col-6">
                                        <label for="formrow-firstname-input" class="form-label">Link RDM
                                            Mandiri</label>
                                        <input type="text" placeholder="" name="link_rdm_mandiri"
                                            id="formrow-firstname-input"
                                            value="{{ old('link_rdm_mandiri', $madrasah->rdm->link_rdm_mandiri) }}"
                                            class="form-control">
                                        @if ($madrasah->rdm->link_rdm_mandiri)
                                            <a class="mt-2" target="_blank" href="{{ $madrasah->rdm->link_rdm_mandiri }}"><i
                                                    class="bx bx-link-external"></i> Go to </a>
                                        @endif
                                    </div>
                                    <div class="col-6">
                                        <label for="formrow-firstname-input" class="form-label">Link RDM
                                            Ma`arif</label>
                                        <input type="text" placeholder="" name="link_rdm_maarif"
                                            id="formrow-firstname-input"
                                            value="{{ old('link_rdm_maarif', $madrasah->rdm->link_rdm_maarif) }}"
                                            class="form-control">
                                        @if ($madrasah->rdm->link_rdm_maarif)
                                            <a class="mt-2" target="_blank" href="{{ $madrasah->rdm->link_rdm_maarif }}"><i
                                                    class="bx bx-link-external"></i> Go to </a>
                                        @endif
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
