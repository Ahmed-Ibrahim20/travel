@extends('layouts.app')

@section('content')


<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-md-10">
                        <div class="card border-0 shadow-lg">
                            <div class="card-header bg-white py-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h3 class="mb-0 text-primary fw-bold">
                                        Destination Details
                                    </h3>
                                    <div>
                                        <a href="{{ route('destinations.edit', $destination->id) }}" class="btn btn-warning btn-lg rounded-pill me-2">
                                            <i class="fas fa-edit me-2"></i> Edit
                                        </a>
                                        <a href="{{ route('destinations.index') }}" class="btn btn-outline-primary btn-lg rounded-pill">
                                            <i class="fas fa-list me-2"></i> Back to List
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body p-4">
                                <div class="row">
                                    <!-- Destination Image -->
                                    <div class="col-md-4 text-center">
                                        @if($destination->image)
                                        <img src="{{ $destination->image_url }}" alt="Destination Image" class="img-fluid rounded shadow-lg mb-3" style="max-height: 300px;">
                                        @else
                                        <div class="bg-light rounded p-5 text-muted">
                                            <i class="fas fa-image fa-3x mb-3"></i>
                                            <p>No Image Available</p>
                                        </div>
                                        @endif
                                    </div>

                                    <!-- Destination Details -->
                                    <div class="col-md-8">
                                        <div class="row">
                                            <!-- Names -->
                                            <div class="col-12 mb-3">
                                                <h5 class="text-secondary mb-2">Names</h5>
                                                <div class="card bg-light">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <strong>English:</strong><br>
                                                                <span class="text-primary">{{ $destination->name['en'] ?? 'N/A' }}</span>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <strong>Deutsch:</strong><br>
                                                                <span class="text-primary">{{ $destination->name['de'] ?? 'N/A' }}</span>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <strong>French:</strong><br>
                                                                <span class="text-primary">{{ $destination->name['fr'] ?? 'N/A' }}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Descriptions -->
                                            <div class="col-12 mb-3">
                                                <h5 class="text-secondary mb-2">Descriptions</h5>
                                                <div class="card bg-light">
                                                    <div class="card-body">
                                                        <div class="mb-3">
                                                            <strong>English:</strong><br>
                                                            <p class="text-muted">{{ $destination->description['en'] ?? 'No description available' }}</p>
                                                        </div>
                                                        <div class="mb-3">
                                                            <strong>Deutsch:</strong><br>
                                                            <p class="text-muted">{{ $destination->description['de'] ?? 'لا يوجد وصف متاح' }}</p>
                                                        </div>
                                                        <div class="mb-0">
                                                            <strong>French:</strong><br>
                                                            <p class="text-muted">{{ $destination->description['fr'] ?? 'Aucune description disponible' }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Additional Info -->
                                            <div class="col-md-6 mb-3">
                                                <h5 class="text-secondary mb-2">Additional Information</h5>
                                                <div class="card bg-light">
                                                    <div class="card-body">
                                                        <p><strong>Slug:</strong> <span class="text-info">{{ $destination->slug ?? 'N/A' }}</span></p>
                                                        <p><strong>Added By:</strong> <span class="text-success">{{ $destination->addedByUser->name ?? 'N/A' }}</span></p>
                                                        <p><strong>Created:</strong> <span class="text-muted">{{ $destination->created_at->format('Y-m-d H:i') }}</span></p>
                                                        <p class="mb-0"><strong>Updated:</strong> <span class="text-muted">{{ $destination->updated_at->format('Y-m-d H:i') }}</span></p>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Tours Count -->
                                            <div class="col-md-6 mb-3">
                                                <h5 class="text-secondary mb-2">Related Tours</h5>
                                                <div class="card bg-light">
                                                    <div class="card-body text-center">
                                                        <h2 class="text-primary mb-2">{{ $destination->tours->count() }}</h2>
                                                        <p class="text-muted mb-0">Tours Available</p>
                                                        @if($destination->tours->count() > 0)
                                                        <a href="{{ route('tours.index', ['destination_id' => $destination->id]) }}" class="btn btn-sm btn-outline-primary mt-2">
                                                            View Tours
                                                        </a>
                                                        @endif
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
</div>
@endsection