@extends('layouts.main')

@section('title')
    Tambah Pengumuman
@endsection

@section('content')
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">

                <h6>Form Tambah Pengumuman :</h6>

                <form action="{{ route('pengumuman.store') }}" enctype="multipart/form-data" method="POST">
                    @csrf
                    <div class="row mt-2">
                        <div class="col-4">
                            <label for="formrow-firstname-input" class="form-label">Judul</label>
                            <input type="text" placeholder="" name="judul" id="formrow-firstname-input"
                                value="{{ old('judul') }}" class="form-control @error('judul') is-invalid @enderror">
                            @error('judul')
                                <div class="invalid-feedback" style="display: block">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-4">
                            <label for="formrow-firstname-input" class="form-label">Tanggal</label>
                            <input type="date" placeholder="" name="tanggal" id="tanggal" value="{{ old('tanggal') }}"
                                class="form-control @error('tanggal') is-invalid @enderror">
                            @error('tanggal')
                                <div class="invalid-feedback" style="display: block">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-4">
                            <label for="formrow-firstname-input" class="form-label">Waktu</label>
                            <input type="time" name="jam" class="form-control @error('jam') is-invalid @enderror" value="{{ old('jam') }}"
                                id="datepicker-timepicker">

                            @error('jam')
                                <div class="invalid-feedback" style="display: block">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-12">
                            <label>Isi Pengumuman</label>
                            <textarea class="form-control isi @error('isi') is-invalid @enderror" name="isi"
                                placeholder="Masukkan Konten / Isi Berita" rows="10">{!! old('isi') !!}</textarea>
                            @error('isi')
                                <div class="invalid-feedback" style="display: block">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="float-end mt-2">
                        <button type="button" onclick="goBack()" class="btn btn-secondary btn-sm btn-flat w-sm"><i
                                class="bx bx-arrow-back"></i>
                            Kembali</button>
                        <button type="submit" class="btn btn-success btn-sm btn-flat w-sm"><i class="bx bxs-send"></i>
                            Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('addon-script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/5.6.2/tinymce.min.js"></script>
    <script>
        var editor_config = {
            selector: "textarea.isi",
            plugins: [
                "advlist autolink lists link image charmap print preview hr anchor pagebreak",
                "searchreplace wordcount visualblocks visualchars code fullscreen",
                "insertdatetime media nonbreaking save table contextmenu directionality",
                "emoticons template paste textcolor colorpicker textpattern"
            ],
            toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media",
            relative_urls: false,
        };

        tinymce.init(editor_config);
    </script>
@endpush
