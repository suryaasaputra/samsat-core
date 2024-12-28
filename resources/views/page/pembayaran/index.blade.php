{{-- Extends layout --}}
@extends('layout.default')



{{-- Content --}}
@section('content')
    <div class="container-fluid">

        <div class="col px-3">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Input No Polisi</h4>
                </div>
                <div class="card-body">
                    <div class="basic-form">
                        <form action="{{ route('search-nopol') }}" method="post">
                            @csrf
                            <div class="card-body mt-2">
                                <div class="form-input">
                                    <div class="row justify-content-center">
                                        <div class="col-lg-2">
                                            <input type="text" value="BH" disabled class="form-control"
                                                style="text-align:center;">
                                        </div>
                                        <div class="col-lg-4">
                                            <input type="text" class="form-control no-polisi" name="no_polisi"
                                                placeholder="No Polisi" autofocus="" required="" min="1"
                                                maxlength="4" autocomplete="off" style="text-align: center;">
                                        </div>
                                        <div class="col-lg-2">
                                            <input type="text" class="form-control code-polisi"
                                                style="text-align:center;" maxlength="3" pattern="[A-Z]+" name="seri"
                                                placeholder="Seri" autocomplete="off">
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="card-footer text-center">

                                <button type="submit" class="btn btn-primary tombol-submit">Submit</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>

    </div>
@endsection
