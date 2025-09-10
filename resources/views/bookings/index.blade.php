@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0 text-gray-800">Booking Management</h1>
                <a href="{{ route('bookings.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>New Booking
                </a>
            </div> -->

            <!-- Filters -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Search Filters</h6>
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ route('bookings.index') }}" class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label">Booking Reference</label>
                            <input type="text" name="booking_reference" class="form-control"
                                value="{{ request('booking_reference') }}" placeholder="BK-XXXXX">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Customer Name</label>
                            <input type="text" name="customer_name" class="form-control"
                                value="{{ request('customer_name') }}" placeholder="Customer Name">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Booking Status</label>
                            <select name="booking_status" class="form-select">
                                <option value="">All Statuses</option>
                                <option value="pending" {{ request('booking_status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="confirmed" {{ request('booking_status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                <option value="cancelled" {{ request('booking_status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                <option value="completed" {{ request('booking_status') == 'completed' ? 'selected' : '' }}>Completed</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Payment Status</label>
                            <select name="payment_status" class="form-select">
                                <option value="">All Statuses</option>
                                <option value="pending" {{ request('payment_status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="paid" {{ request('payment_status') == 'paid' ? 'selected' : '' }}>Paid</option>
                                <option value="refunded" {{ request('payment_status') == 'refunded' ? 'selected' : '' }}>Refunded</option>
                            </select>
                        </div>
                        <div class="col-md-2 d-flex align-items-end">
                            <button type="submit" class="btn btn-outline-primary me-2">
                                <i class="fas fa-search"></i> Search
                            </button>
                            <a href="{{ route('bookings.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times"></i> Clear
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Bookings Table -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Bookings List</h6>
                </div>
                <div class="card-body">
                    @if($bookings->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Booking Ref</th>
                                    <th>Customer</th>
                                    <th>Tour</th>
                                    <th>Check-in Date</th>
                                    <th>Total Amount</th>
                                    <th>Payment Method</th>
                                    <th>Booking Status</th>
                                    <th>Payment Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($bookings as $booking)
                                <tr>
                                    <td>
                                        <a href="{{ route('bookings.show', $booking->id) }}" class="text-primary fw-bold">
                                            {{ $booking->booking_reference }}
                                        </a>
                                    </td>
                                    <td>
                                        <div>{{ $booking->customer_name }}</div>
                                        <small class="text-muted">{{ $booking->customer_phone }}</small>
                                    </td>
                                    <td>
                                        <div>{{ $booking->tour->getTranslatedTitle() }}</div>
                                        <small class="text-muted">{{ $booking->ratePlan->getTranslatedName() }}</small>
                                    </td>
                                    <td>{{ $booking->check_in_date->format('Y-m-d') }}</td>
                                    <td>{{ $booking->formatted_total }}</td>
                                    <td>
                                        <span class="badge bg-info">{{ $booking->payment_method_label }}</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $booking->booking_status == 'confirmed' ? 'success' : ($booking->booking_status == 'cancelled' ? 'danger' : 'warning') }}">
                                            {{ $booking->booking_status_label }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $booking->payment_status == 'paid' ? 'success' : ($booking->payment_status == 'refunded' ? 'danger' : 'warning') }}">
                                            {{ $booking->payment_status_label }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <!-- View -->
                                            <a href="{{ route('bookings.show', $booking->id) }}"
                                                class="btn btn-sm btn-primary fw-semibold px-3 rounded-pill">
                                                View
                                            </a>

                                            <!-- Edit -->
                                            <!-- <a href="{{ route('bookings.edit', $booking->id) }}"
                                                class="btn btn-sm btn-warning fw-semibold px-3 rounded-pill text-white">
                                                تعديل
                                            </a> -->

                                            <!-- Confirm Booking -->
                                            @if($booking->booking_status == 'pending')
                                            <button type="button"
                                                class="btn btn-sm btn-success fw-semibold px-3 rounded-pill"
                                                onclick="updateBookingStatus({{ $booking->id }}, 'confirmed')">
                                                Confirm Booking
                                            </button>
                                            @endif

                                            <!-- Confirm Payment -->
                                            @if($booking->payment_status == 'pending' && $booking->receipt_image)
                                            <button type="button"
                                                class="btn btn-sm btn-success fw-semibold px-3 rounded-pill"
                                                onclick="updatePaymentStatus({{ $booking->id }}, 'paid')">
                                                Confirm Payment
                                            </button>
                                            @endif
                                        </div>
                                    </td>

                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-center">
                        {{ $bookings->appends(request()->query())->links() }}
                    </div>
                    @else
                    <div class="text-center py-4">
                        <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">No bookings found</h5>
                        <p class="text-muted">No bookings match your search criteria.</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Status Update Modals -->
<div class="modal fade" id="statusModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update Status</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p id="statusMessage"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="confirmStatusUpdate">Confirm</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    let currentBookingId = null;
    let currentAction = null;
    let currentStatus = null;

    function updateBookingStatus(bookingId, status) {
        currentBookingId = bookingId;
        currentAction = 'booking';
        currentStatus = status;

        const statusLabels = {
            'confirmed': 'Confirm Booking',
            'cancelled': 'Cancel Booking',
            'completed': 'Complete Booking'
        };

        document.getElementById('statusMessage').textContent =
            `Are you sure you want to ${statusLabels[status]}?`;

        new bootstrap.Modal(document.getElementById('statusModal')).show();
    }

    function updatePaymentStatus(bookingId, status) {
        currentBookingId = bookingId;
        currentAction = 'payment';
        currentStatus = status;

        const statusLabels = {
            'paid': 'Confirm Payment',
            'refunded': 'Refund Payment'
        };

        document.getElementById('statusMessage').textContent =
            `Are you sure you want to ${statusLabels[status]}?`;

        new bootstrap.Modal(document.getElementById('statusModal')).show();
    }

    document.getElementById('confirmStatusUpdate').addEventListener('click', function() {
        if (!currentBookingId || !currentAction || !currentStatus) return;

        const url = currentAction === 'booking' ?
            `/bookings/${currentBookingId}/update-status` :
            `/bookings/${currentBookingId}/update-payment-status`;

        fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({
                    status: currentStatus
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert('Error updating status: ' + (data.message || 'Please try again'));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error updating status');
            });

        bootstrap.Modal.getInstance(document.getElementById('statusModal')).hide();
    });
</script>
@endsection