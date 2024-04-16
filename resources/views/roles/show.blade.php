@extends('layout')

@section('content')

<div class="row justify-content-center mt-3">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <div class="float-start">
                    Role detail
                </div>
                <div class="float-end">
                    <a href="{{ route('roles.index') }}" class="btn btn-primary btn-sm">&larr; Back</a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <label for="full_name" class="col-md-4 col-form-label text-md-end text-start"><strong>Role:</strong></label>
                    <div class="col-md-6" style="line-height: 35px;">
                        {{ $item->role }}
                    </div>
                </div>
                <div class="row">
                    <label for="description" class="col-md-4 col-form-label text-md-end text-start"><strong>Description:</strong></label>
                    <div class="col-md-6" style="line-height: 35px;">
                        {{ $item->description }}
                    </div>
                </div>
            </div>
        </div>
    </div>    
</div>
    
@endsection
