@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-md-12">
                        <div class="card border-0 shadow-lg">
                            <div class="card-header bg-white py-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h3 class="mb-0 text-primary fw-bold">
                                        Tour Details
                                    </h3>
                                    <div>
                                        <a href="{{ route('tours.edit', $tour->id) }}" class="btn btn-warning btn-lg rounded-pill me-2">
                                            <i class="fas fa-edit me-2"></i> Edit
                                        </a>
                                        <a href="{{ route('tours.index') }}" class="btn btn-outline-primary btn-lg rounded-pill">
                                            <i class="fas fa-list me-2"></i> Back to List
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body p-4">
                                <div class="row">
                                    <!-- Tour Images -->
                                    <div class="col-md-5">
                                        @if($tour->image && is_array($tour->image) && count($tour->image) > 0)
                                        <div id="tourCarousel" class="carousel slide" data-bs-ride="carousel">
                                            <div class="carousel-inner rounded shadow-lg">
                                                @foreach($tour->image_urls as $index => $imageUrl)
                                                <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                                    <img src="{{ $imageUrl }}" class="d-block w-100" alt="Tour Image {{ $index + 1 }}" style="height: 300px; object-fit: cover;">
                                                </div>
                                                @endforeach
                                            </div>
                                            @if(count($tour->image_urls) > 1)
                                            <button class="carousel-control-prev" type="button" data-bs-target="#tourCarousel" data-bs-slide="prev">
                                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                            </button>
                                            <button class="carousel-control-next" type="button" data-bs-target="#tourCarousel" data-bs-slide="next">
                                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                            </button>
                                            @endif
                                        </div>
                                        @else
                                        <div class="bg-light rounded p-5 text-center text-muted">
                                            <i class="fas fa-image fa-3x mb-3"></i>
                                            <p>No Images Available</p>
                                        </div>
                                        @endif
                                    </div>

                                    <!-- Tour Details -->
                                    <div class="col-md-7">
                                        <div class="row">
                                            <!-- Titles -->
                                            <div class="col-12 mb-3">
                                                <h5 class="text-secondary mb-2">Tour Titles</h5>
                                                <div class="card bg-light">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <strong>English:</strong><br>
                                                                <span class="text-primary">{{ $tour->title['en'] ?? 'N/A' }}</span>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <strong>Deutsch:</strong><br>
                                                                <span class="text-primary">{{ $tour->title['de'] ?? 'N/A' }}</span>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <strong>French:</strong><br>
                                                                <span class="text-primary">{{ $tour->title['fr'] ?? 'N/A' }}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Tour Info -->
                                            <div class="col-md-6 mb-3">
                                                <h5 class="text-secondary mb-2">Tour Information</h5>
                                                <div class="card bg-light">
                                                    <div class="card-body">
                                                        <p><strong>Destination:</strong> <span class="text-info">{{ $tour->destination->name['en'] ?? 'N/A' }}</span></p>
                                                        <p><strong>Duration:</strong> <span class="badge bg-info">{{ $tour->duration_days }} days</span></p>
                                                        <p><strong>Capacity:</strong> <span class="badge bg-secondary">{{ $tour->capacity }} people</span></p>
                                                        <!-- Tour Type -->
                                                        <p>
                                                            <strong>Tour Type:</strong>
                                                            @if($tour->tour_type === 'hotel')
                                                            <span class="badge bg-primary rounded-pill px-3 py-2">
                                                                <i class="fas fa-hotel me-1"></i> Hotel
                                                            </span>
                                                            @elseif($tour->tour_type === 'honeymoon')
                                                            <span class="badge bg-pink text-white rounded-pill px-3 py-2" style="background: linear-gradient(45deg,#ff758c,#ff7eb3);">
                                                                <i class="fas fa-heart me-1"></i> Honeymoon
                                                            </span>
                                                            @elseif($tour->tour_type === 'trip')
                                                            <span class="badge bg-success rounded-pill px-3 py-2">
                                                                <i class="fas fa-plane-departure me-1"></i> Trip
                                                            </span>
                                                            @else
                                                            <span class="badge bg-secondary rounded-pill px-3 py-2">N/A</span>
                                                            @endif
                                                        </p>
                                                        <p><strong>Added By:</strong> <span class="text-success">{{ $tour->addedByUser->name ?? 'N/A' }}</span></p>
                                                        <p><strong>Created:</strong> <span class="text-muted">{{ $tour->created_at->format('Y-m-d H:i') }}</span></p>
                                                        <p class="mb-0"><strong>Updated:</strong> <span class="text-muted">{{ $tour->updated_at->format('Y-m-d H:i') }}</span></p>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Rate Plans Count -->
                                            <div class="col-md-6 mb-3">
                                                <h5 class="text-secondary mb-2">Rate Plans</h5>
                                                <div class="card bg-light">
                                                    <div class="card-body text-center">
                                                        <h2 class="text-primary mb-2">{{ $tour->ratePlans->count() }}</h2>
                                                        <p class="text-muted mb-0">Rate Plans Available</p>
                                                        @if($tour->ratePlans->count() > 0)
                                                        <a href="{{ route('rateplans.index', ['tour_id' => $tour->id]) }}" class="btn btn-sm btn-outline-primary mt-2">
                                                            View Rate Plans
                                                        </a>
                                                        @else
                                                        <a href="{{ route('rateplans.create', ['tour_id' => $tour->id]) }}" class="btn btn-sm btn-primary mt-2">
                                                            Add Rate Plan
                                                        </a>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Descriptions -->
                                <div class="row mt-4">
                                    <div class="col-12">
                                        <h5 class="text-secondary mb-2">Tour Descriptions</h5>
                                        <div class="card bg-light">
                                            <div class="card-body">
                                                <div class="mb-3">
                                                    <strong>English:</strong><br>
                                                    <p class="text-muted">{{ $tour->description['en'] ?? 'No description available' }}</p>
                                                </div>
                                                <div class="mb-3">
                                                    <strong>Deutsch:</strong><br>
                                                    <p class="text-muted">{{ $tour->description['de'] ?? 'لا يوجد وصف متاح' }}</p>
                                                </div>
                                                <div class="mb-0">
                                                    <strong>French:</strong><br>
                                                    <p class="text-muted">{{ $tour->description['fr'] ?? 'Aucune description disponible' }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection