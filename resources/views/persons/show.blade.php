@extends('layout')

@section('content')

<div class="row justify-content-center mt-3">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <div class="float-start">
                    Person Information
                </div>
                <div class="float-end">
                    <a href="{{ route('persons.index') }}" class="btn btn-primary btn-sm">&larr; Back</a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <label for="full_name" class="col-md-4 col-form-label text-md-end text-start"><strong>Full name:</strong></label>
                    <div class="col-md-6" style="line-height: 35px;">
                        {{ $item->full_name }}
                    </div>
                </div>
                <div class="row">
                    <label for="gender" class="col-md-4 col-form-label text-md-end text-start"><strong>Gender:</strong></label>
                    <div class="col-md-6" style="line-height: 35px;">
                        {{ $item->gender }}
                    </div>
                </div>
                <div class="row">
                    <label for="birthdate" class="col-md-4 col-form-label text-md-end text-start"><strong>Birthdate:</strong></label>
                    <div class="col-md-6" style="line-height: 35px;">
                        {{ $item->birthdate }}
                    </div>
                </div>
                <div class="row">
                    <label for="phone_number" class="col-md-4 col-form-label text-md-end text-start"><strong>Phone number:</strong></label>
                    <div class="col-md-6" style="line-height: 35px;">
                        {{ $item->phone_number }}
                    </div>
                </div>
                <div class="row">
                    <label for="address" class="col-md-4 col-form-label text-md-end text-start"><strong>Address:</strong></label>
                    <div class="col-md-6" style="line-height: 35px;">
                        {{ $item->address }}
                    </div>
                </div>
            </div>
        </div>
    </div>    
</div>
    
@endsection