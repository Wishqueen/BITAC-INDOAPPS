@extends('layouts.main')

@section('konten')
<div class="container mt-5">
    <!-- Certificate Background -->
    <div class="p-5" style="background: url('{{ asset('assets/img/SERTIF.png') }}') no-repeat center; background-size: cover; border-radius: 10px; padding: 50px;">
        
        <!-- Certificate Header -->
        <h2 class="text-uppercase fw-bold text-center mb-0" style="font-size: 2.5rem; color: #2c3e50;">Certificate of Completion</h2>
        <p class="text-muted fst-italic text-center mb-3" style="font-size: 1.2rem;">Presented to</p>

        <!-- Recipient Name -->
        <h1 class="display-4 fw-bold text-center text-primary">
            <span style="border-bottom: 2px solid #2c3e50; padding-bottom: 5px; display: inline-block; width: 60%;">
                {{ $certification->user->name ?? 'Unknown Recipient' }}
            </span>
        </h1>

        <!-- Achievement Section -->
        <p class="mt-4 text-muted text-center" style="font-size: 1.1rem;">
            In recognition of successfully completing the course:
        </p>
        <h3 class="fw-bold mb-3 text-center text-secondary">{{ $certification->course->title ?? 'No Course' }}</h3>

        <!-- Description -->
        <p class="text-muted mb-4 text-center" style="font-size: 1rem;">
            {{ $certification->description }}
        </p>
        
        <!-- Certificate Number -->
        <p class="text-muted text-center" style="font-size: 1rem;">
            <strong>Certificate Number:</strong> {{ $certification->certificate_number ?? 'Not Available' }}
        </p>

        <!-- Date and Signature -->
        <div class="row mt-5 justify-content-center">
            <div class="col-md-4 text-center">
                <p class="text-muted" style="font-size: 1rem;">Awarded on</p>
                <p class="fw-bold" style="font-size: 1.2rem;">
                    {{ \Carbon\Carbon::parse($certification->date)->format('F j, Y') ?? 'No Date' }}
                </p>
            </div>
            <div class="col-md-4 text-center">
                <p class="text-muted" style="font-size: 1rem;">Signature</p>
                <img src="{{ asset('assets/img/TTD.png') }}" alt="Signature" style="width: 150px; height: auto;">
                <p class="mt-2 text-muted" style="font-size: 1rem;">[I Nengah Laba]</p>
            </div>
        </div>

        <!-- Download Button -->
        <div class="mt-5 text-center">
            <a href="{{ route('certificate.download', $certification->id) }}" class="btn btn-outline-primary btn-lg">
                <i class="fas fa-download"></i> Download Certificate
            </a>
        </div>
    </div>
</div>
@endsection
