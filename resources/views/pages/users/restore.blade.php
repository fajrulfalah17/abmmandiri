@extends('backend.layout')
@section('title')
    User Admin Trashed
@endsection

@section('breadcrumb')
    Recovery
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-12">
                <div class="card card-secondary">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h3 class="card-title">Daftar Admin Trashed</h3>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table class="table row-border hover" id="crudTable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Username</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div>
@endsection

@push('addon-style')
    <style>
        .paginate_button {
            font-size: 11px;
        }

        .dataTables_info {
            font-size: 11px
        }

        .dataTables_length {
            font-size: 12px
        }

        .dataTables_filter {
            font-size: 12px
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
            "order": [
                [0, 'asc']
            ],
            ordering: true,
            ajax: {
                url: '{{ route('user-admin.index-restore') }}',

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
                    data: 'name',
                    render: function(data) {
                        if (data == null) {
                            return '-'
                        }
                        return data;

                    },
                    orderable: true
                },
                {
                    data: 'username',
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
