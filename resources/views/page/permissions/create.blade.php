{{-- Extends layout --}}
@extends('layout.default')



{{-- Content --}}
@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">
                        <div class="float-start">
                            Add New Permission
                        </div>
                        <div class="float-end">
                            <a href="{{ route('permissions.index') }}" class="btn btn-primary btn-sm">&larr; Back</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('permissions.store') }}" method="post">
                            @csrf
                            <div class="mb-3 row">
                                <label for="name" class="form-label">Name</label>
                                <div>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        id="name" name="name" value="{{ old('name') }}">
                                    @if ($errors->has('name'))
                                        <span class="text-danger">{{ $errors->first('name') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <input type="submit" class="col-md-3 offset-md-5 btn btn-primary" value="Add Permission">
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('scripts')
    {{-- <script>
        $('#kd_wilayah').on('change', function() {
            let kd_wilayah = $(this).val();

            if (kd_wilayah) {
                $.ajax({
                    url: "{{ route('fetch.lokasi') }}", // The route to fetch Lokasi
                    type: "GET",
                    data: {
                        kd_wilayah: kd_wilayah
                    },
                    success: function(data) {
                        console.log(data); // For debugging
                        var options = data.map(function(item) {
                            return '<option value="' + item.kd_lokasi + '">' + item
                                .kd_lokasi + " - " + item.nm_lokasi + '</option>';
                        });

                        // Ensure the dropdown is emptied and updated correctly
                        $('#kd_lokasi').empty().append(
                            '<option value="">-- Select Lokasi --</option>');
                        $('#kd_lokasi').append(options.join(''));
                    },
                    error: function() {
                        alert('Unable to fetch Lokasi data. Please try again.');
                    }
                });
            } else {
                $('#kd_lokasi').empty().append(
                    '<option value="">Pilih Wilayah Terlebih Dahulu</option>');
            }
        });
    </script> --}}
@endsection
