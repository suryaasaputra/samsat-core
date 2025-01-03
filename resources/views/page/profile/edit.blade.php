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
                            Edit Profile
                        </div>
                        <div class="float-end">
                            <a href="{{ route('home') }}" class="btn btn-primary btn-sm">&larr; Back</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('profile.update') }}" method="post">
                            @csrf
                            @method('PUT')
                            <div class="mb-3 row">
                                <label for="name" class="form-label">Nama <span class="text-danger">*</span></label>
                                <div>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        id="name" name="name" value="{{ old('name', $user->name) }}">
                                    @if ($errors->has('name'))
                                        <span class="text-danger">{{ $errors->first('name') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="username" class="form-label">Username <span class="text-danger">*</span></label>
                                <div>
                                    <input type="text" class="form-control @error('username') is-invalid @enderror"
                                        id="username" name="username" value="{{ old('username', $user->username) }}"
                                        oninput="this.value = this.value.toLowerCase().replace(/\s+/g, '')"
                                        aria-describedby="usernameHelp">
                                    @if ($errors->has('username'))
                                        <span class="text-danger">{{ $errors->first('username') }}</span>
                                    @endif
                                    <small id="usernameHelp" class="form-text text-muted">
                                        Username hanya boleh berisi huruf kecil, angka, underscore (_) dan tanpa spasi.
                                    </small>
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="email" class="form-label">Email <span class="text-danger">*</span>
                                </label>
                                <div>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        id="email" name="email" value="{{ old('email', $user->email) }}">
                                    @if ($errors->has('email'))
                                        <span class="text-danger">{{ $errors->first('email') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="current_password" class="form-label">Password Saat Ini <span
                                        class="text-danger">*</span></label>
                                <div>
                                    <input type="password"
                                        class="form-control @error('current_password') is-invalid @enderror"
                                        id="current_password" name="current_password">
                                    @if ($errors->has('current_password'))
                                        <span class="text-danger">{{ $errors->first('current_password') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="password" class="form-label">Password Baru</label>
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
                                <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
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
                                <button type="submit" class="btn btn-primary">Simpan</button>
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
        });
    </script>
@endsection
