@extends('layouts.main')
@section('title')
    Data Guru
@endsection


@section('content')
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="flex-container mb-4">
                    <h4 class="card-title">User</h4>
                    <a href="{{ route('guru.create') }}" class="btn btn-success btn-sm btn-flat">Tambah</a>
                </div>
                <table class="table table-search row-border hover" id="crudTable">
                    <thead>
                        <tr>
                            <th width="4%">#</th>
                            <th>Nama Guru</th>
                            <th>Username</th>
                            <th>MGMP</th>
                            <th>ASAL SEKOLAH</th>
                            <th width="10%"><i class="fa fa-cog"></i></th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>

            </div>
            <!-- end card body -->
        </div>
    </div>
@endsection

@push('addon-style')
    <style>
        div.dt-container .dt-paging .dt-paging-button {
            padding: 0;
            margin: 5px
        }

        .flex-container {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .card-title {
            margin: 0;
        }
    </style>
@endpush

@push('addon-script')
    <script>
        var i = 1;
        var datatable = $('#crudTable').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            pagingType: 'simple_numbers',
            "order": [
                [0, 'asc']
            ],
            ordering: true,
            ajax: {
                url: '{{ route('guru.index') }}',

            },
            columns: [{
                    "data": null,
                    "class": "align-top",
                    "orderable": false,
                    "searchable": false,
                    "render": function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    data: 'users.name',
                    render: function(data) {
                        if (data == null) {
                            return '-'
                        }
                        return data;

                    },
                    orderable: true
                },
                {
                    data: 'users.username',
                    render: function(data) {
                        if (data == null) {
                            return '-'
                        }
                        return data;

                    },
                    orderable: true
                },
                {
                    data: 'mgmp',
                    render: function(data) {
                        if (data == null) {
                            return '-'
                        }
                        return data;

                    },
                    orderable: true
                },
                {
                    data: 'asal_sekolah',
                    render: function(data) {
                        if (data == null) {
                            return '-'
                        }
                        return data;

                    },
                    orderable: true
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false
                }
            ],
        });
        // $.fn.dataTable.ext.classes.sPageButton = 'button btn-sm button-primary';
    </script>
@endpush
