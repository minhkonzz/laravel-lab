@extends('layout')

@section('content')

<div class="row justify-content-center mt-3">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <div class="float-start">
                    Update person
                </div>
                <div class="float-end">
                    <a href="{{ route('persons.index') }}" class="btn btn-primary btn-sm">&larr; Back</a>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('persons.update', $item->id) }}" method="POST">
                    @csrf
                    @method("PUT")
                    <div class="mb-3 row">
                        <label for="full_name" class="col-md-4 col-form-label text-md-end text-start">Full name</label>
                        <div class="col-md-6">
                          <input type="text" class="form-control @error('full_name') is-invalid @enderror" id="full_name" name="full_name" value="{{ $item->full_name }}">
                            @if ($errors->has('full_name'))
                                <span class="text-danger">{{ $errors->first('full_name') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="gender" class="col-md-4 col-form-label text-md-end text-start">Gender</label>
                        <div class="col-md-6">
                          <input type="text" class="form-control @error('gender') is-invalid @enderror" id="gender" name="gender" value="{{ $item->gender }}">
                            @if ($errors->has('gender'))
                                <span class="text-danger">{{ $errors->first('gender') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="birthdate" class="col-md-4 col-form-label text-md-end text-start">Birthdate</label>
                        <div class="col-md-6">
                          <input type="text" class="form-control @error('birthdate') is-invalid @enderror" id="birthdate" name="birthdate" value="{{ $item->birthdate }}">
                            @if ($errors->has('birthdate'))
                                <span class="text-danger">{{ $errors->first('birthdate') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="phone_number" class="col-md-4 col-form-label text-md-end text-start">Phone number</label>
                        <div class="col-md-6">
                          <input type="text" class="form-control @error('gender') is-invalid @enderror" id="phone_number" name="phone_number" value="{{ $item->phone_number }}">
                            @if ($errors->has('phone_number'))
                                <span class="text-danger">{{ $errors->first('phone_number') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="address" class="col-md-4 col-form-label text-md-end text-start">Address</label>
                        <div class="col-md-6">
                          <input type="text" class="form-control @error('gender') is-invalid @enderror" id="address" name="address" value="{{ $item->address }}">
                            @if ($errors->has('address'))
                                <span class="text-danger">{{ $errors->first('address') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <input type="submit" class="col-md-3 offset-md-5 btn btn-primary" value="Update">
                    </div>
                </form>
            </div>
        </div>
    </div>    
</div>
    
@endsection