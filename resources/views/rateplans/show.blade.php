@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow-xl rounded-3 overflow-hidden">

            <!-- Hero Section -->
            <div class="bg-hero text-white p-5 position-relative overflow-hidden">
                <div class="position-absolute top-0 end-0 opacity-10" style="font-size: 8rem;">
                    <i class="fas fa-gift"></i>
                </div>
                <div class="row align-items-center position-relative">
                    <div class="col-md-8">
                        <h1 class="display-6 fw-bold mb-2">
                            {{ $rateplan->name['en'] ?? $rateplan->name['de'] ?? $rateplan->name['fr'] ?? 'N/A' }}
                        </h1>
                        <p class="lead mb-0 opacity-75">
                            For Tour: <span class="fw-semibold">{{ $rateplan->tour->title['en'] ?? 'N/A' }}</span>
                        </p>
                    </div>
                    <div class="col-md-4 text-end">
                        <div class="bg-white bg-opacity-25 rounded-4 p-4 backdrop-blur-sm">
                            <div class="display-5 fw-bold text-white">
                                {{ $rateplan->formatted_price }}
                            </div>
                            <small class="text-white-50">{{ $rateplan->currency }}</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="p-4 border-bottom bg-light">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="btn-group shadow-sm">
                        <a href="{{ route('rateplans.edit', $rateplan->id) }}" class="btn btn-outline-warning">
                            <i class="fas fa-edit me-2"></i> Edit
                        </a>
                        <a href="{{ route('tours.show', $rateplan->tour_id) }}" class="btn btn-outline-info">
                            <i class="fas fa-map-marked-alt me-2"></i> View Tour
                        </a>
                    </div>
                    <a href="{{ route('rateplans.index') }}" class="btn btn-outline-primary">
                        <i class="fas fa-arrow-left me-2"></i> Back
                    </a>
                </div>
            </div>

            <!-- Content -->
            <div class="p-4">
                <div class="row g-4">
                    <!-- Plan Names -->
                    <div class="col-md-6">
                        <div class="card shadow-sm border-0 h-100">
                            <div class="card-header bg-gradient-primary text-white">
                                <h5 class="mb-0"><i class="fas fa-language me-2"></i> Plan Names</h5>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <div class="d-flex align-items-center mb-2">
                                        <img src="https://flagcdn.com/16x12/us.png" class="me-2"> 
                                        <strong class="text-primary">English</strong>
                                    </div>
                                    <p class="ps-4 mb-0">{{ $rateplan->name['en'] ?? 'Not available' }}</p>
                                </div>
                                <div class="mb-3">
                                    <div class="d-flex align-items-center mb-2">
                                        <img src="https://flagcdn.com/16x12/de.png" class="me-2"> 
                                        <strong class="text-primary">Deutsch</strong>
                                    </div>
                                    <p class="ps-4 mb-0">{{ $rateplan->name['de'] ?? 'Nicht verfügbar' }}</p>
                                </div>
                                <div>
                                    <div class="d-flex align-items-center mb-2">
                                        <img src="https://flagcdn.com/16x12/fr.png" class="me-2"> 
                                        <strong class="text-primary">French</strong>
                                    </div>
                                    <p class="ps-4 mb-0">{{ $rateplan->name['fr'] ?? 'Non disponible' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tour Info -->
                    <div class="col-md-6">
                        <div class="card shadow-sm border-0 h-100">
                            <div class="card-header bg-gradient-success text-white">
                                <h5 class="mb-0"><i class="fas fa-map-marked-alt me-2"></i> Tour Information</h5>
                            </div>
                            <div class="card-body">
                                <p><strong class="text-success">Tour Title:</strong><br>{{ $rateplan->tour->title['en'] ?? 'N/A' }}</p>
                                <p><strong class="text-success">Destination:</strong><br>{{ $rateplan->tour->destination->name['en'] ?? 'N/A' }}</p>
                                <p><strong class="text-success">Duration:</strong><br><span class="badge bg-info">{{ $rateplan->tour->duration_days }} days</span></p>
                                <p class="mb-0"><strong class="text-success">Capacity:</strong><br><span class="badge bg-secondary">{{ $rateplan->tour->capacity }} people</span></p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Plan Details -->
                <div class="card shadow-sm border-0 mt-4">
                    <div class="card-header bg-gradient-warning text-dark">
                        <h5 class="mb-0"><i class="fas fa-list-alt me-2"></i> Plan Details</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-4">
                            <div class="col-md-4">
                                <div class="details-box">
                                    <div class="d-flex align-items-center mb-2">
                                        <img src="https://flagcdn.com/16x12/us.png" class="me-2">
                                        <strong class="text-warning">English</strong>
                                    </div>
                                    <p class="mb-0">{{ $rateplan->details['en'] ?? 'No details available' }}</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="details-box">
                                    <div class="d-flex align-items-center mb-2">
                                        <img src="https://flagcdn.com/16x12/de.png" class="me-2">
                                        <strong class="text-warning">Deutsch</strong>
                                    </div>
                                    <p class="mb-0">{{ $rateplan->details['de'] ?? 'Keine Details verfügbar' }}</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="details-box">
                                    <div class="d-flex align-items-center mb-2">
                                        <img src="https://flagcdn.com/16x12/fr.png" class="me-2">
                                        <strong class="text-warning">French</strong>
                                    </div>
                                    <p class="mb-0">{{ $rateplan->details['fr'] ?? 'Aucun détail disponible' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Meta Info -->
                <div class="card shadow-sm border-0 mt-4">
                    <div class="card-header bg-gradient-dark text-white">
                        <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i> Meta Information</h5>
                    </div>
                    <div class="card-body row g-4">
                        <div class="col-md-3">
                            <strong>Created By:</strong><br>
                            <span class="text-success">{{ $rateplan->tour->addedByUser->name ?? 'N/A' }}</span>
                        </div>
                        <div class="col-md-3">
                            <strong>Created Date:</strong><br>
                            <span class="text-muted">{{ $rateplan->created_at->format('M d, Y H:i') }}</span>
                        </div>
                        <div class="col-md-3">
                            <strong>Last Updated:</strong><br>
                            <span class="text-muted">{{ $rateplan->updated_at->format('M d, Y H:i') }}</span>
                        </div>
                        <div class="col-md-3">
                            <strong>Rate Plan ID:</strong><br>
                            <span class="badge bg-light text-dark">#{{ $rateplan->id }}</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<style>
    .bg-hero {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
    }
    .bg-gradient-primary {
        background: linear-gradient(135deg, #667eea, #764ba2);
    }
    .bg-gradient-success {
        background: linear-gradient(135deg, #11998e, #38ef7d);
    }
    .bg-gradient-warning {
        background: linear-gradient(135deg, #f7971e, #ffd200);
    }
    .bg-gradient-dark {
        background: linear-gradient(135deg, #232526, #414345);
    }
    .backdrop-blur-sm {
        backdrop-filter: blur(10px);
    }
    .details-box {
        background: #f8f9fa;
        border-radius: 0.75rem;
        padding: 1rem;
        min-height: 120px;
        transition: all 0.3s ease;
    }
    .details-box:hover {
        background: #eef2f7;
        transform: translateY(-3px);
    }
    .card {
        border-radius: 1rem;
        transition: all 0.3s ease;
    }
    .card:hover {
        transform: translateY(-4px);
    }
</style>
@endsection
