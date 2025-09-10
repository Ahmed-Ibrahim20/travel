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
                                    <h3 class="mb-0 text-primary fw-bold">Edit Tour</h3>
                                    <a href="{{ route('tours.index') }}" class="btn btn-outline-primary btn-lg rounded-pill">
                                        <i class="fas fa-list me-2"></i> View Tours
                                    </a>
                                </div>
                            </div>
                            <div class="card-body p-4">
                                @if ($errors->any())
                                <div class="alert alert-danger rounded-3">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                                @endif

                                <form action="{{ route('tours.update', $tour->id) }}" method="post" enctype="multipart/form-data" class="needs-validation">
                                    @csrf
                                    @method('PUT')

                                    <div class="row mb-4">
                                        <!-- Destination Selection -->
                                        <div class="col-md-6">
                                            <label for="destination_id" class="form-label text-secondary">Destination *</label>
                                            <select class="form-control rounded-pill @error('destination_id') is-invalid @enderror"
                                                id="destination_id" name="destination_id" required>
                                                <option value="">Select Destination</option>
                                                @foreach($destinations as $destination)
                                                <option value="{{ $destination->id }}"
                                                    {{ old('destination_id', $tour->destination_id) == $destination->id ? 'selected' : '' }}>
                                                    {{ $destination->name['en'] ?? $destination->name['fr'] ?? 'N/A' }}
                                                </option>
                                                @endforeach
                                            </select>
                                            @error('destination_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Tour Type -->
                                        <div class="col-md-6">
                                            <label for="tour_type" class="form-label text-secondary">Tour Type *</label>
                                            <select class="form-control rounded-pill @error('tour_type') is-invalid @enderror"
                                                id="tour_type" name="tour_type" required>
                                                <option value="">Select Tour Type</option>
                                                <option value="hotel" {{ old('tour_type', $tour->tour_type) == 'hotel' ? 'selected' : '' }}>Hotel</option>
                                                <option value="honeymoon" {{ old('tour_type', $tour->tour_type) == 'honeymoon' ? 'selected' : '' }}>Honeymoon</option>
                                                <option value="trip" {{ old('tour_type', $tour->tour_type) == 'trip' ? 'selected' : '' }}>Trip</option>
                                            </select>
                                            @error('tour_type')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>


                                    <!-- Tabs for Translations -->
                                    <ul class="nav nav-tabs mb-3" id="langTabs" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link active" id="en-tab" data-bs-toggle="tab" data-bs-target="#lang-en" type="button" role="tab">
                                                🇬🇧 English
                                            </button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="fr-tab" data-bs-toggle="tab" data-bs-target="#lang-fr" type="button" role="tab">
                                                🇫🇷 French
                                            </button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="de-tab" data-bs-toggle="tab" data-bs-target="#lang-de" type="button" role="tab">
                                                🇩🇪 German
                                            </button>
                                        </li>
                                    </ul>

                                    <div class="tab-content" id="langTabsContent">
                                        <!-- English -->
                                        <div class="tab-pane fade show active" id="lang-en" role="tabpanel">
                                            <div class="mb-3">
                                                <label class="form-label text-secondary">Title (English) *</label>
                                                <input type="text" name="title[en]" class="form-control rounded-pill @error('title.en') is-invalid @enderror"
                                                    value="{{ old('title.en', $tour->title['en'] ?? '') }}" placeholder="Enter tour title in English" required>
                                                @error('title.en') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label text-secondary">Description (English)</label>
                                                <textarea name="description[en]" rows="3" class="form-control @error('description.en') is-invalid @enderror"
                                                    placeholder="Enter description in English">{{ old('description.en', $tour->description['en'] ?? '') }}</textarea>
                                                @error('description.en') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                            </div>
                                        </div>

                                        <!-- French -->
                                        <div class="tab-pane fade" id="lang-fr" role="tabpanel">
                                            <div class="mb-3">
                                                <label class="form-label text-secondary">Title (French)</label>
                                                <input type="text" name="title[fr]" class="form-control rounded-pill @error('title.fr') is-invalid @enderror"
                                                    value="{{ old('title.fr', $tour->title['fr'] ?? '') }}" placeholder="Entrez le titre du tour en français">
                                                @error('title.fr') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label text-secondary">Description (French)</label>
                                                <textarea name="description[fr]" rows="3" class="form-control @error('description.fr') is-invalid @enderror"
                                                    placeholder="Entrez la description en français">{{ old('description.fr', $tour->description['fr'] ?? '') }}</textarea>
                                                @error('description.fr') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                            </div>
                                        </div>

                                        <!-- German -->
                                        <div class="tab-pane fade" id="lang-de" role="tabpanel">
                                            <div class="mb-3">
                                                <label class="form-label text-secondary">Title (German)</label>
                                                <input type="text" name="title[de]" class="form-control rounded-pill @error('title.de') is-invalid @enderror"
                                                    value="{{ old('title.de', $tour->title['de'] ?? '') }}" placeholder="Geben Sie den Titel der Tour auf Deutsch ein">
                                                @error('title.de') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label text-secondary">Description (German)</label>
                                                <textarea name="description[de]" rows="3" class="form-control @error('description.de') is-invalid @enderror"
                                                    placeholder="Geben Sie die Beschreibung auf Deutsch ein">{{ old('description.de', $tour->description['de'] ?? '') }}</textarea>
                                                @error('description.de') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Duration and Capacity -->
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="duration_days" class="form-label text-secondary">Duration (Days) *</label>
                                            <input type="number" class="form-control rounded-pill @error('duration_days') is-invalid @enderror"
                                                id="duration_days" name="duration_days" value="{{ old('duration_days', $tour->duration_days) }}" min="1" max="365" required>
                                            @error('duration_days') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="capacity" class="form-label text-secondary">Capacity (People) *</label>
                                            <input type="number" class="form-control rounded-pill @error('capacity') is-invalid @enderror"
                                                id="capacity" name="capacity" value="{{ old('capacity', $tour->capacity) }}" min="1" max="1000" required>
                                            @error('capacity') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                    </div>

                                    <!-- Current Images Display -->
                                    @if($tour->image && is_array($tour->image) && count($tour->image) > 0)
                                    <div class="mb-3">
                                        <label class="form-label text-secondary">Current Images</label>
                                        <div class="row">
                                            @foreach($tour->image_urls as $imageUrl)
                                            <div class="col-md-3 mb-2">
                                                <img src="{{ $imageUrl }}" class="img-fluid rounded shadow-sm" style="height: 150px; object-fit: cover;">
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    @endif

                                    <!-- Multiple Images Upload -->
                                    <div class="mb-3">
                                        <label class="form-label text-secondary">Update Tour Images</label>
                                        <div class="image-upload-wrapper text-center p-4 border-2 border-dashed rounded-4">
                                            <input type="file" id="images" name="image[]" accept="image/*" multiple class="d-none">
                                            <label for="images" class="btn btn-outline-primary rounded-pill px-4">
                                                <i class="fas fa-upload me-2"></i> Choose New Images (Multiple)
                                            </label>

                                            <div id="imagesPreview" class="mt-3 d-none">
                                                <div class="row" id="previewContainer"></div>
                                                <button type="button" class="btn btn-sm btn-danger rounded-pill mt-2" id="removeAllImages">
                                                    <i class="fas fa-trash-alt me-1"></i> Remove All Images
                                                </button>
                                            </div>
                                        </div>
                                        @error('image') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                    </div>

                                    <!-- Save Button -->
                                    <div class="d-grid mt-4">
                                        <button type="submit" class="btn btn-primary btn-lg rounded-pill fw-bold">
                                            <i class="fas fa-save me-2"></i> Update Tour
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Multiple Images Preview
    const imagesInput = document.getElementById('images');
    const imagesPreview = document.getElementById('imagesPreview');
    const previewContainer = document.getElementById('previewContainer');
    const removeAllBtn = document.getElementById('removeAllImages');

    imagesInput.addEventListener('change', function() {
        previewContainer.innerHTML = '';

        if (this.files && this.files.length > 0) {
            Array.from(this.files).forEach((file, index) => {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const colDiv = document.createElement('div');
                    colDiv.className = 'col-md-3 mb-2';
                    colDiv.innerHTML = `
                        <div class="position-relative">
                            <img src="${e.target.result}" class="img-fluid rounded shadow-sm" style="height: 150px; object-fit: cover;">
                            <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 m-1 rounded-circle" onclick="removeImage(this)">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    `;
                    previewContainer.appendChild(colDiv);
                }
                reader.readAsDataURL(file);
            });
            imagesPreview.classList.remove('d-none');
        }
    });

    removeAllBtn.addEventListener('click', function() {
        imagesInput.value = "";
        previewContainer.innerHTML = "";
        imagesPreview.classList.add('d-none');
    });

    function removeImage(button) {
        button.closest('.col-md-3').remove();
        if (previewContainer.children.length === 0) {
            imagesPreview.classList.add('d-none');
        }
    }
</script>
@endsection