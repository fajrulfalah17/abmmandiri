@extends('layouts.main')

@section('title')
    Dashboard
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="font-size-14 mb-3">Pengumuman : </h5>
                    <div class="card">
                        <div class="card-header">
                            <div class="left-content">
                                <h5>Ini Judul</h5>
                            </div>
                            <div class="right-content">
                                <p class="float-sm-end text-muted font-size-13">
                                    <i class="fas fa-calendar-week"></i> 12 July, 2021
                                    <i class="fas fa-clock"></i> 19.00
                                </p>
                            </div>
                        </div>
                        <div class="card-body">
                            <p class="text-muted">Maecenas non vestibulum ante, nec
                                efficitur orci. Duis eu ornare mi, quis bibendum quam. Etiam
                                imperdiet aliquam purus sit amet rhoncus. Vestibulum pretium
                                consectetur leo, in mattis ipsum sollicitudin eget. Pellentesque
                                vel mi tortor.
                                Nullam vitae maximus dui dolor sit amet, consectetur adipiscing
                                elit.</p>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <div class="left-content">
                                <h5>Ini Judul</h5>
                            </div>
                            <div class="right-content">
                                <p class="float-sm-end text-muted font-size-13">
                                    <i class="fas fa-calendar-week"></i> 12 July, 2021
                                    <i class="fas fa-clock"></i> 19.00
                                </p>
                            </div>
                        </div>
                        <div class="card-body">
                            <p class="text-muted">Maecenas non vestibulum ante, nec
                                efficitur orci. Duis eu ornare mi, quis bibendum quam. Etiam
                                imperdiet aliquam purus sit amet rhoncus. Vestibulum pretium
                                consectetur leo, in mattis ipsum sollicitudin eget. Pellentesque
                                vel mi tortor.
                                Nullam vitae maximus dui dolor sit amet, consectetur adipiscing
                                elit.</p>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <div class="left-content">
                                <h5>Ini Judul</h5>
                            </div>
                            <div class="right-content">
                                <p class="float-sm-end text-muted font-size-13">
                                    <i class="fas fa-calendar-week"></i> 12 July, 2021
                                    <i class="fas fa-clock"></i> 19.00
                                </p>
                            </div>
                        </div>
                        <div class="card-body">
                            <p class="text-muted">Maecenas non vestibulum ante, nec
                                efficitur orci. Duis eu ornare mi, quis bibendum quam. Etiam
                                imperdiet aliquam purus sit amet rhoncus. Vestibulum pretium
                                consectetur leo, in mattis ipsum sollicitudin eget. Pellentesque
                                vel mi tortor.
                                Nullam vitae maximus dui dolor sit amet, consectetur adipiscing
                                elit.</p>
                        </div>
                    </div>
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
