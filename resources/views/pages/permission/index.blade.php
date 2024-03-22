@extends('layouts.main')

@section('title')
    Permission
@endsection

@section('content')
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="flex-container mb-4">
                    <h4 class="card-title">Permission</h4>
                    <button class="btn btn-success btn-sm btn-flat">Tambah</button>
                </div>
                <table class="table table-search row-border hover" id="crudTable">
                    <thead>
                        <tr>
                            <th width="4%">#</th>
                            <th>Permission</th>
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
                url: '{{ route('permission') }}',

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
            ],
        });
        // $.fn.dataTable.ext.classes.sPageButton = 'button btn-sm button-primary';
    </script>
@endpush
