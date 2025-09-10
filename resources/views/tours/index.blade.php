@extends('layouts.app')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="container mt-4" dir="rtl">
                    <div class="row justify-content-center">
                        <h1 class="text-center mb-4" style="font-size: 2rem; font-weight: bold; color: #2c3e50;">
                            Welcome to Tours Management
                        </h1>
                        <div class="col-md-12">
                            <div class="card shadow-lg border-0">
                                <div class="card-header bg-primary text-white">
                                    <h4 class="d-flex justify-content-between align-items-center mb-0">
                                        Tours List
                                        <a href="{{ route('tours.create') }}" class="btn btn-light btn-sm text-dark bg-light">Add Tour</a>
                                    </h4>
                                </div>

                                <div class="card-body bg-light">
                                    <!-- Search and Filter Bar -->
                                    <div class="d-flex justify-content-between align-items-center mb-4">
                                        <button onclick="printTable()" class="btn btn-outline-dark btn-sm shadow-sm">
                                            <i class="bi bi-printer"></i> Print
                                        </button>
                                        <form action="{{ route('tours.index') }}" method="GET" class="d-flex w-100 gap-2">
                                            <!-- Destination Filter -->
                                            <select name="destination_id" class="form-control">
                                                <option value="">All Destinations</option>
                                                @foreach($destinations as $dest)
                                                    <option value="{{ $dest->id }}" {{ request('destination_id') == $dest->id ? 'selected' : '' }}>
                                                        {{ $dest->name['en'] ?? $dest->name['ar'] ?? 'N/A' }}
                                                    </option>
                                                @endforeach
                                            </select>

                                            <!-- Tour Type Filter -->
                                            <select name="tour_type" class="form-control">
                                                <option value="">All Types</option>
                                                <option value="hotel" {{ request('tour_type') == 'hotel' ? 'selected' : '' }}>Hotel</option>
                                                <option value="honeymoon" {{ request('tour_type') == 'honeymoon' ? 'selected' : '' }}>Honeymoon</option>
                                                <option value="trip" {{ request('tour_type') == 'trip' ? 'selected' : '' }}>Trip</option>
                                            </select>

                                            <!-- Search -->
                                            <input type="text" name="search" class="form-control" placeholder="Search for tour..." value="{{ request('search') }}">
                                            <button type="submit" class="btn btn-primary">Search</button>
                                        </form>
                                    </div>

                                    <div id="printArea">
                                        <!-- Tours Table -->
                                        <div class="table-responsive">
                                            <table class="table table-hover text-center align-middle mb-0">
                                                <thead class="table-dark">
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Title (EN)</th>
                                                        <th>Title (FR)</th>
                                                        <th>Title (DE)</th>
                                                        <th>Destination</th>
                                                        <th>Type</th>
                                                        <th>Duration</th>
                                                        <th>Capacity</th>
                                                        <th>Images</th>
                                                        <th>Added By</th>
                                                        <th colspan="3">Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse ($tours as $tour)
                                                        <tr class="hover-shadow">
                                                            <td class="fw-bold">{{ $loop->iteration }}</td>
                                                            <td>{{ $tour->title['en'] ?? 'N/A' }}</td>
                                                            <td>{{ $tour->title['fr'] ?? 'N/A' }}</td>
                                                            <td>{{ $tour->title['de'] ?? 'N/A' }}</td>
                                                            <td>{{ $tour->destination->name['en'] ?? 'N/A' }}</td>
                                                            <td>
                                                                <span class="badge bg-dark text-white">{{ ucfirst($tour->tour_type) }}</span>
                                                            </td>
                                                            <td>
                                                                <span class="badge bg-info">{{ $tour->duration_days }} days</span>
                                                            </td>
                                                            <td>
                                                                <span class="badge bg-secondary">{{ $tour->capacity }} people</span>
                                                            </td>
                                                            <td>
                                                                @if($tour->image && is_array($tour->image) && count($tour->image) > 0)
                                                                    <img src="{{ $tour->image_urls[0] ?? '' }}" alt="Tour Image" class="img-thumbnail" style="width: 50px; height: 50px;">
                                                                    @if(count($tour->image) > 1)
                                                                        <small class="text-muted d-block">+{{ count($tour->image) - 1 }} more</small>
                                                                    @endif
                                                                @else
                                                                    <span class="text-muted">No Images</span>
                                                                @endif
                                                            </td>
                                                            <td>{{ $tour->addedByUser->name ?? 'N/A' }}</td>
                                                            <td>
                                                                <a href="{{ route('tours.show', $tour->id) }}" class="btn btn-info btn-sm">
                                                                    <i class="bi bi-eye"></i> View
                                                                </a>
                                                            </td>
                                                            <td>
                                                                <a href="{{ route('tours.edit', $tour->id) }}" class="btn btn-warning btn-sm">
                                                                    <i class="bi bi-pencil"></i> Edit
                                                                </a>
                                                            </td>
                                                            <td>
                                                                <form action="{{ route('tours.destroy', $tour->id) }}" method="POST" class="d-inline">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this tour?')">
                                                                        <i class="bi bi-trash"></i> Delete
                                                                    </button>
                                                                </form>
                                                            </td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td colspan="12" class="text-center text-muted py-4">
                                                                <i class="bi bi-info-circle"></i> No tours available.
                                                            </td>
                                                        </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <!-- Pagination -->
                                    <div class="d-flex justify-content-center mt-4">
                                        {{ $tours->links('pagination::bootstrap-5') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <style>
                    .hover-shadow:hover {
                        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                        transition: box-shadow 0.3s ease;
                    }

                    .card {
                        border-radius: 15px;
                    }

                    .card-header {
                        border-radius: 15px 15px 0 0;
                    }

                    .table th, .table td {
                        vertical-align: middle;
                    }

                    .badge {
                        font-size: 0.9rem;
                        padding: 0.5em 0.75em;
                    }

                    .btn-sm {
                        padding: 0.25rem 0.5rem;
                        font-size: 0.875rem;
                    }
                </style>
                <script>
                    function printTable() {
                        var printContents = document.getElementById('printArea').innerHTML;
                        var originalContents = document.body.innerHTML;

                        document.body.innerHTML = `
                            <html>
                            <head>
                                <title>Print Tours List</title>
                                <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
                            </head>
                            <body>
                                <h3 style="text-align:center;">Tours List</h3>
                                ${printContents}
                            </body>
                            </html>
                        `;

                        window.print();
                        location.reload();
                    }
                </script>
            </div>
        </div>
    </div>
@endsection