@extends('layouts.main')

@section('title')
    Dashboard
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-8">
            <div class="modal fade" id="eventModal" tabindex="-1" aria-labelledby="eventModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="eventModalLabel">Detail Event</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <!-- Konten modal akan ditampilkan di sini -->
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <h5 class=" mb-3">Pengumuman : </h5>
                    @foreach ($pengumuman as $data)
                        <div class="card">
                            <div class="card-header @if ($batas_waktu < $data->tanggal) bg-success @endif">
                                <div class="left-content">
                                    <h5 class="font-size-14 @if ($batas_waktu < $data->tanggal) text-white @endif">
                                        {{ $data->judul }}</h5>
                                </div>
                                <div class="right-content">
                                    <p
                                        class="float-sm-end @if ($batas_waktu < $data->tanggal) text-white
                                    @else
                                        text-muted @endif font-size-13">
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
        <div class="col-lg-4">
            <div class="card card-h-100">
                <div class="card-body">
                    <div class="btn-group mb-3">
                        <button type="button" class="btn btn-primary btn-sm btn-flat" id="btn-month">Month</button>
                        <button type="button" class="btn btn-primary btn-sm btn-flat" id="btn-week">Week</button>
                        <button type="button" class="btn btn-primary btn-sm btn-flat" id="btn-day">Day</button>
                        <button type="button" class="btn btn-primary btn-sm btn-flat" id="btn-list">List</button>
                    </div>
                    <div id="calendar"></div>
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

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var events = [];

        // Memproses data pengumuman menjadi event
        @foreach ($pengumuman as $data)
            events.push({
                title: '{{ $data->judul }}',
                start: '{{ $data->tanggal }}T{{ $data->jam }}', // Format ISO 8601: YYYY-MM-DDTHH:MM:SS
                // Jika Anda memiliki kolom 'end' untuk tanggal selesai, Anda dapat menambahkannya di sini
                // end: '{{ $data->end_date }}T{{ $data->end_time }}'
            });
        @endforeach

        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth', // Tampilan default
            height: 'auto', // Ketinggian disesuaikan dengan konten
            scrollTime: '00:00:00', // Tidak ada scroll vertikal
            events: events,
            eventClick: function(info) {
                // Menampilkan modal saat event diklik
                $('#eventModal .modal-body').html('<h5>' + info.event.title + '</h5><p>' + info
                    .event.start + '</p>');
                $('#eventModal').modal('show');
            }
        });

        calendar.render();

        document.getElementById('btn-month').addEventListener('click', function() {
            calendar.changeView('dayGridMonth');
        });

        // Tambahkan event listener untuk tombol navigasi
        document.getElementById('btn-week').addEventListener('click', function() {
            calendar.changeView('timeGridWeek');
        });

        document.getElementById('btn-day').addEventListener('click', function() {
            calendar.changeView('timeGridDay');
        });

        document.getElementById('btn-list').addEventListener('click', function() {
            calendar.changeView('list');
        });
    });
</script>
