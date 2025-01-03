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
                        <form action="{{ route('cetak-notice.input-nopol') }}" method="post">
                            @csrf
                            <div class="card-body mt-2">
                                <div class="form-input">
                                    <div class="row justify-content-center">
                                        <div class="col-lg-3">
                                            <input type="text" readonly="" class="form-control"
                                                style="text-align:center;" value="{{ \Auth::user()->kd_lokasi }}">
                                        </div>
                                        <div class="col-lg-4">
                                            <input type="text" class="form-control no-notice" name="no_notice"
                                                placeholder="Nomor Notice" autofocus="" required="" min="1"
                                                maxlength="10" autocomplete="off" style="text-align: center;"
                                                value="<?= $no_notice ?>">
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

@section('scripts')
    <script>
        $('.no-polisi').keypress(function() {
            if (event.which != 8 && isNaN(String.fromCharCode(event.which))) {
                event.preventDefault();
            } else {
                $(this).val($(this).val().toUpperCase());
                if (event.keyCode == 32 || event.keyCode == 13) {
                    $('.no-polisi').val($('.no-polisi').val().replace(/\s/g, ''));
                    $(".code-polisi").focus();
                }
            }
        });
        $('.no-polisi').on('input', function() {
            var maxLength = parseInt($(this).attr('maxlength'));
            var currentLength = $(this).val().length;

            if (currentLength >= maxLength) {
                $('.code-polisi').focus();
            }
        });
        $('.code-polisi').on('input', function() {
            var currentLength = $(this).val().length;
            $(this).val($(this).val().toUpperCase());

            if (currentLength == 0) {
                $('.no-polisi').focus();
            } else if (currentLength == 2) {
                $('.tombol-submit').focus();
            }

        });
    </script>
@endsection
