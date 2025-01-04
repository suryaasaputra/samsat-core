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
                            Edit User
                        </div>
                        <div class="float-end">
                            <a href="{{ route('users.index') }}" class="btn btn-primary btn-sm">&larr; Back</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('users.update', $user->id) }}" method="post">
                            @csrf
                            @method('PUT')
                            <div class="mb-3 row">
                                <label for="name" class="form-label">Name</label>
                                <div>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        id="name" name="name" value="{{ $user->name }}">
                                    @if ($errors->has('name'))
                                        <span class="text-danger">{{ $errors->first('name') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="username" class="form-label">Username</label>
                                <div>
                                    <input type="text" class="form-control @error('username') is-invalid @enderror"
                                        id="username" name="username" value="{{ $user->username }}">
                                    @if ($errors->has('username'))
                                        <span class="text-danger">{{ $errors->first('username') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="email" class="form-label">Email
                                </label>
                                <div>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        id="email" name="email" value="{{ $user->email }}">
                                    @if ($errors->has('email'))
                                        <span class="text-danger">{{ $errors->first('email') }}</span>
                                    @endif
                                </div>
                            </div>


                            <div class="mb-3 row">
                                <label for="password" class="form-label">Password</label>
                                <div>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                                        id="password" name="password">
                                    @if ($errors->has('password'))
                                        <span class="text-danger">{{ $errors->first('password') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="password_confirmation" class="form-label">Confirm Password</label>
                                <div>
                                    <input type="password" class="form-control" id="password_confirmation"
                                        name="password_confirmation">
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="kd_wilayah" class="form-label">Wilayah</label>
                                <div>
                                    <select name="kd_wilayah"
                                        class="form-control wide @error('kd_wilayah') is-invalid @enderror"
                                        aria-label="kd_wilayah" id="kd_wilayah">
                                        @foreach ($wilayah as $item)
                                            <option value="{{ $item->kd_wilayah }}"
                                                @if ($user->kd_wilayah == $item->kd_wilayah) selected @endif>
                                                {{ $item->kd_wilayah }} - {{ $item->nm_wilayah }}
                                        @endforeach
                                    </select>
                                    @if ($errors->has('kd_wilayah'))
                                        <span class="text-danger">{{ $errors->first('kd_wilayah') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="kd_lokasi" class="form-label">Lokasi</label>
                                <div>
                                    <select name="kd_lokasi"
                                        class="default-select form-control wide @error('kd_lokasi') is-invalid @enderror"
                                        id="kd_lokasi">
                                        @foreach ($lokasi as $item)
                                            <option value="{{ $item->kd_lokasi }}"
                                                @if ($user->kd_lokasi == $item->kd_lokasi) selected @endif>
                                                {{ $item->kd_lokasi }} - {{ $item->nm_lokasi }}
                                        @endforeach


                                    </select>
                                    @if ($errors->has('kd_lokasi'))
                                        <span class="text-danger">{{ $errors->first('kd_lokasi') }}</span>
                                    @endif
                                </div>
                            </div>






                            <div class="mb-3 row">
                                <label for="printer_term" class="form-label">Printer</label>
                                <div>
                                    <input type="text" class="form-control @error('printer_term') is-invalid @enderror"
                                        id="printer_term" name="printer_term" value="{{ $user->printer_term }}">
                                    @if ($errors->has('printer_term'))
                                        <span class="text-danger">{{ $errors->first('printer_term') }}</span>
                                    @endif
                                </div>
                            </div>


                            <div class="mb-3 row">
                                <label for="roles" class="form-label">Roles</label>
                                <div>
                                    <select class="default-select form-control wide @error('roles') is-invalid @enderror"
                                        multiple aria-label="Roles" id="roles" name="roles[]">
                                        @forelse ($roles as $role)
                                            @if ($role != 'Super Admin')
                                                <option value="{{ $role }}"
                                                    {{ in_array($role, $userRoles ?? []) ? 'selected' : '' }}>
                                                    {{ $role }}
                                                </option>
                                            @else
                                                @if (Auth::user()->hasRole('Super Admin'))
                                                    <option value="{{ $role }}"
                                                        {{ in_array($role, $userRoles ?? []) ? 'selected' : '' }}>
                                                        {{ $role }}
                                                    </option>
                                                @endif
                                            @endif

                                        @empty
                                        @endforelse
                                    </select>
                                    @if ($errors->has('roles'))
                                        <span class="text-danger">{{ $errors->first('roles') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <input type="submit" class="col-md-3 offset-md-5 btn btn-primary" value="Update User">
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
