@extends('layouts.main')

@section('title')
    Edit Bank Soal
@endsection

@section('content')
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">

                <h6>Form Edit Bank Soal :</h6>

                <form action="{{ route('bank-soal.update', $bank_soal->id) }}" enctype="multipart/form-data" method="POST">
                    @csrf
                    @method('put')
                    <div class="row mt-2">
                        <div class="col-4">
                            <label for="formrow-firstname-input" class="form-label">Kegiatan</label>
                            <select name="kegiatan_id" class="form-select @error('kegiatan_id') is-invalid @enderror" id="">
                                @foreach ($kegiatan as $item)
                                    <option value="{{ $item->id }}" {{ $item->id == $bank_soal->kegiatan_id ? 'selected' : '' }}>{{ $item->nama }}</option>
                                @endforeach
                            </select>
                            @error('kisi_kisi')
                                <div class="invalid-feedback" style="display: block">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-4">
                            <label for="formrow-firstname-input" class="form-label">Link</label>
                            <input type="text" placeholder="" name="link" id="link" value="{{ old('link', $bank_soal->link) }}"
                                class="form-control @error('link') is-invalid @enderror">
                            @error('link')
                                <div class="invalid-feedback" style="display: block">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-12">
                            <label>Deskripsi</label>
                            <textarea class="form-control deskripsi @error('deskripsi') is-invalid @enderror" name="deskripsi"
                                placeholder="Masukkan Konten / Deskripsi Berita" rows="10">{!! old('deskripsi', $bank_soal->deskripsi) !!}</textarea>
                            @error('deskripsi')
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
            selector: "textarea.deskripsi",
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
