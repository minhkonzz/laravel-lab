@extends('layout')

@section('content')

<div class="row justify-content-center mt-3">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <div class="float-start">
                    Company detail
                </div>
                <div class="float-end">
                    <a href="{{ route('companies.index') }}" class="btn btn-primary btn-sm">&larr; Back</a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <label for="name" class="col-md-4 col-form-label text-md-end text-start"><strong>Name:</strong></label>
                    <div class="col-md-6" style="line-height: 35px;">
                        {{ $item->name }}
                    </div>
                </div>
                <div class="row">
                    <label for="code" class="col-md-4 col-form-label text-md-end text-start"><strong>Code:</strong></label>
                    <div class="col-md-6" style="line-height: 35px;">
                        {{ $item->code }}
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

