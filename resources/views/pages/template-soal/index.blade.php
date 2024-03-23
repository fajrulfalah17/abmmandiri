@extends('layouts.main')
@section('title')
    Template Soal
@endsection


@section('content')
    @foreach ($data as $item)
        <div id="hapusModal_{{ $item->id }}" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel"
            aria-hidden="true" data-bs-scroll="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalLabel"><span class="text-danger"><b>PERINGATAN!</b></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('template-soal.destroy', $item->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('delete')

                            <p>Yakin ingin menghapus data <b style="color: red">{{ $item->nama }}</b> ?</p>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary btn-sm waves-effect"
                                    data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-danger btn-sm waves-effect waves-light">Delete
                                </button>
                            </div>
                        </form>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
    @endforeach
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="flex-container mb-4">
                    <h4 class="card-title">Template Soal</h4>
                    <a href="{{ route('template-soal.create') }}" class="btn btn-success btn-sm btn-flat">Tambah</a>
                </div>
                <table class="table table-search row-border hover" id="crudTable">
                    <thead>
                        <tr>
                            <th width="4%">#</th>
                            <th>Publisher</th>
                            <th>Kegiatan</th>
                            <th>Template Soal</th>
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
                url: '{{ route('template-soal.index') }}',

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
                    data: 'guru',
                    render: function(data) {
                        if (data == null) {
                            return '-'
                        }
                        return data;

                    },
                    orderable: true
                },
                {
                    data: 'kegiatan.nama',
                    render: function(data) {
                        if (data == null) {
                            return '-'
                        }
                        return data;

                    },
                    orderable: true
                },
                {
                    data: 'download',
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
