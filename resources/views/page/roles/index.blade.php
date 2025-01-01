{{-- Extends layout --}}
@extends('layout.default')



{{-- Content --}}
@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">Manage Roles</div>
            <div class="card-body">
                @can('create-role')
                    <a href="{{ route('roles.create') }}" class="btn btn-success btn-sm my-2"><i class="bi bi-plus-circle"></i> Add
                        New Role</a>
                @endcan
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col" style="width: 250px;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($roles as $role)
                            <tr>
                                <th scope="row">{{ $loop->iteration }}</th>
                                <td>{{ $role->name }}</td>
                                <td>
                                    <form action="{{ route('roles.destroy', $role->id) }}" method="post" id="deleteForm">
                                        @csrf
                                        @method('DELETE')

                                        <a href="{{ route('roles.show', $role->id) }}" class="btn btn-warning btn-sm"><i
                                                class="bi bi-eye"></i> Show</a>

                                        @if ($role->name != 'Super Admin')
                                            @can('edit-role')
                                                <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-primary btn-sm"><i
                                                        class="bi bi-pencil-square"></i> Edit</a>
                                            @endcan

                                            @can('delete-role')
                                                @if ($role->name != Auth::user()->hasRole($role->name))
                                                    <button type="submit" class="btn btn-danger btn-sm"
                                                        onclick="confirmDelete(this)"><i class="bi bi-trash"></i>
                                                        Delete</button>
                                                @endif
                                            @endcan
                                        @endif

                                    </form>
                                </td>
                            </tr>
                        @empty
                            <td colspan="3">
                                <span class="text-danger">
                                    <strong>No Role Found!</strong>
                                </span>
                            </td>
                        @endforelse
                    </tbody>
                </table>

                {{ $roles->links() }}

            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function confirmDelete(button) {
            Swal.fire({
                title: 'Are you sure?',
                text: "Do you want to delete this Role?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Submit the form
                    document.getElementById('deleteForm').submit();
                }
            });
        }
    </script>
@endsection
