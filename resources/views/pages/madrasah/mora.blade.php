@extends('layouts.main')
@section('title')
    Data Mora
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
                            <a class="nav-link active" href="{{ route('mora-madrasah', $madrasah->id) }}" role="tab">
                                <span>Moda Ujian</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('rdm-madrasah', $madrasah->id) }}" role="tab">
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
                            <h5 class="font-size-16 mb-3">Data Pelaksanaan</h5>
                            <form action="{{ route('madrasah.updateMora', $madrasah->id) }}" enctype="multipart/form-data"
                                method="POST">
                                @csrf
                                @method('put')

                                <div class="row mt-2">
                                    <div class="col-3">
                                        <label for="formrow-firstname-input" class="form-label">PAS 7 8 9</label>
                                        <select name="pas_tujuh_delapan_sembilan" class="form-select">
                                            <option value="">Pilih</option>
                                            <option value="KERTAS"
                                                {{ $madrasah->mora->pas_tujuh_delapan_sembilan == 'KERTAS' ? 'selected' : '' }}>
                                                Kertas</option>
                                            <option value="LOKAL"
                                                {{ $madrasah->mora->pas_tujuh_delapan_sembilan == 'LOKAL' ? 'selected' : '' }}>
                                                Server Lokal</option>
                                            <option value="MANDIRI"
                                                {{ $madrasah->mora->pas_tujuh_delapan_sembilan == 'MANDIRI' ? 'selected' : '' }}>
                                                Hosting Mandiri</option>
                                            <option value="MAARIF"
                                                {{ $madrasah->mora->pas_tujuh_delapan_sembilan == 'MAARIF' ? 'selected' : '' }}>
                                                Hosting Ma`arif</option>
                                        </select>
                                    </div>

                                    <div class="col-3">
                                        <label for="formrow-firstname-input" class="form-label">PAT 9</label>
                                        <select name="pat_sembilan" class="form-select">
                                            <option value="">Pilih</option>
                                            <option value="KERTAS"
                                                {{ $madrasah->mora->pat_sembilan == 'KERTAS' ? 'selected' : '' }}>Kertas
                                            </option>
                                            <option value="LOKAL"
                                                {{ $madrasah->mora->pat_sembilan == 'LOKAL' ? 'selected' : '' }}>Server
                                                Lokal</option>
                                            <option value="MANDIRI"
                                                {{ $madrasah->mora->pat_sembilan == 'MANDIRI' ? 'selected' : '' }}>Hosting
                                                Mandiri</option>
                                            <option value="MAARIF"
                                                {{ $madrasah->mora->pat_sembilan == 'MAARIF' ? 'selected' : '' }}>Hosting
                                                Ma`arif</option>
                                        </select>
                                    </div>

                                    <div class="col-3">
                                        <label for="formrow-firstname-input" class="form-label">AM 9</label>
                                        <select name="am_sembilan" class="form-select">
                                            <option value="">Pilih</option>
                                            <option value="KERTAS"
                                                {{ $madrasah->mora->am_sembilan == 'KERTAS' ? 'selected' : '' }}>Kertas
                                            </option>
                                            <option value="LOKAL"
                                                {{ $madrasah->mora->am_sembilan == 'LOKAL' ? 'selected' : '' }}>Server
                                                Lokal</option>
                                            <option value="MANDIRI"
                                                {{ $madrasah->mora->am_sembilan == 'MANDIRI' ? 'selected' : '' }}>Hosting
                                                Mandiri</option>
                                            <option value="MAARIF"
                                                {{ $madrasah->mora->am_sembilan == 'MAARIF' ? 'selected' : '' }}>Hosting
                                                Ma`arif</option>
                                        </select>
                                    </div>

                                    <div class="col-3">
                                        <label for="formrow-firstname-input" class="form-label">PAT 7 8</label>
                                        <select name="pat_tujuh_delapan" class="form-select">
                                            <option value="">Pilih</option>
                                            <option value="KERTAS"
                                                {{ $madrasah->mora->pat_tujuh_delapan == 'KERTAS' ? 'selected' : '' }}>
                                                Kertas</option>
                                            <option value="LOKAL"
                                                {{ $madrasah->mora->pat_tujuh_delapan == 'LOKAL' ? 'selected' : '' }}>
                                                Server Lokal</option>
                                            <option value="MANDIRI"
                                                {{ $madrasah->mora->pat_tujuh_delapan == 'MANDIRI' ? 'selected' : '' }}>
                                                Hosting Mandiri</option>
                                            <option value="MAARIF"
                                                {{ $madrasah->mora->pat_tujuh_delapan == 'MAARIF' ? 'selected' : '' }}>
                                                Hosting Ma`arif</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row mt-2">
                                    <div class="col-6">
                                        <label for="formrow-firstname-input" class="form-label">User CBT</label>
                                        <input type="text" placeholder="" name="user_cbt"
                                            id="formrow-firstname-input"
                                            value="{{ old('user_cbt', $madrasah->mora->user_cbt) }}"
                                            class="form-control">
                                    </div>
                                    <div class="col-6">
                                        <label for="formrow-firstname-input" class="form-label">Password CBT</label>
                                        <input type="text" placeholder="" name="password_cbt"
                                            id="formrow-firstname-input"
                                            value="{{ old('password_cbt', $madrasah->mora->password_cbt) }}"
                                            class="form-control">
                                    </div>
                                </div>

                                <div class="row mt-2">
                                    <div class="col-6">
                                        <label for="formrow-firstname-input" class="form-label">Link Hosting
                                            Mandiri</label>
                                        <input type="text" placeholder="" name="link_hosting_mandiri"
                                            id="formrow-firstname-input"
                                            value="{{ old('link_hosting_mandiri', $madrasah->mora->link_hosting_mandiri) }}"
                                            class="form-control">
                                        @if ($madrasah->mora->link_hosting_mandiri)
                                            <a class="mt-2" target="_blank" href="{{ $madrasah->mora->link_hosting_mandiri }}"><i
                                                    class="bx bx-link-external"></i> Go to </a>
                                        @endif
                                    </div>
                                    <div class="col-6">
                                        <label for="formrow-firstname-input" class="form-label">Link Hosting
                                            Ma`arif</label>
                                        <input type="text" placeholder="" name="link_hosting_maarif" {{ Auth::user()->posisi == 'MADRASAH' ? 'readonly' : '' }}
                                            id="formrow-firstname-input"
                                            value="{{ old('link_hosting_maarif', $madrasah->mora->link_hosting_maarif) }}"
                                            class="form-control">
                                        @if ($madrasah->mora->link_hosting_maarif)
                                            <a class="mt-2" target="_blank" href="{{ $madrasah->mora->link_hosting_maarif }}"><i
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
