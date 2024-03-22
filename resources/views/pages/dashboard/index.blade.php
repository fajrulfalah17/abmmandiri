@extends('layouts.main')

@section('title')
    Dashboard
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h5 class=" mb-3">Pengumuman : </h5>
                    @php
                        echo($batas_waktu);
                    @endphp
                    @foreach ($pengumuman as $data)
                        <div class="card">
                            <div class="card-header @if ($batas_waktu < $data->tanggal) bg-success @endif">
                                <div class="left-content">
                                    <h5 class="font-size-14 @if ($batas_waktu < $data->tanggal) text-white @endif">{{ $data->judul }}</h5>
                                </div>
                                <div class="right-content">
                                    <p class="float-sm-end @if ($batas_waktu < $data->tanggal)
                                        text-white
                                    @else
                                        text-muted
                                    @endif font-size-13">
                                        <i class="fas fa-calendar-week"></i> {{ TanggalID($data->tanggal) }}
                                        <i class="fas fa-clock"></i> {{ $data->jam }}
                                    </p>
                                </div>
                            </div>
                            <div class="card-body">
                                <p class="text-muted">
                                    {!! $data->isi !!}

                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection

@push('addon-style')
    <style>
        .card-header {
            padding: 10px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            background-color: #f4f4f4;
            height: 100%;
        }

        .card-body {
            padding: 10px 24px;

        }

        .left-content,
        .right-content {
            display: flex;
            align-items: center;
        }

        .left-content h5 {
            margin: 0;
            /* Menghapus margin default pada h5 */
        }

        .right-content p {
            margin: 0;
            /* Menghapus margin default pada p */
        }
    </style>
@endpush
