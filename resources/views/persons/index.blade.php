@extends('layout')

@section('content')

<div class="row justify-content-center mt-3">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">Person List</div>
            <div class="card-body">
                <a href="{{ route('persons.create') }}" class="btn btn-success btn-sm my-2"><i class="bi bi-plus-circle"></i> Add New Person</a>
                <table class="table table-striped table-bordered">
                    <thead>
                      <tr>
                        <th scope="col">S#</th>
                        <th scope="col">Full name</th>
                        <th scope="col">Gender</th>
                        <th scope="col">Phone number</th>
                        <th scope="col">Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                        @forelse ($items as $person)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $person->full_name }}</td>
                            <td>{{ $person->gender }}</td>
                            <td>{{ $person->phone_number }}</td>
                            <td>
                                <form action="{{ route('persons.destroy', $person->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <a href="{{ route('persons.show', $person->id) }}" class="btn btn-warning btn-sm"><i class="bi bi-eye"></i> Show</a>
                                    <a href="{{ route('persons.edit', $person->id) }}" class="btn btn-primary btn-sm"><i class="bi bi-pencil-square"></i> Edit</a>   
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Do you want to delete this person?');"><i class="bi bi-trash"></i> Delete</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                            <td colspan="6">
                                <span class="text-danger">
                                    <strong>No person found!</strong>
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