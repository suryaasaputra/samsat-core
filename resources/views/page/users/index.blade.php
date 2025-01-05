{{-- Extends layout --}}
@extends('layout.default')



{{-- Content --}}
@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">Manage Users</div>
            <div class="card-body">
                @can('create-user')
                    <a href="{{ route('users.create') }}" class="btn btn-success btn-sm my-2"><i class="bi bi-plus-circle"></i> Add
                        New
                        User</a>
                @endcan
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Name</th>
                            <th scope="col">username</th>
                            <th scope="col">Roles</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $user)
                            <tr>
                                <th scope="row">{{ $loop->iteration }}</th>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->username }}</td>
                                <td>
                                    @forelse ($user->getRoleNames() as $role)
                                        <span class="badge bg-primary">{{ $role }}</span>
                                    @empty
                                    @endforelse
                                </td>
                                <td>
                                    <form action="{{ route('users.destroy', $user->id) }}" method="post" id="deleteForm">
                                        @csrf
                                        @method('DELETE')

                                        <a href="{{ route('users.show', $user->id) }}" class="btn btn-warning btn-sm"><i
                                                class="bi bi-eye"></i> Show</a>

                                        @if (in_array('Super Admin', $user->getRoleNames()->toArray() ?? []))
                                            @if (Auth::user()->hasRole('Super Admin'))
                                                <a href="{{ route('users.edit', $user->id) }}"
                                                    class="btn btn-primary btn-sm"><i class="bi bi-pencil-square"></i>
                                                    Edit</a>
                                            @endif
                                        @else
                                            @can('edit-user')
                                                <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary btn-sm"><i
                                                        class="bi bi-pencil-square"></i> Edit</a>
                                            @endcan

                                            @can('delete-user')
                                                @if (Auth::user()->id != $user->id)
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
                            <td colspan="5">
                                <span class="text-danger">
                                    <strong>No User Found!</strong>
                                </span>
                            </td>
                        @endforelse
                    </tbody>
                </table>

                {{ $users->links() }}

            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function confirmDelete(button) {
            Swal.fire({
                title: 'Are you sure?',
                text: "Do you want to delete this user?",
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
