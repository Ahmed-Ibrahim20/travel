@extends('layouts.app')

@section('content')


<div class="py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="container-fluid">
                <!-- Header with Gradient -->
                <div class="bg-gradient-warning text-dark p-4 rounded-top">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h3 class="mb-0 fw-bold">
                                <i class="fas fa-edit me-2"></i> Edit Rate Plan
                            </h3>
                            <p class="mb-0 opacity-75">Update pricing plan details</p>
                        </div>
                        <div>
                            <a href="{{ route('rateplans.show', $rateplan->id) }}" class="btn btn-outline-dark me-2">
                                <i class="fas fa-eye me-2"></i> View
                            </a>
                            <a href="{{ route('rateplans.index') }}" class="btn btn-dark">
                                <i class="fas fa-arrow-left me-2"></i> Back to List
                            </a>
                        </div>
                    </div>
                </div>

                <div class="p-4">
                    @if ($errors->any())
                    <div class="alert alert-danger border-0 shadow-sm rounded-3 mb-4">
                        <div class="d-flex align-items-center mb-2">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <strong>Please fix the following errors:</strong>
                        </div>
                        <ul class="mb-0 ps-3">
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <form action="{{ route('rateplans.update', $rateplan->id) }}" method="post" class="needs-validation">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <!-- Left Column -->
                            <div class="col-md-6">
                                <!-- Tour Selection -->
                                <div class="card border-0 shadow-sm mb-4">
                                    <div class="card-header bg-primary text-white">
                                        <h6 class="mb-0"><i class="fas fa-map-marked-alt me-2"></i> Tour Selection</h6>
                                    </div>
                                    <div class="card-body">
                                        <select class="form-select form-select-lg @error('tour_id') is-invalid @enderror"
                                            id="tour_id" name="tour_id" required>
                                            <option value="">Choose a Tour</option>
                                            @foreach($tours as $tour)
                                            <option value="{{ $tour->id }}"
                                                {{ old('tour_id', $rateplan->tour_id) == $tour->id ? 'selected' : '' }}>
                                                {{ $tour->title['en'] ?? $tour->title['de'] ?? 'N/A' }}
                                                <small>({{ $tour->destination->name['en'] ?? 'N/A' }})</small>
                                            </option>
                                            @endforeach
                                        </select>
                                        @error('tour_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Room & Date Information -->
                                <div class="card border-0 shadow-sm mb-4">
                                    <div class="card-header bg-info text-white">
                                        <h6 class="mb-0"><i class="fas fa-bed me-2"></i> Room & Date Details</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-12 mb-3">
                                                <label for="room_type" class="form-label fw-semibold">Room Type</label>
                                                <select class="form-select @error('room_type') is-invalid @enderror"
                                                    id="room_type" name="room_type">
                                                    <option value="">Select Room Type</option>
                                                    <option value="Single" {{ old('room_type', $rateplan->room_type) == 'Single' ? 'selected' : '' }}>Single</option>
                                                    <option value="Double" {{ old('room_type', $rateplan->room_type) == 'Double' ? 'selected' : '' }}>Double</option>
                                                    <option value="Triple" {{ old('room_type', $rateplan->room_type) == 'Triple' ? 'selected' : '' }}>Triple</option>
                                                </select>
                                                @error('room_type')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="start_date" class="form-label fw-semibold">Start Date *</label>
                                                <input type="date" class="form-control @error('start_date') is-invalid @enderror"
                                                    id="start_date" name="start_date" value="{{ old('start_date', $rateplan->start_date ? $rateplan->start_date->format('Y-m-d') : '') }}" required>
                                                @error('start_date')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="end_date" class="form-label fw-semibold">End Date *</label>
                                                <input type="date" class="form-control @error('end_date') is-invalid @enderror"
                                                    id="end_date" name="end_date" value="{{ old('end_date', $rateplan->end_date ? $rateplan->end_date->format('Y-m-d') : '') }}" required>
                                                @error('end_date')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Board & Transportation -->
                                <div class="card border-0 shadow-sm mb-4">
                                    <div class="card-header bg-warning text-dark">
                                        <h6 class="mb-0"><i class="fas fa-utensils me-2"></i> Board & Transport</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-12 mb-3">
                                                <label for="board_type" class="form-label fw-semibold">Board Type</label>
                                                <select class="form-select @error('board_type') is-invalid @enderror"
                                                    id="board_type" name="board_type">
                                                    <option value="">Select Board Type</option>
                                                    <option value="All Inclusive" {{ old('board_type', $rateplan->board_type) == 'All Inclusive' ? 'selected' : '' }}>All Inclusive</option>
                                                    <option value="Half Board" {{ old('board_type', $rateplan->board_type) == 'Half Board' ? 'selected' : '' }}>Half Board</option>
                                                    <option value="Full Board" {{ old('board_type', $rateplan->board_type) == 'Full Board' ? 'selected' : '' }}>Full Board</option>
                                                    <option value="Bed & Breakfast" {{ old('board_type', $rateplan->board_type) == 'Bed & Breakfast' ? 'selected' : '' }}>Bed & Breakfast</option>
                                                </select>
                                                @error('board_type')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-12 mb-3">
                                                <label for="transportation" class="form-label fw-semibold">Transportation</label>
                                                <select class="form-select @error('transportation') is-invalid @enderror"
                                                    id="transportation" name="transportation">
                                                    <option value="">Select Transportation</option>
                                                    <option value="No transfers" {{ old('transportation', $rateplan->transportation) == 'No transfers' ? 'selected' : '' }}>No transfers</option>
                                                    <option value="Bus" {{ old('transportation', $rateplan->transportation) == 'Bus' ? 'selected' : '' }}>Bus</option>
                                                    <option value="Private car" {{ old('transportation', $rateplan->transportation) == 'Private car' ? 'selected' : '' }}>Private car</option>
                                                </select>
                                                @error('transportation')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Pricing Information -->
                                <div class="card border-0 shadow-sm mb-4">
                                    <div class="card-header bg-success text-white">
                                        <h6 class="mb-0"><i class="fas fa-dollar-sign me-2"></i> Pricing Details</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-8 mb-3">
                                                <label for="price" class="form-label fw-semibold">Price *</label>
                                                <div class="input-group input-group-lg">
                                                    <span class="input-group-text bg-light">
                                                        <i class="fas fa-money-bill-wave"></i>
                                                    </span>
                                                    <input type="number" step="0.01" min="0"
                                                        class="form-control @error('price') is-invalid @enderror"
                                                        id="price" name="price" placeholder="0.00"
                                                        value="{{ old('price', $rateplan->price) }}" required>
                                                    @error('price')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label for="currency" class="form-label fw-semibold">Currency *</label>
                                                <select class="form-select form-select-lg @error('currency') is-invalid @enderror"
                                                    id="currency" name="currency" required>
                                                    <option value="">Select</option>
                                                    <option value="USD" {{ old('currency', $rateplan->currency) == 'USD' ? 'selected' : '' }}>USD ($)</option>
                                                    <option value="EUR" {{ old('currency', $rateplan->currency) == 'EUR' ? 'selected' : '' }}>EUR (€)</option>
                                                    <option value="EGP" {{ old('currency', $rateplan->currency) == 'EGP' ? 'selected' : '' }}>EGP (ج.م)</option>
                                                    <option value="GBP" {{ old('currency', $rateplan->currency) == 'GBP' ? 'selected' : '' }}>GBP (£)</option>
                                                </select>
                                                @error('currency')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Right Column -->
                            <div class="col-md-6">
                                <!-- Rate Plan Names -->
                                <div class="card border-0 shadow-sm mb-4">
                                    <div class="card-header bg-info text-white">
                                        <h6 class="mb-0"><i class="fas fa-language me-2"></i> Plan Names</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label for="name_en" class="form-label fw-semibold">
                                                <img src="https://flagcdn.com/16x12/us.png" alt="EN" class="me-2"> English *
                                            </label>
                                            <input type="text" class="form-control form-control-lg @error('name.en') is-invalid @enderror"
                                                id="name_en" name="name[en]" placeholder="Enter plan name in English"
                                                value="{{ old('name.en', $rateplan->name['en'] ?? '') }}" required>
                                            @error('name.en')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="name_de" class="form-label fw-semibold">
                                                <img src="https://flagcdn.com/16x12/de.png" alt="DE" class="me-2"> German
                                            </label>
                                            <input type="text" class="form-control form-control-lg @error('name.de') is-invalid @enderror"
                                                id="name_de" name="name[de]" placeholder="Geben Sie den Plan auf Deutsch ein"
                                                value="{{ old('name.de', $rateplan->name['de'] ?? '') }}">
                                            @error('name.de')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-0">
                                            <label for="name_fr" class="form-label fw-semibold">
                                                <img src="https://flagcdn.com/16x12/fr.png" alt="FR" class="me-2"> French
                                            </label>
                                            <input type="text" class="form-control form-control-lg @error('name.fr') is-invalid @enderror"
                                                id="name_fr" name="name[fr]" placeholder="Entrez le nom du plan en français"
                                                value="{{ old('name.fr', $rateplan->name['fr'] ?? '') }}">
                                            @error('name.fr')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Plan Details Section -->
                        <div class="card border-0 shadow-sm mb-4">
                            <div class="card-header bg-warning text-dark">
                                <h6 class="mb-0"><i class="fas fa-list-alt me-2"></i> Plan Details</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label for="details_en" class="form-label fw-semibold">
                                            <img src="https://flagcdn.com/16x12/us.png" alt="EN" class="me-2"> Details (English)
                                        </label>
                                        <textarea class="form-control @error('details.en') is-invalid @enderror"
                                            id="details_en" name="details[en]" rows="4"
                                            placeholder="Enter plan details in English">{{ old('details.en', $rateplan->details['en'] ?? '') }}</textarea>
                                        @error('details.en')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label for="details_de" class="form-label fw-semibold">
                                            <img src="https://flagcdn.com/16x12/de.png" alt="DE" class="me-2"> Details (German)
                                        </label>
                                        <textarea class="form-control @error('details.de') is-invalid @enderror"
                                            id="details_de" name="details[de]" rows="4"
                                            placeholder="Geben Sie die Details des Plans auf Deutsch ein">{{ old('details.de', $rateplan->details['de'] ?? '') }}</textarea>
                                        @error('details.de')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label for="details_fr" class="form-label fw-semibold">
                                            <img src="https://flagcdn.com/16x12/fr.png" alt="FR" class="me-2"> Details (French)
                                        </label>
                                        <textarea class="form-control @error('details.fr') is-invalid @enderror"
                                            id="details_fr" name="details[fr]" rows="4"
                                            placeholder="Entrez les détails du plan en français">{{ old('details.fr', $rateplan->details['fr'] ?? '') }}</textarea>
                                        @error('details.fr')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="text-center">
                            <button type="submit" class="btn btn-warning btn-lg px-5 py-3 shadow text-dark fw-bold">
                                <i class="fas fa-save me-2"></i> Update Rate Plan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-gradient-warning {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #ffc107;
        box-shadow: 0 0 0 0.2rem rgba(255, 193, 7, 0.25);
    }

    .card {
        transition: all 0.3s ease;
    }

    .card:hover {
        transform: translateY(-2px);
    }
</style>
@endsection