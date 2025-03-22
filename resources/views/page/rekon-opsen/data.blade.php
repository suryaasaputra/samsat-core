{{-- Extends layout --}}
@extends('layout.default')



{{-- Content --}}
@section('content')
    <div class="col mt-2 px-3">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Provinsi Jambi</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="mb-3 col-md-12">
                        <label class="form-label">Nominal</label>
                        <input type="text" class="form-control">
                    </div>
                </div>
                <div class="row">
                    <div class="mb-3 col-md-12">
                        <label class="form-label">Kode Referensi</label>
                        <input type="text" class="form-control">
                    </div>
                </div>
                <div class="row">
                    <div class="mb-3 col-md-12">
                        <label class="form-label">Keterangan</label>
                        <textarea class="form-control" rows="4" id="comment"></textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="mb-3 col-md-12">
                        <label class="form-label">Lampiran</label>
                        <input type="file" class="form-file-input form-control">
                    </div>
                </div>
            </div>
            <div class="card-footer d-sm-flex justify-content-between align-items-center">
                <button class="btn btn-primary">Submit</button>
            </div>
        </div>
    </div>
@endsection
