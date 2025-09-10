@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
        <div class="card border-0 shadow-lg rounded-4 overflow-hidden">

            <!-- Header -->
            <div class="card-header bg-gradient-primary text-white py-4">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="mb-0 fw-bold">
                        <i class="fas fa-map-marked-alt me-2"></i> Add New Tour
                    </h3>
                    <a href="{{ route('tours.index') }}" class="btn btn-warning btn-lg rounded-pill shadow-sm text-dark">
                        <i class="fas fa-list me-2"></i> View Tours
                    </a>
                </div>
            </div>

            <!-- Body -->
            <div class="card-body bg-light p-5">
                @if ($errors->any())
                <div class="alert alert-danger rounded-3 shadow-sm">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <form id="tourForm" action="{{ route('tours.store') }}" method="post" enctype="multipart/form-data" novalidate>
                    @csrf

                    <div class="row mb-4">
                        <!-- Destination -->
                        <div class="col-md-6">
                            <label for="destination_id" class="form-label fw-bold text-secondary">Destination *</label>
                            <select class="form-control rounded-3 @error('destination_id') is-invalid @enderror"
                                id="destination_id" name="destination_id" required>
                                <option value="">Select Destination</option>
                                @foreach($destinations as $destination)
                                <option value="{{ $destination->id }}" {{ old('destination_id') == $destination->id ? 'selected' : '' }}>
                                    {{ $destination->name['en'] ?? 'N/A' }}
                                </option>
                                @endforeach
                            </select>
                            @error('destination_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Tour Type -->
                        <div class="col-md-6">
                            <label for="tour_type" class="form-label fw-bold text-secondary">Tour Type *</label>
                            <select class="form-control rounded-3 @error('tour_type') is-invalid @enderror"
                                id="tour_type" name="tour_type" required>
                                <option value="">Select Tour Type</option>
                                <option value="hotel" {{ old('tour_type') == 'hotel' ? 'selected' : '' }}>Hotel</option>
                                <option value="honeymoon" {{ old('tour_type') == 'honeymoon' ? 'selected' : '' }}>Honeymoon</option>
                                <option value="trip" {{ old('tour_type') == 'trip' ? 'selected' : '' }}>Trip</option>
                            </select>
                            @error('tour_type')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>


                    <!-- Tabs for Languages -->
                    <ul class="nav nav-tabs mb-4" id="langTabs" role="tablist">
                        <li class="nav-item"><button class="nav-link active" id="en-tab" data-bs-toggle="tab" data-bs-target="#en" type="button">English</button></li>
                        <li class="nav-item"><button class="nav-link" id="fr-tab" data-bs-toggle="tab" data-bs-target="#fr" type="button">French</button></li>
                        <li class="nav-item"><button class="nav-link" id="de-tab" data-bs-toggle="tab" data-bs-target="#de" type="button">German</button></li>
                    </ul>

                    <div class="tab-content">
                        <!-- English -->
                        <div class="tab-pane fade show active" id="en" role="tabpanel">
                            <div class="mb-3">
                                <label class="form-label text-secondary">Title (EN) *</label>
                                <input type="text" name="title[en]" class="form-control rounded-3" placeholder="Enter tour title" value="{{ old('title.en') }}" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label text-secondary">Description (EN)</label>
                                <textarea name="description[en]" class="form-control rounded-3" rows="3">{{ old('description.en') }}</textarea>
                            </div>
                        </div>

                        <!-- French -->
                        <div class="tab-pane fade" id="fr" role="tabpanel">
                            <div class="mb-3">
                                <label class="form-label text-secondary">Title (FR)</label>
                                <input type="text" name="title[fr]" class="form-control rounded-3" placeholder="Titre du tour" value="{{ old('title.fr') }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label text-secondary">Description (FR)</label>
                                <textarea name="description[fr]" class="form-control rounded-3" rows="3">{{ old('description.fr') }}</textarea>
                            </div>
                        </div>

                        <!-- German -->
                        <div class="tab-pane fade" id="de" role="tabpanel">
                            <div class="mb-3">
                                <label class="form-label text-secondary">Title (DE)</label>
                                <input type="text" name="title[de]" class="form-control rounded-3" placeholder="Reisetitel" value="{{ old('title.de') }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label text-secondary">Description (DE)</label>
                                <textarea name="description[de]" class="form-control rounded-3" rows="3">{{ old('description.de') }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Capacity & Rating -->
                    <div class="row mt-3">
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-secondary fw-bold">Capacity (People) *</label>
                            <input type="number" name="capacity" class="form-control rounded-3" value="{{ old('capacity') }}" required min="1" max="1000">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-secondary fw-bold">Rating (0-5)</label>
                            <input type="number" name="rating" class="form-control rounded-3" value="{{ old('rating') }}" min="0" max="5" step="0.1">
                        </div>
                    </div>

                    <!-- Hotel Info -->
                    <div class="mb-4">
                        <h5 class="text-secondary fw-bold mb-3">Hotel Information</h5>
                        <ul class="nav nav-tabs mb-3" id="hotelTabs" role="tablist">
                            <li class="nav-item"><button class="nav-link active" id="hotel-en-tab" data-bs-toggle="tab" data-bs-target="#hotel-en" type="button">English</button></li>
                            <li class="nav-item"><button class="nav-link" id="hotel-fr-tab" data-bs-toggle="tab" data-bs-target="#hotel-fr" type="button">French</button></li>
                            <li class="nav-item"><button class="nav-link" id="hotel-de-tab" data-bs-toggle="tab" data-bs-target="#hotel-de" type="button">German</button></li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="hotel-en" role="tabpanel">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Hotel Name (EN)</label>
                                        <input type="text" name="hotel_info[en][name]" class="form-control rounded-3" value="{{ old('hotel_info.en.name') }}">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Location (EN)</label>
                                        <input type="text" name="hotel_info[en][location]" class="form-control rounded-3" value="{{ old('hotel_info.en.location') }}">
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Features (EN) - Comma separated</label>
                                    <input type="text" name="hotel_info[en][features]" class="form-control rounded-3" placeholder="Beach, Pool, Spa" value="{{ old('hotel_info.en.features') }}">
                                </div>
                            </div>
                            <div class="tab-pane fade" id="hotel-fr" role="tabpanel">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Hotel Name (FR)</label>
                                        <input type="text" name="hotel_info[fr][name]" class="form-control rounded-3" value="{{ old('hotel_info.fr.name') }}">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Location (FR)</label>
                                        <input type="text" name="hotel_info[fr][location]" class="form-control rounded-3" value="{{ old('hotel_info.fr.location') }}">
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Features (FR) - Comma separated</label>
                                    <input type="text" name="hotel_info[fr][features]" class="form-control rounded-3" placeholder="Plage, Piscine, Spa" value="{{ old('hotel_info.fr.features') }}">
                                </div>
                            </div>
                            <div class="tab-pane fade" id="hotel-de" role="tabpanel">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Hotel Name (DE)</label>
                                        <input type="text" name="hotel_info[de][name]" class="form-control rounded-3" value="{{ old('hotel_info.de.name') }}">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Location (DE)</label>
                                        <input type="text" name="hotel_info[de][location]" class="form-control rounded-3" value="{{ old('hotel_info.de.location') }}">
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Features (DE) - Comma separated</label>
                                    <input type="text" name="hotel_info[de][features]" class="form-control rounded-3" placeholder="Strand, Schwimmbad, Wellness" value="{{ old('hotel_info.de.features') }}">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Package Info -->
                    <div class="mb-4">
                        <h5 class="text-secondary fw-bold mb-3">Package Information</h5>
                        <ul class="nav nav-tabs mb-3" id="packageTabs" role="tablist">
                            <li class="nav-item"><button class="nav-link active" id="package-en-tab" data-bs-toggle="tab" data-bs-target="#package-en" type="button">English</button></li>
                            <li class="nav-item"><button class="nav-link" id="package-fr-tab" data-bs-toggle="tab" data-bs-target="#package-fr" type="button">French</button></li>
                            <li class="nav-item"><button class="nav-link" id="package-de-tab" data-bs-toggle="tab" data-bs-target="#package-de" type="button">German</button></li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="package-en" role="tabpanel">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Board Type (EN)</label>
                                        <input type="text" name="package_info[en][board]" class="form-control rounded-3" placeholder="All Inclusive" value="{{ old('package_info.en.board') }}">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Child Policy (EN)</label>
                                        <input type="text" name="package_info[en][child_policy]" class="form-control rounded-3" placeholder="Free under 6" value="{{ old('package_info.en.child_policy') }}">
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Activities (EN) - Comma separated</label>
                                    <input type="text" name="package_info[en][activities]" class="form-control rounded-3" placeholder="Snorkeling, Safari" value="{{ old('package_info.en.activities') }}">
                                </div>
                            </div>
                            <div class="tab-pane fade" id="package-fr" role="tabpanel">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Board Type (FR)</label>
                                        <input type="text" name="package_info[fr][board]" class="form-control rounded-3" placeholder="Tout inclus" value="{{ old('package_info.fr.board') }}">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Child Policy (FR)</label>
                                        <input type="text" name="package_info[fr][child_policy]" class="form-control rounded-3" placeholder="Gratuit pour moins de 6 ans" value="{{ old('package_info.fr.child_policy') }}">
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Activities (FR) - Comma separated</label>
                                    <input type="text" name="package_info[fr][activities]" class="form-control rounded-3" placeholder="Plongée, Safari" value="{{ old('package_info.fr.activities') }}">
                                </div>
                            </div>
                            <div class="tab-pane fade" id="package-de" role="tabpanel">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Board Type (DE)</label>
                                        <input type="text" name="package_info[de][board]" class="form-control rounded-3" placeholder="Alles inklusive" value="{{ old('package_info.de.board') }}">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Child Policy (DE)</label>
                                        <input type="text" name="package_info[de][child_policy]" class="form-control rounded-3" placeholder="Kostenlos unter 6 Jahren" value="{{ old('package_info.de.child_policy') }}">
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Activities (DE) - Comma separated</label>
                                    <input type="text" name="package_info[de][activities]" class="form-control rounded-3" placeholder="Schnorcheln, Safari" value="{{ old('package_info.de.activities') }}">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Images -->
                    <div class="mb-4">
                        <label class="form-label text-secondary fw-bold">Tour Images</label>
                        <div class="p-4 border border-2 border-dashed rounded-4 text-center bg-white" id="dropZone">
                            <i class="fas fa-cloud-upload-alt fa-2x text-primary mb-2"></i>
                            <p class="mb-2">Drag & Drop images here or click to upload</p>
                            <input type="file" id="images" name="image[]" multiple accept="image/*" class="d-none">
                            <label for="images" class="btn btn-outline-primary rounded-pill">Choose Images</label>
                            <div id="imagesPreview" class="row mt-3"></div>
                        </div>
                    </div>

                    <!-- Save -->
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-lg rounded-pill fw-bold shadow-sm">
                            <i class="fas fa-save me-2"></i> Save Tour
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Custom Styles -->
<style>
    .bg-gradient-primary {
        background: linear-gradient(90deg, #0d6efd, #0b5ed7);
    }

    .form-control:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, .25);
    }

    #dropZone {
        cursor: pointer;
        transition: background 0.3s;
    }

    #dropZone.dragover {
        background: #e9f5ff;
    }

    #imagesPreview img {
        height: 150px;
        object-fit: cover;
    }
</style>

<!-- Script for Image Preview -->
<script>
    const dropZone = document.getElementById('dropZone');
    const imagesInput = document.getElementById('images');
    const previewContainer = document.getElementById('imagesPreview');

    dropZone.addEventListener('click', () => imagesInput.click());
    dropZone.addEventListener('dragover', e => {
        e.preventDefault();
        dropZone.classList.add('dragover');
    });
    dropZone.addEventListener('dragleave', () => dropZone.classList.remove('dragover'));
    dropZone.addEventListener('drop', e => {
        e.preventDefault();
        imagesInput.files = e.dataTransfer.files;
        handleFiles(imagesInput.files);
        dropZone.classList.remove('dragover');
    });

    imagesInput.addEventListener('change', () => handleFiles(imagesInput.files));

    function handleFiles(files) {
        previewContainer.innerHTML = "";
        Array.from(files).forEach(file => {
            const reader = new FileReader();
            reader.onload = e => {
                const col = document.createElement('div');
                col.className = "col-md-3 mb-2";
                col.innerHTML = `<img src="${e.target.result}" class="img-fluid rounded shadow-sm">`;
                previewContainer.appendChild(col);
            };
            reader.readAsDataURL(file);
        });
    }
</script>
@endsection