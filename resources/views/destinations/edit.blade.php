@extends('layouts.app')

@section('content')

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-md-10">
                        <div class="card border-0 shadow-lg rounded-4">
                            <div class="card-header bg-primary text-white py-3 rounded-top-4 shadow-sm">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h3 class="mb-0 fw-bold">
                                        <i class="fas fa-map-marker-alt me-2"></i> Edit Destination
                                    </h3>
                                    <a href="{{ route('destinations.index') }}"
                                        class="btn btn-warning btn-lg rounded-pill shadow-sm text-dark">
                                        <i class="fas fa-list me-2"></i> View Destinations
                                    </a>
                                </div>
                            </div>

                            <div class="card-body p-5 bg-light">
                                @if ($errors->any())
                                <div class="alert alert-danger rounded-3 shadow-sm">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                                @endif

                                <form action="{{ route('destinations.update', $destination->id) }}"
                                    method="post" enctype="multipart/form-data"
                                    class="needs-validation" novalidate>
                                    @csrf
                                    @method('PUT')

                                    <div class="row g-4">
                                        <!-- English -->
                                        <div class="col-md-4">
                                            <label for="name_en" class="form-label text-secondary fw-bold">Name (English) *</label>
                                            <input type="text" class="form-control rounded-3 @error('name.en') is-invalid @enderror"
                                                id="name_en" name="name[en]"
                                                value="{{ old('name.en', $destination->name['en'] ?? '') }}"
                                                placeholder="Enter name in English" required>
                                            @error('name.en') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>

                                        <!-- French -->
                                        <div class="col-md-4">
                                            <label for="name_fr" class="form-label text-secondary fw-bold">Name (French)</label>
                                            <input type="text" class="form-control rounded-3 @error('name.fr') is-invalid @enderror"
                                                id="name_fr" name="name[fr]"
                                                value="{{ old('name.fr', $destination->name['fr'] ?? '') }}"
                                                placeholder="Nom en français">
                                            @error('name.fr') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>

                                        <!-- German -->
                                        <div class="col-md-4">
                                            <label for="name_de" class="form-label text-secondary fw-bold">Name (German)</label>
                                            <input type="text" class="form-control rounded-3 @error('name.de') is-invalid @enderror"
                                                id="name_de" name="name[de]"
                                                value="{{ old('name.de', $destination->name['de'] ?? '') }}"
                                                placeholder="Name auf Deutsch">
                                            @error('name.de') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                    </div>

                                    <!-- Descriptions -->
                                    <div class="row g-4 mt-2">
                                        <div class="col-md-4">
                                            <label for="description_en" class="form-label text-secondary fw-bold">Description (English)</label>
                                            <textarea class="form-control rounded-3"
                                                id="description_en" name="description[en]" rows="3"
                                                placeholder="Description in English">{{ old('description.en', $destination->description['en'] ?? '') }}</textarea>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="description_fr" class="form-label text-secondary fw-bold">Description (French)</label>
                                            <textarea class="form-control rounded-3"
                                                id="description_fr" name="description[fr]" rows="3"
                                                placeholder="Description en français">{{ old('description.fr', $destination->description['fr'] ?? '') }}</textarea>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="description_de" class="form-label text-secondary fw-bold">Description (German)</label>
                                            <textarea class="form-control rounded-3"
                                                id="description_de" name="description[de]" rows="3"
                                                placeholder="Beschreibung auf Deutsch">{{ old('description.de', $destination->description['de'] ?? '') }}</textarea>
                                        </div>
                                    </div>

                                    <!-- Slug -->
                                    <div class="mt-4">
                                        <label for="slug" class="form-label text-secondary fw-bold">Slug (URL)</label>
                                        <input type="text" class="form-control rounded-3 @error('slug') is-invalid @enderror"
                                            id="slug" name="slug"
                                            value="{{ old('slug', $destination->slug) }}"
                                            placeholder="destination-slug">
                                        @error('slug') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>

                                    <!-- Current Image -->
                                    @if($destination->image)
                                    <div class="mt-4">
                                        <label class="form-label text-secondary fw-bold">Current Image</label>
                                        <div class="text-center">
                                            <img src="{{ $destination->image_url }}"
                                                class="img-fluid rounded shadow-sm border"
                                                style="max-height: 220px;">
                                        </div>
                                    </div>
                                    @endif

                                    <!-- Upload New Image -->
                                    <div class="mt-4">
                                        <label class="form-label text-secondary fw-bold">Update Image</label>
                                        <div class="p-4 border-2 border-dashed rounded-4 text-center bg-white">
                                            <input type="file" id="image" name="image" accept="image/*" class="d-none">
                                            <label for="image" class="btn btn-outline-primary rounded-pill px-4 shadow-sm">
                                                <i class="fas fa-upload me-2"></i> Choose Image
                                            </label>

                                            <div id="imagePreview" class="mt-3 d-none">
                                                <img src="" class="img-fluid rounded shadow-sm mb-2" style="max-height: 200px;">
                                                <br>
                                                <button type="button" class="btn btn-sm btn-danger rounded-pill" id="removeImage">
                                                    <i class="fas fa-trash-alt me-1"></i> Remove
                                                </button>
                                            </div>
                                        </div>
                                        @error('image') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                    </div>

                                    <!-- Save -->
                                    <div class="d-grid mt-5">
                                        <button type="submit" class="btn btn-primary btn-lg rounded-pill shadow-sm fw-bold">
                                            <i class="fas fa-save me-2"></i> Update Destination
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
    // Image Preview
    const imageInput = document.getElementById('image');
    const imagePreview = document.getElementById('imagePreview');
    const previewImg = imagePreview.querySelector('img');
    const removeBtn = document.getElementById('removeImage');

    if (imageInput) {
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
    }

    if (removeBtn) {
        removeBtn.addEventListener('click', function() {
            imageInput.value = "";
            previewImg.src = "";
            imagePreview.classList.add('d-none');
        });
    }

    // Auto-generate slug from English name
    const nameEn = document.getElementById('name_en');
    if (nameEn) {
        nameEn.addEventListener('input', function() {
            const slug = this.value.toLowerCase()
                .replace(/[^a-z0-9\s-]/g, '')
                .replace(/\s+/g, '-')
                .replace(/-+/g, '-')
                .trim('-');
            document.getElementById('slug').value = slug;
        });
    }
</script>
@endsection