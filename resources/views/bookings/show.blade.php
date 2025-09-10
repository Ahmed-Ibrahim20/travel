@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 mb-0 text-gray-800">Booking Details</h1>
                    <p class="text-muted">{{ $booking->booking_reference }}</p>
                </div>
                <div>
                    <a href="{{ route('bookings.index') }}" class="btn btn-outline-secondary me-2">
                        <i class="fas fa-arrow-left me-2"></i>Back to List
                    </a>
                    <!-- <a href="{{ route('bookings.edit', $booking->id) }}" class="btn btn-primary">
                        <i class="fas fa-edit me-2"></i>Edit Booking
                    </a> -->
                </div>
            </div>

            <div class="row">
                <!-- Booking Information -->
                <div class="col-lg-8">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Booking Information</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <h6 class="text-primary">Customer Information</h6>
                                    <table class="table table-borderless table-sm">
                                        <tr>
                                            <td class="fw-bold">Name:</td>
                                            <td>{{ $booking->customer_name }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Phone:</td>
                                            <td>{{ $booking->customer_phone }}</td>
                                        </tr>
                                        @if($booking->customer_email)
                                        <tr>
                                            <td class="fw-bold">Email:</td>
                                            <td>{{ $booking->customer_email }}</td>
                                        </tr>
                                        @endif
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <h6 class="text-primary">Tour Details</h6>
                                    <table class="table table-borderless table-sm">
                                        <tr>
                                            <td class="fw-bold">Tour:</td>
                                            <td>{{ $booking->tour->getTranslatedTitle() }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Package:</td>
                                            <td>{{ $booking->ratePlan->getTranslatedName() }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Check-in Date:</td>
                                            <td>{{ $booking->check_in_date->format('Y-m-d') }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Check-out Date:</td>
                                            <td>{{ $booking->check_out_date->format('Y-m-d') }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                            <hr>

                            <div class="row">
                                <div class="col-md-6">
                                    <h6 class="text-primary">Stay Details</h6>
                                    <table class="table table-borderless table-sm">
                                        <tr>
                                            <td class="fw-bold">Adults:</td>
                                            <td>{{ $booking->adults }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Children:</td>
                                            <td>{{ $booking->children }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Room Type:</td>
                                            <td>{{ ucfirst(str_replace('_', ' ', $booking->room_type)) }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Nights:</td>
                                            <td>{{ $booking->check_in_date->diffInDays($booking->check_out_date) }}</td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <h6 class="text-primary">Payment Information</h6>
                                    <table class="table table-borderless table-sm">
                                        <tr>
                                            <td class="fw-bold">Total Amount:</td>
                                            <td class="text-success fw-bold">{{ $booking->formatted_total }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Payment Method:</td>
                                            <td>
                                                <span class="badge bg-info">{{ $booking->payment_method_label }}</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Payment Status:</td>
                                            <td>
                                                <span class="badge bg-{{ $booking->payment_status == 'paid' ? 'success' : ($booking->payment_status == 'refunded' ? 'danger' : 'warning') }}">
                                                    {{ $booking->payment_status_label }}
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Booking Date:</td>
                                            <td>{{ $booking->created_at->format('Y-m-d H:i') }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                            @if($booking->special_requests)
                            <hr>
                            <div class="row">
                                <div class="col-12">
                                    <h6 class="text-primary">Special Requests</h6>
                                    <p class="text-muted">{{ $booking->special_requests }}</p>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Payment Receipt -->
                    @if($booking->receipt_image)
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Payment Receipt</h6>
                        </div>
                        <div class="card-body text-center">
                            <img src="{{ $booking->receipt_image }}" 
                                 alt="Payment Receipt" 
                                 class="img-fluid rounded shadow"
                                 style="max-height: 400px; cursor: pointer;"
                                 onclick="openImageModal(this.src)">
                            <p class="text-muted mt-2">Click on the image to view it in full size</p>
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Status and Actions -->
                <div class="col-lg-4">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Booking Status</h6>
                        </div>
                        <div class="card-body">
                            <div class="text-center mb-3">
                                <span class="badge bg-{{ $booking->booking_status == 'confirmed' ? 'success' : ($booking->booking_status == 'cancelled' ? 'danger' : 'warning') }} fs-6 p-2">
                                    {{ $booking->booking_status_label }}
                                </span>
                            </div>

                            @if($booking->booking_status == 'pending')
                            <div class="d-grid gap-2 mb-3">
                                <button type="button" class="btn btn-success" 
                                        onclick="updateBookingStatus({{ $booking->id }}, 'confirmed')">
                                    <i class="fas fa-check me-2"></i>Confirm Booking
                                </button>
                                <button type="button" class="btn btn-danger" 
                                        onclick="updateBookingStatus({{ $booking->id }}, 'cancelled')">
                                    <i class="fas fa-times me-2"></i>Cancel Booking
                                </button>
                            </div>
                            @endif

                            @if($booking->booking_status == 'confirmed')
                            <div class="d-grid gap-2 mb-3">
                                <button type="button" class="btn btn-primary" 
                                        onclick="updateBookingStatus({{ $booking->id }}, 'completed')">
                                    <i class="fas fa-flag-checkered me-2"></i>Complete Booking
                                </button>
                            </div>
                            @endif

                            @if($booking->payment_status == 'pending' && $booking->receipt_image)
                            <div class="d-grid gap-2 mb-3">
                                <button type="button" class="btn btn-success" 
                                        onclick="updatePaymentStatus({{ $booking->id }}, 'paid')">
                                    <i class="fas fa-dollar-sign me-2"></i>Confirm Payment
                                </button>
                            </div>
                            @endif

                            @if($booking->payment_status == 'paid')
                            <div class="d-grid gap-2 mb-3">
                                <button type="button" class="btn btn-warning" 
                                        onclick="updatePaymentStatus({{ $booking->id }}, 'refunded')">
                                    <i class="fas fa-undo me-2"></i>Refund Payment
                                </button>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Quick Info -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Quick Info</h6>
                        </div>
                        <div class="card-body">
                            <div class="row text-center">
                                <div class="col-6">
                                    <div class="border-end">
                                        <div class="h5 mb-0 text-primary">{{ $booking->adults + $booking->children }}</div>
                                        <small class="text-muted">Total People</small>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="h5 mb-0 text-primary">{{ $booking->check_in_date->diffInDays($booking->check_out_date) }}</div>
                                    <small class="text-muted">Total Nights</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Image Modal -->
<div class="modal fade" id="imageModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Payment Receipt</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <img id="modalImage" src="" alt="Payment Receipt" class="img-fluid">
            </div>
        </div>
    </div>
</div>

<!-- Status Update Modal -->
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

function openImageModal(src) {
    document.getElementById('modalImage').src = src;
    new bootstrap.Modal(document.getElementById('imageModal')).show();
}

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
    
    const url = currentAction === 'booking' 
        ? `/bookings/${currentBookingId}/update-status`
        : `/bookings/${currentBookingId}/update-payment-status`;
    
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
