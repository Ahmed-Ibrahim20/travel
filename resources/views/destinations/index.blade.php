@extends('layouts.app')

@section('content')

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="container mt-4" dir="rtl">
                    <div class="row justify-content-center">
                        <h1 class="text-center mb-4 fw-bold text-dark" style="font-size: 2rem;">
                            Welcome to Destinations Management
                        </h1>
                        <div class="col-md-12">

                            {{-- Success Message --}}
                            <!-- @if (Session::has('success'))
                                <div class="alert alert-success alert-dismissible fade show rounded-3 shadow-sm" role="alert">
                                    {{ Session::get('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif -->

                            {{-- Card --}}
                            <div class="card shadow-lg border-0">
                                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                                    <h4 class="mb-0">Destinations List</h4>
                                    <a href="{{ route('destinations.create') }}" class="btn btn-light btn-sm rounded-pill fw-bold text-dark">
                                        <i class="bi bi-plus-circle me-1"></i> Add Destination
                                    </a>
                                </div>

                                <div class="card-body bg-light">
                                    {{-- Search + Print --}}
                                    <div class="d-flex justify-content-between align-items-center mb-4">
                                        <button onclick="printTable()" class="btn btn-outline-dark btn-sm shadow-sm rounded-pill">
                                            <i class="bi bi-printer me-1"></i> Print
                                        </button>
                                        <form action="{{ route('destinations.index') }}" method="GET" class="d-flex w-100 ms-3">
                                            <input type="text" name="search" class="form-control me-2 rounded-pill"
                                                   placeholder="Search for destination..."
                                                   value="{{ request('search') }}">
                                            <button type="submit" class="btn btn-primary rounded-pill">
                                                <i class="bi bi-search me-1"></i> Search
                                            </button>
                                        </form>
                                    </div>

                                    {{-- Table --}}
                                    <div id="printArea" class="table-responsive">
                                        <table class="table table-hover text-center align-middle mb-0">
                                            <thead class="table-dark">
                                                <tr>
                                                    <th>#</th>
                                                    <th>Name (EN)</th>
                                                    <th>Name (FR)</th>
                                                    <th>Name (DE)</th>

                                                    <th>Slug</th>
                                                    <th>Image</th>
                                                    <th>Added By</th>
                                                    <th colspan="3">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($destinations as $destination)
                                                    <tr class="hover-shadow">
                                                        <td class="fw-bold">{{ $loop->iteration }}</td>
                                                        <td>{{ $destination->name['en'] ?? 'N/A' }}</td>
                                                        <td>{{ $destination->name['fr'] ?? 'N/A' }}</td>
                                                        <td>{{ $destination->name['de'] ?? 'N/A' }}</td>
                                                        <td>{{ $destination->slug ?? 'N/A' }}</td>
                                                        <td>
                                                            @if($destination->image)
                                                                <img src="{{ $destination->image_url }}" alt="Destination Image"
                                                                     class="img-thumbnail shadow-sm rounded"
                                                                     style="width: 50px; height: 50px;">
                                                            @else
                                                                <span class="text-muted">No Image</span>
                                                            @endif
                                                        </td>
                                                        <td>{{ $destination->addedByUser->name ?? 'N/A' }}</td>
                                                        <td>
                                                            <a href="{{ route('destinations.show', $destination->id) }}" class="btn btn-info btn-sm rounded-pill">
                                                                <i class="bi bi-eye me-1"></i> View
                                                            </a>
                                                        </td>
                                                        <td>
                                                            <a href="{{ route('destinations.edit', $destination->id) }}" class="btn btn-warning btn-sm rounded-pill">
                                                                <i class="bi bi-pencil me-1"></i> Edit
                                                            </a>
                                                        </td>
                                                        <td>
                                                            <form action="{{ route('destinations.destroy', $destination->id) }}" method="POST" class="d-inline">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-danger btn-sm rounded-pill"
                                                                        onclick="return confirm('Are you sure you want to delete this destination?')">
                                                                    <i class="bi bi-trash me-1"></i> Delete
                                                                </button>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="9" class="text-center text-muted py-4">
                                                            <i class="bi bi-info-circle"></i> No destinations available.
                                                        </td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>

                                    {{-- Pagination --}}
                                    <div class="d-flex justify-content-center mt-4">
                                        {{ $destinations->links('pagination::bootstrap-5') }}
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                {{-- Custom Styles --}}
                <style>
                    .hover-shadow:hover {
                        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
                        transition: box-shadow 0.3s ease;
                    }
                    .card { border-radius: 15px; }
                    .card-header { border-radius: 15px 15px 0 0; }
                    .table th, .table td { vertical-align: middle; }
                </style>

                {{-- Print Script --}}
                <script>
                    function printTable() {
                        var printContents = document.getElementById('printArea').innerHTML;
                        var originalContents = document.body.innerHTML;

                        document.body.innerHTML = `
                            <html>
                            <head>
                                <title>Print Destinations List</title>
                                <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
                                <style>
                                    @media print {
                                        .no-print { display: none !important; }
                                        body {
                                            font-family: Arial, sans-serif;
                                            direction: rtl;
                                            text-align: center;
                                        }
                                        h3 {
                                            font-weight: bold;
                                            color: black;
                                            margin-bottom: 20px;
                                        }
                                        table {
                                            width: 100%;
                                            border-collapse: collapse;
                                            margin-top: 10px;
                                        }
                                        th, td {
                                            border: 1px solid #000;
                                            padding: 10px;
                                            text-align: center;
                                        }
                                        th {
                                            background-color: #343a40;
                                            color: white;
                                            font-size: 1.1rem;
                                            font-weight: bold;
                                        }
                                        td {
                                            font-size: 1rem;
                                            color: #333;
                                        }
                                        tr:nth-child(even) { background-color: #f8f9fa; }
                                    }
                                </style>
                            </head>
                            <body>
                                <h3>Destinations List</h3>
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
