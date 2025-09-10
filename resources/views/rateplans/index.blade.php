@extends('layouts.app')

@section('content')

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg">
            <div class="container-fluid">

                <!-- Header Section with Modern Gradient -->
                <div class="bg-gradient-modern text-white p-4 rounded-top shadow-sm">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h2 class="mb-1 fw-bold d-flex align-items-center">
                                <i class="fas fa-tags me-2"></i> Rate Plans
                            </h2>
                            <p class="mb-0 opacity-75">Easily manage and customize your pricing plans</p>
                        </div>
                        <div class="col-md-6 text-end">
                            <a href="{{ route('rateplans.create') }}" class="btn btn-light btn-lg shadow-sm rounded-pill">
                                <i class="fas fa-plus-circle me-2"></i> Add New Plan
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Filters and Search -->
                <div class="p-4 border-bottom bg-light">
                    <form method="GET" action="{{ route('rateplans.index') }}" class="row g-3">
                        <div class="col-md-4">
                            <div class="input-group shadow-sm rounded-pill overflow-hidden">
                                <span class="input-group-text bg-white border-end-0">
                                    <i class="fas fa-search text-muted"></i>
                                </span>
                                <input type="text" name="search" class="form-control border-start-0 ps-0"
                                    placeholder="Search rate plans..." value="{{ request('search') }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <select name="tour_id" class="form-select shadow-sm rounded-pill">
                                <option value="">All Tours</option>
                                @foreach($tours as $tour)
                                <option value="{{ $tour->id }}" {{ request('tour_id') == $tour->id ? 'selected' : '' }}>
                                    {{ $tour->title['en'] ?? $tour->title['de'] ?? 'N/A' }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select name="perPage" class="form-select shadow-sm rounded-pill">
                                <option value="10" {{ request('perPage') == '10' ? 'selected' : '' }}>10 / page</option>
                                <option value="25" {{ request('perPage') == '25' ? 'selected' : '' }}>25 / page</option>
                                <option value="50" {{ request('perPage') == '50' ? 'selected' : '' }}>50 / page</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-modern w-100 shadow-sm rounded-pill">
                                <i class="fas fa-filter me-1"></i> Filter
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Rate Plans Grid -->
                <div class="p-4">
                    @if($rateplans->count() > 0)
                    <div class="row">
                        @foreach($rateplans as $rateplan)
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="card-modern h-100 shadow-sm border-0 position-relative">
                                <!-- Price Badge -->
                                <div class="position-absolute top-0 end-0 m-3">
                                    <span class="badge bg-modern fs-6 px-3 py-2 rounded-pill shadow-sm">
                                        {{ $rateplan->formatted_price }}
                                    </span>
                                </div>

                                <div class="card-body p-4">
                                    <!-- Rate Plan Names -->
                                    <h5 class="card-title text-modern fw-bold mb-3">
                                        {{ $rateplan->name['en'] ?? $rateplan->name['ar'] ?? $rateplan->name['fr'] ?? 'N/A' }}
                                    </h5>

                                    <!-- Tour Info -->
                                    <div class="mb-3">
                                        <small class="text-muted d-block">Tour:</small>
                                        <span class="text-dark fw-semibold">
                                            {{ $rateplan->tour->title['en'] ?? 'N/A' }}
                                        </span>
                                    </div>

                                    <!-- Details -->
                                    <div class="mb-3">
                                        <small class="text-muted d-block">Details:</small>
                                        <p class="text-secondary small mb-0" style="height: 60px; overflow: hidden;">
                                            {{ Str::limit($rateplan->details['en'] ?? $rateplan->details['de'] ?? 'No details available', 100) }}
                                        </p>
                                    </div>

                                    <!-- Currency -->
                                    <div class="mb-3">
                                        <span class="badge bg-light text-dark border shadow-sm">
                                            <i class="fas fa-coins me-1"></i> {{ $rateplan->currency }}
                                        </span>
                                    </div>

                                    <!-- Meta Info -->
                                    <div class="text-muted small mb-3">
                                        <div class="d-flex justify-content-between">
                                            <span><i class="fas fa-user me-1"></i> {{ $rateplan->tour->addedByUser->name ?? 'N/A' }}</span>
                                            <span><i class="fas fa-calendar me-1"></i> {{ $rateplan->created_at->format('M d, Y') }}</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Action Buttons -->
                               <!-- Action Buttons -->
<div class="card-footer bg-transparent border-0 px-4 pb-3">
    <div class="d-flex justify-content-between gap-2">
        <!-- Show -->
        <a href="{{ route('rateplans.show', $rateplan->id) }}" 
           class="btn btn-sm btn-light shadow-sm d-flex align-items-center gap-1">
            <i class="fas fa-eye text-primary"></i>
            <span>View</span>
        </a>

        <!-- Edit -->
        <a href="{{ route('rateplans.edit', $rateplan->id) }}" 
           class="btn btn-sm btn-warning shadow-sm d-flex align-items-center gap-1 text-white">
            <i class="fas fa-edit"></i>
            <span>Edit</span>
        </a>

        <!-- Delete -->
        <form action="{{ route('rateplans.destroy', $rateplan->id) }}" 
              method="POST" 
              onsubmit="return confirm('Are you sure you want to delete this rate plan?')"
              class="m-0">
            @csrf
            @method('DELETE')
            <button type="submit" 
                    class="btn btn-sm btn-danger shadow-sm d-flex align-items-center gap-1">
                <i class="fas fa-trash"></i>
                <span>Delete</span>
            </button>
        </form>
    </div>
</div>

                            </div>
                        </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-center mt-4">
                        {{ $rateplans->appends(request()->query())->links() }}
                    </div>
                    @else
                    <div class="text-center py-5">
                        <div class="mb-4">
                            <i class="fas fa-tags fa-4x text-muted"></i>
                        </div>
                        <h4 class="text-muted">No Rate Plans Found</h4>
                        <p class="text-muted mb-4">Start by creating your first rate plan.</p>
                        <a href="{{ route('rateplans.create') }}" class="btn btn-modern btn-lg rounded-pill shadow-sm">
                            <i class="fas fa-plus-circle me-2"></i> Create Rate Plan
                        </a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Modern Gradient */
    .bg-gradient-modern {
        background: linear-gradient(135deg, #1e90ff 0%, #00c6ff 100%);
    }

    .btn-modern {
        background: linear-gradient(135deg, #1e90ff 0%, #00c6ff 100%);
        color: #fff;
        border: none;
        transition: all 0.3s ease-in-out;
    }

    .btn-modern:hover {
        background: linear-gradient(135deg, #00c6ff 0%, #1e90ff 100%);
        color: #fff;
        transform: translateY(-2px);
    }

    .text-modern {
        color: #1e90ff;
    }

    .bg-modern {
        background: linear-gradient(135deg, #00c6ff 0%, #1e90ff 100%);
        color: #fff;
    }

    .card-modern {
        border-radius: 16px;
        background: #fff;
        transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
    }

    .card-modern:hover {
        transform: translateY(-6px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.12) !important;
    }

    .btn-outline-modern {
        border: 1px solid #1e90ff;
        color: #1e90ff;
    }

    .btn-outline-modern:hover {
        background: #1e90ff;
        color: #fff;
    }

    @media print {
        .no-print {
            display: none !important;
        }

        .card {
            break-inside: avoid;
        }
    }
</style>
@endsection
