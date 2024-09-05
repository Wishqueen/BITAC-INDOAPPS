@extends('layouts.main')

@section('konten')

<div class="container-xxl py-5">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <img src="{{ asset('assets/img/' . $instructor->image) }}" alt="{{ $instructor->name }}" class="img-fluid">
            </div>
            <div class="col-md-6">
                <h1>{{ $instructor->name }}</h1>
                <p><strong>Skills:</strong> {{ $instructor->skills }}</p>
                <p>{{ $instructor->description }}</p>
            </div>
        </div>
    </div>
</div>

@endsection
