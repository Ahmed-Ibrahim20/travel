<!-- Toast Notifications Container -->
<div id="toastContainer" class="toast-container position-fixed top-0 start-0 p-3" style="z-index: 9999;">
</div>

<!-- Booking Modal Component -->
<div
    class="modal fade modal-booking"
    id="bookingModal"
    tabindex="-1"
    aria-hidden="true"
    data-tour-id="{{ $tour->id }}">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title">Book — {{ $tour->getTranslatedTitle() }}</h5>
                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>

            <form id="bookingForm" class="modal-body">
                <div class="row g-3">
                    <!-- Hidden fields for tour and rate plan -->
                    <input type="hidden" id="tourId" name="tour_id" value="{{ $tour->id }}">
                    <input type="hidden" id="ratePlanId" name="rate_plan_id">

                    <!-- Trip Details Section -->
                    <div class="col-12">
                        <div class="card border-primary mb-3">
                            <div class="card-header bg-primary text-white">
                                <h6 class="mb-0"><i class="fas fa-map-marker-alt me-2"></i>Trip Details</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-8">
                                        <h5 class="text-primary">{{ $tour->getTranslatedTitle() }}</h5>
                                        <p class="text-muted mb-2">{{ $tour->getTranslatedDescription() }}</p>
                                        <div class="d-flex align-items-center mb-2">
                                            <span class="badge bg-info me-2">{{ $tour->destination->getTranslatedName() }}</span>
                                            <div class="text-warning">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <i class="fas fa-star{{ $i <= $tour->rating ? '' : '-o' }}"></i>
                                                    @endfor
                                                    <span class="text-muted ms-1">({{ $tour->rating }}/5)</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 text-end">
                                        @if($tour->image_urls && count($tour->image_urls) > 0)
                                        <img src="{{ $tour->image_urls[0] }}" alt="{{ $tour->getTranslatedTitle() }}"
                                            class="img-fluid rounded" style="max-height: 80px;">
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Package Details Section -->
                    <div class="card border-success mb-3">
                        <div class="card-header bg-success text-white">
                            <h6 class="mb-0"><i class="fas fa-gift me-2"></i>Package Details</h6>
                        </div>
                        <div class="card-body">
                            <div class="row text-center">
                                <div class="col-md-4 mb-3">
                                    <h6 class="fw-bold text-muted">Package Name</h6>
                                    <p id="pkgLabel" class="text-dark fw-semibold">-</p>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <h6 class="fw-bold text-muted">Base Price</h6>
                                    <p id="pkgPrice" class="text-dark fw-semibold">-</p>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <h6 class="fw-bold text-muted">Board Type</h6>
                                    <p id="pkgBoardType" class="text-dark fw-semibold">-</p>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <h6 class="fw-bold text-muted">Start Date</h6>
                                    <p id="pkgStartDate" class="text-dark fw-semibold">-</p>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <h6 class="fw-bold text-muted">End Date</h6>
                                    <p id="pkgEndDate" class="text-dark fw-semibold">-</p>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <h6 class="fw-bold text-muted">Transportation</h6>
                                    <p id="pkgTransportation" class="text-dark fw-semibold">-</p>
                                </div>
                                <div class="col-12 mt-2">
                                    <h6 class="fw-bold text-muted">Details</h6>
                                    <p id="pkgDetails" class="text-dark small">-</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Check-in</label>
                        <input
                            type="date"
                            id="dateFrom"
                            name="check_in_date"
                            class="form-control"
                            min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                            required />
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Check-out</label>
                        <input type="date" id="dateTo" name="check_out_date" class="form-control" min="{{ date('Y-m-d', strtotime('+2 days')) }}" required />
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Children (≤2 free, >2 = +$10 per extra child per night)</label>
                        <input
                            type="number"
                            id="children"
                            name="children"
                            class="form-control"
                            min="0"
                            value="0" />
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Room type</label>
                        <select id="roomType" name="room_type" class="form-select">
                            <option value="standard" data-upgrade="0">Standard Room</option>
                        </select>
                    </div>

                    <!-- Hidden field for adults (always 2) -->
                    <input type="hidden" id="adults" name="adults" value="2" />

                    <div class="col-12">
                        <label class="form-label">Notes (special requests)</label>
                        <textarea
                            id="specialRequests"
                            name="special_requests"
                            class="form-control"
                            rows="2"
                            placeholder="Diet, accessibility, early check-in..."></textarea>
                    </div>


                    <!-- Booking Steps -->
                    <div class="col-12" id="bookingSteps">
                        <!-- Step 1: Customer Info -->
                        <div class="step-section" id="step1" style="display: block;">
                            <div class="card border-warning mb-3">
                                <div class="card-header bg-warning text-dark">
                                    <h6 class="mb-0"><i class="fas fa-user me-2"></i>Step 1: Customer Information</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label class="form-label">Full Name <span class="text-danger">*</span></label>
                                            <input type="text" id="custName" class="form-control" required />
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Phone Number <span class="text-danger">*</span></label>
                                            <input type="tel" id="custPhone" class="form-control" placeholder="+20..." required />
                                        </div>
                                        <div class="col-12 mt-2">
                                            <label class="form-label">Email (optional)</label>
                                            <input type="email" id="custEmail" class="form-control" placeholder="your@email.com" />
                                        </div>
                                    </div>
                                    <div class="text-end mt-3">
                                        <button type="button" class="btn btn-primary" onclick="goToStep(2)">
                                            Next: Choose Payment Method <i class="fas fa-arrow-right ms-2"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Step 2: Payment Method Selection -->
                        <div class="step-section" id="step2" style="display: none;">
                            <div class="card border-info mb-3">
                                <div class="card-header bg-info text-white">
                                    <h6 class="mb-0"><i class="fas fa-credit-card me-2"></i>Step 2: Choose Payment Method</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <div class="payment-option" onclick="selectPaymentType('bank_transfer')">
                                                <div class="card h-100 border-2 payment-card" data-type="bank_transfer">
                                                    <div class="card-body text-center">
                                                        <i class="fas fa-university fa-3x text-primary mb-3"></i>
                                                        <h5>Bank Transfer</h5>
                                                        <p class="text-muted">Direct bank account transfer</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="payment-option" onclick="selectPaymentType('instapay')">
                                                <div class="card h-100 border-2 payment-card" data-type="instapay">
                                                    <div class="card-body text-center">
                                                        <i class="fas fa-mobile-alt fa-3x text-success mb-3"></i>
                                                        <h5>InstaPay</h5>
                                                        <p class="text-muted">Instant mobile transfer</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-between mt-3 d-flex justify-content-between">
                                        <button type="button" class="btn btn-outline-secondary" onclick="goToStep(1)">
                                            <i class="fas fa-arrow-left me-2"></i>Previous
                                        </button>
                                        <button type="button" class="btn btn-primary" id="nextToStep3" onclick="goToStep(3)" style="display: none;">
                                            Next: Payment Details <i class="fas fa-arrow-right ms-2"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Step 3: Payment Details -->
                        <div class="step-section" id="step3" style="display: none;">
                            <div class="card border-success mb-3">
                                <div class="card-header bg-success text-white">
                                    <h6 class="mb-0"><i class="fas fa-money-bill me-2"></i>Step 3: Payment Details</h6>
                                </div>
                                <div class="card-body">
                                    <!-- Payment Options -->
                                    <div id="paymentOptions" style="display: none;">
                                        <div class="alert alert-warning">
                                            <i class="fas fa-info-circle me-2"></i>
                                            Please complete the payment using your selected method and upload the receipt below.
                                        </div>
                                    </div>

                                    <!-- Payment Instructions -->
                                    <div id="paymentInstructions" class="alert alert-primary" style="display: none;">
                                        <h6 id="instructionTitle">Payment Instructions</h6>
                                        <div id="instructionContent"></div>
                                    </div>

                                    <!-- Receipt Upload -->
                                    <div id="receiptUploadSection" style="display: none;">
                                        <hr>
                                        <h6 class="mb-3">Upload Payment Receipt:</h6>
                                        <input type="file" class="form-control" id="receiptUpload" name="receipt_image" accept="image/*">
                                        <small class="text-muted">Please upload a clear image of the payment receipt</small>
                                    </div>

                                    <div class="text-between mt-3 d-flex justify-content-between">
                                        <button type="button" class="btn btn-outline-secondary" onclick="goToStep(2)">
                                            <i class="fas fa-arrow-left me-2"></i>Previous
                                        </button>
                                        <!-- <button type="button" class="btn btn-success" id="payNowBtn" onclick="processPayment()" style="display: none;">
                                            <i class="fas fa-credit-card me-2"></i>Pay Now
                                        </button> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Summary -->
                    <div class="col-12">
                        <div
                            class="p-3 rounded-3"
                            style="background: #fbfeff; border: 1px solid #eef4f7">
                            <div class="d-flex justify-content-between">
                                <div class="muted small">Nights</div>
                                <div id="nightsVal" class="text-primary-strong">1</div>
                            </div>
                            <div class="d-flex justify-content-between">
                                <div class="muted small">
                                    Children
                                </div>
                                <div id="peopleVal" class="text-primary-strong">No children</div>
                            </div>
                            <hr />
                            <div
                                class="d-flex justify-content-between align-items-center">
                                <div>
                                    <strong>Total</strong>
                                    <div class="muted small">USD (estimated)</div>
                                </div>
                                <div>
                                    <strong id="totalVal" class="text-primary-strong">$0</strong>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 text-end">
                        <button
                            type="button"
                            class="btn btn-outline-secondary me-2"
                            data-bs-dismiss="modal">
                            Cancel
                        </button>
                        <button type="submit" class="btn btn-primary">
                            Complete Booking
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>