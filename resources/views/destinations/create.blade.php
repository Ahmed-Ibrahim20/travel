@extends('layouts.app')

@section('content')
<div class="container-fluid py-5">
    <div class="row justify-content-center">
        <div class="col-lg-9">
            <div class="card border-0 shadow-lg rounded-4">
                <div class="card-header bg-gradient bg-primary text-white py-3 rounded-top-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="mb-0 fw-bold">
                            <i class="fas fa-map-marked-alt me-2"></i> Add New Destination
                        </h3>
                        <a href="{{ route('destinations.index') }}" class="btn btn-light btn-sm rounded-pill">
                            <i class="fas fa-list me-1"></i> View Destinations
                        </a>
                    </div>
                </div>

                <div class="card-body p-5">
                    @if ($errors->any())
                        <div class="alert alert-danger rounded-3 shadow-sm">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li><i class="fas fa-exclamation-circle me-2"></i>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form id="destinationForm" action="{{ route('destinations.store') }}" method="post" enctype="multipart/form-data" novalidate>
                        @csrf

                        <!-- Tabs for languages -->
                        <ul class="nav nav-tabs mb-4" id="langTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="en-tab" data-bs-toggle="tab" data-bs-target="#en" type="button" role="tab">
                                    🇬🇧 English
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="fr-tab" data-bs-toggle="tab" data-bs-target="#fr" type="button" role="tab">
                                    🇫🇷 Français
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="de-tab" data-bs-toggle="tab" data-bs-target="#de" type="button" role="tab">
                                    🇩🇪 Deutsch
                                </button>
                            </li>
                        </ul>

                        <div class="tab-content mb-4" id="langTabsContent">
                            <!-- English -->
                            <div class="tab-pane fade show active" id="en" role="tabpanel">
                                <div class="mb-3">
                                    <label for="name_en" class="form-label fw-semibold">Name (English) *</label>
                                    <input type="text" class="form-control rounded-pill @error('name.en') is-invalid @enderror" 
                                           id="name_en" name="name[en]" value="{{ old('name.en') }}" required>
                                    @error('name.en')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="description_en" class="form-label fw-semibold">Description (English)</label>
                                    <textarea class="form-control rounded-3 @error('description.en') is-invalid @enderror" 
                                              id="description_en" name="description[en]" rows="3">{{ old('description.en') }}</textarea>
                                    @error('description.en')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- French -->
                            <div class="tab-pane fade" id="fr" role="tabpanel">
                                <div class="mb-3">
                                    <label for="name_fr" class="form-label fw-semibold">Nom (Français)</label>
                                    <input type="text" class="form-control rounded-pill @error('name.fr') is-invalid @enderror" 
                                           id="name_fr" name="name[fr]" value="{{ old('name.fr') }}">
                                    @error('name.fr')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="description_fr" class="form-label fw-semibold">Description (Français)</label>
                                    <textarea class="form-control rounded-3 @error('description.fr') is-invalid @enderror" 
                                              id="description_fr" name="description[fr]" rows="3">{{ old('description.fr') }}</textarea>
                                    @error('description.fr')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- German -->
                            <div class="tab-pane fade" id="de" role="tabpanel">
                                <div class="mb-3">
                                    <label for="name_de" class="form-label fw-semibold">Name (Deutsch)</label>
                                    <input type="text" class="form-control rounded-pill @error('name.de') is-invalid @enderror" 
                                           id="name_de" name="name[de]" value="{{ old('name.de') }}">
                                    @error('name.de')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="description_de" class="form-label fw-semibold">Beschreibung (Deutsch)</label>
                                    <textarea class="form-control rounded-3 @error('description.de') is-invalid @enderror" 
                                              id="description_de" name="description[de]" rows="3">{{ old('description.de') }}</textarea>
                                    @error('description.de')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Slug -->
                        <div class="mb-4">
                            <label for="slug" class="form-label fw-semibold">Slug (URL)</label>
                            <input type="text" class="form-control rounded-pill @error('slug') is-invalid @enderror" 
                                   id="slug" name="slug" placeholder="destination-slug" value="{{ old('slug') }}">
                            @error('slug')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Image Upload -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Destination Image</label>
                            <div class="border border-2 border-dashed rounded-4 p-4 text-center bg-light">
                                <input type="file" id="image" name="image" accept="image/*" class="d-none">
                                <label for="image" class="btn btn-outline-primary rounded-pill px-4">
                                    <i class="fas fa-upload me-2"></i> Upload Image
                                </label>
                                <div id="imagePreview" class="mt-3 d-none">
                                    <img src="" alt="Preview" class="img-fluid rounded shadow-sm mb-2" style="max-height:200px;">
                                    <br>
                                    <button type="button" class="btn btn-sm btn-danger rounded-pill" id="removeImage">
                                        <i class="fas fa-trash-alt me-1"></i> Remove
                                    </button>
                                </div>
                            </div>
                            @error('image')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Save Button -->
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg rounded-pill fw-bold shadow-sm">
                                <i class="fas fa-save me-2"></i> Save Destination
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Image Preview
    const imageInput = document.getElementById('image');
    const imagePreview = document.getElementById('imagePreview');
    const previewImg = imagePreview.querySelector('img');
    const removeBtn = document.getElementById('removeImage');

    imageInput.addEventListener('change', function() {
        if (this.files && this.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImg.src = e.target.result;
                imagePreview.classList.remove('d-none');
            }
            reader.readAsDataURL(this.files[0]);
        }
    });

    removeBtn.addEventListener('click', function() {
        imageInput.value = "";
        previewImg.src = "";
        imagePreview.classList.add('d-none');
    });

    // Auto-generate slug from English name
    document.getElementById('name_en').addEventListener('input', function() {
        const slug = this.value.toLowerCase()
            .replace(/[^a-z0-9\s-]/g, '')
            .replace(/\s+/g, '-')
            .replace(/-+/g, '-')
            .trim('-');
        document.getElementById('slug').value = slug;
    });
</script>
@endsection
