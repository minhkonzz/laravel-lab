@extends('layout')

@section('content')

<div class="row justify-content-center mt-3">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">Company List</div>
            <div class="card-body">
                <a href="{{ route('companies.create') }}" class="btn btn-success btn-sm my-2"><i class="bi bi-plus-circle"></i> Add new company</a>
                <table class="table table-striped table-bordered">
                    <thead>
                      <tr>
                        <th scope="col">S#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Code</th>
                        <th scope="col">Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                        @forelse ($items as $company)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $company->name }}</td>
                            <td>{{ $company->code }}</td>
                            <td>
                                <form action="{{ route('companies.destroy', $company->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <a href="{{ route('companies.show', $company->id) }}" class="btn btn-warning btn-sm"><i class="bi bi-eye"></i> Show</a>
                                    <a href="{{ route('companies.edit', $company->id) }}" class="btn btn-primary btn-sm"><i class="bi bi-pencil-square"></i> Edit</a>   
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Do you want to delete this company?');"><i class="bi bi-trash"></i> Delete</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                            <td colspan="6">
                                <span class="text-danger">
                                    <strong>No company found!</strong>
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
