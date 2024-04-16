@extends('layout')

@section('content')

<div class="row justify-content-center mt-3">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">Role List</div>
            <div class="card-body">
                <a href="{{ route('roles.create') }}" class="btn btn-success btn-sm my-2"><i class="bi bi-plus-circle"></i> Add new role</a>
                <table class="table table-striped table-bordered">
                    <thead>
                      <tr>
                        <th scope="col">S#</th>
                        <th scope="col">Role</th>
                        <th scope="col">Description</th>
                        <th scope="col">Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                        @forelse ($items as $role)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $role->role }}</td>
                            <td>{{ $role->description }}</td>
                            <td>
                                <form action="{{ route('roles.destroy', $role->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <a href="{{ route('roles.show', $role->id) }}" class="btn btn-warning btn-sm"><i class="bi bi-eye"></i> Show</a>
                                    <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-primary btn-sm"><i class="bi bi-pencil-square"></i> Edit</a>   
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Do you want to delete this role?');"><i class="bi bi-trash"></i> Delete</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                            <td colspan="6">
                                <span class="text-danger">
                                    <strong>No role found!</strong>
                                </span>
                            </td>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>    
</div>
    
@endsection