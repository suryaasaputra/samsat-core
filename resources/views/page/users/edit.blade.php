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
                                        id="username" name="username" value="{{ $user->username }}" maxlength="15"
                                        oninput="this.value = this.value.toLowerCase().replace(/\s+/g, '')"
                                        aria-describedby="usernameHelp">
                                    @if ($errors->has('username'))
                                        <span class="text-danger">{{ $errors->first('username') }}</span>
                                    @endif
                                    <small id="usernameHelp" class="form-text text-muted">
                                        Username max 15 karakter hanya boleh berisi huruf kecil, angka, underscore (_) dan
                                        tanpa spasi.
                                    </small>
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
                                        id="password" name="password" aria-describedby="passwordHelp">
                                    @if ($errors->has('password'))
                                        <span class="text-danger">{{ $errors->first('password') }}</span>
                                    @endif
                                    <small id="passwordHelp" class="form-text text-danger" style="display: none;">
                                        Password minimal 8 karakter.
                                    </small>
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="password_confirmation" class="form-label">Confirm Password</label>
                                <div>
                                    <input type="password" class="form-control" id="password_confirmation"
                                        name="password_confirmation">
                                    <small id="passwordConfirmationHelp" class="form-text text-danger"
                                        style="display: none;">
                                        Password tidak cocok.
                                    </small>
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="kd_wilayah" class="select2-label">Wilayah</label>
                                <div>
                                    <select name="kd_wilayah" id="kd_wilayah"
                                        class="select2-with-label-single js-states d-block @error('kd_wilayah') is-invalid @enderror"
                                        aria-label="kd_wilayah">
                                        <option value="">-- Pilih Wilayah --</option>
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
                                <label for="kd_lokasi" class="select2-label">Lokasi</label>
                                <div>
                                    <select name="kd_lokasi" id="kd_lokasi"
                                        class="select2-with-label-single js-states d-block @error('kd_lokasi') is-invalid @enderror">
                                        <option value="">-- Pilih Wilayah Terlebih Dahulu --</option>
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
                                <label for="roles" class="select2-label">Roles</label>
                                <div>
                                    <select
                                        class="select2-with-label-multiple js-states @error('roles') is-invalid @enderror "
                                        multiple="multiple"tabindex="null" aria-label="Roles" id="roles"
                                        name="roles[]">
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
    <script>
        $(document).ready(function() {
            // Pada saat halaman pertama kali dimuat
            let kd_wilayah = $('#kd_wilayah').val(); // Ambil nilai awal dari dropdown kd_wilayah
            if (kd_wilayah) {
                populateLokasi(kd_wilayah); // Panggil fungsi untuk mengisi dropdown kd_lokasi
            }

            // Event listener untuk perubahan pada kd_wilayah
            $('#kd_wilayah').on('change', function() {
                let kd_wilayah = $(this).val();
                console.log('Wilayah Terpilih:', kd_wilayah); // Debugging

                if (kd_wilayah) {
                    populateLokasi(kd_wilayah); // Panggil fungsi yang sama saat berubah
                } else {
                    $('#kd_lokasi')
                        .empty()
                        .append('<option value="">-- Pilih Wilayah Dahulu --</option>');
                }
            });

            $('#password, #password_confirmation').on('input', function() {
                const password = $('#password').val();
                const passwordConfirmation = $('#password_confirmation').val();

                // Check password length
                if (password.length < 8) {
                    $('#passwordHelp').show(); // Show length error
                } else {
                    $('#passwordHelp').hide(); // Hide length error
                }

                // Check if passwords match
                if (password !== passwordConfirmation) {
                    $('#passwordConfirmationHelp').show(); // Show mismatch error
                } else {
                    $('#passwordConfirmationHelp').hide(); // Hide mismatch error
                }
            });

            // Fungsi untuk mengisi dropdown kd_lokasi
            function populateLokasi(kd_wilayah) {
                $.ajax({
                    url: "{{ route('fetch.lokasi') }}",
                    type: "GET",
                    data: {
                        kd_wilayah: kd_wilayah
                    },
                    success: function(data) {
                        console.log('Lokasi:', data); // Debugging
                        var userKdLokasi = "{{ $user->kd_lokasi }}"; // Get user's current location

                        var options = data.map(function(item) {
                            // Check if the current location matches the user's location
                            var selected = userKdLokasi == item.kd_lokasi ? "selected" : "";
                            return (
                                '<option value="' +
                                item.kd_lokasi +
                                '" ' +
                                selected +
                                '>' +
                                item.kd_lokasi +
                                " - " +
                                item.nm_lokasi +
                                '</option>'
                            );
                        });

                        $('#kd_lokasi')
                            .empty()
                            .append('<option value="">-- Pilih Lokasi --</option>')
                            .append(options.join(''))
                            .trigger('change'); // Pastikan UI diperbarui
                    },
                    error: function(xhr) {
                        console.error('Error:', xhr); // Debugging error
                        alert('Unable to fetch Lokasi data. Please try again.');
                    }
                });
            }
        });
    </script>
@endsection
