<?php

    <!-- Booking Modal -->
    <div
      class="modal fade modal-booking"
      id="bookingModal"
      tabindex="-1"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
          <div class="modal-header border-0">
            <h5 class="modal-title">Book — {{ $tour->getTranslatedTitle() }}</h5>
            <button
              type="button"
              class="btn-close"
              data-bs-dismiss="modal"
              aria-label="Close"
            ></button>
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
                    <h6 class="mb-0"><i class="fas fa-map-marker-alt me-2"></i>تفاصيل الرحلة</h6>
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
              <div class="col-12">
                <div class="card border-success mb-3">
                  <div class="card-header bg-success text-white">
                    <h6 class="mb-0"><i class="fas fa-gift me-2"></i>تفاصيل الباقة المختارة</h6>
                  </div>
                  <div class="card-body" id="packageDetails">
                    <div class="row">
                      <div class="col-md-6">
                        <label class="form-label fw-bold">اسم الباقة</label>
                        <input type="text" id="pkgLabel" class="form-control" readonly />
                      </div>
                      <div class="col-md-6">
                        <label class="form-label fw-bold">السعر الأساسي (جنيه لكل شخص)</label>
                        <input type="text" id="pkgPrice" class="form-control" readonly />
                      </div>
                      <div class="col-md-6">
                        <label class="form-label fw-bold">تاريخ البداية</label>
                        <input type="text" id="pkgStartDate" class="form-control" readonly />
                      </div>
                      <div class="col-md-6">
                        <label class="form-label fw-bold">تاريخ النهاية</label>
                        <input type="text" id="pkgEndDate" class="form-control" readonly />
                      </div>
                      <div class="col-md-6">
                        <label class="form-label fw-bold">نوع الإقامة</label>
                        <input type="text" id="pkgBoardType" class="form-control" readonly />
                      </div>
                      <div class="col-md-6">
                        <label class="form-label fw-bold">المواصلات</label>
                        <input type="text" id="pkgTransportation" class="form-control" readonly />
                      </div>
                      <div class="col-12">
                        <label class="form-label fw-bold">تفاصيل الباقة</label>
                        <textarea id="pkgDetails" class="form-control" rows="2" readonly></textarea>
                      </div>
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
                  required
                />
              </div>

              <div class="col-md-6">
                <label class="form-label">Check-out</label>
                <input type="date" id="dateTo" name="check_out_date" class="form-control" required />
              </div>

              <div class="col-md-4">
                <label class="form-label">Adults</label>
                <input
                  type="number"
                  id="adults"
                  name="adults"
                  class="form-control"
                  min="1"
                  value="2"
                  required
                />
              </div>

              <div class="col-md-4">
                <label class="form-label">Children</label>
                <input
                  type="number"
                  id="children"
                  name="children"
                  class="form-control"
                  min="0"
                  value="0"
                />
              </div>

              <div class="col-md-4">
                <label class="form-label">Room type</label>
                <select id="roomType" name="room_type" class="form-select">
                  <option value="standard" data-upgrade="0">Standard</option>
                  <option value="pool_sea" data-upgrade="400">
                    Pool/Sea View (+EGP 400/room/night)
                  </option>
                  <option value="sea_facing" data-upgrade="500">
                    Sea-Facing (+EGP 500/room/night)
                  </option>
                  <option value="superior" data-upgrade="700">
                    Superior (+EGP 700/room/night)
                  </option>
                </select>
              </div>

              <div class="col-12">
                <label class="form-label">Notes (special requests)</label>
                <textarea
                  id="notes"
                  name="special_requests"
                  class="form-control"
                  rows="2"
                  placeholder="Diet, accessibility, early check-in..."
                ></textarea>
              </div>

              <div class="col-md-6">
                <label class="form-label">Full name</label>
                <input
                  type="text"
                  id="custName"
                  name="customer_name"
                  class="form-control"
                  required
                />
              </div>

              <div class="col-md-6">
                <label class="form-label">Phone</label>
                <input
                  type="tel"
                  id="custPhone"
                  name="customer_phone"
                  class="form-control"
                  placeholder="+20..."
                  required
                />
              </div>

              <div class="col-12">
                <label class="form-label">Email (optional)</label>
                <input
                  type="email"
                  id="custEmail"
                  name="customer_email"
                  class="form-control"
                  placeholder="your@email.com"
                />
              </div>

              <!-- Booking Steps -->
              <div class="col-12" id="bookingSteps">
                <!-- Step 1: Customer Info -->
                <div class="step-section" id="step1" style="display: block;">
                  <div class="card border-warning mb-3">
                    <div class="card-header bg-warning text-dark">
                      <h6 class="mb-0"><i class="fas fa-user me-2"></i>الخطوة 1: معلومات العميل</h6>
                    </div>
                    <div class="card-body">
                      <div class="row">
                        <div class="col-md-6">
                          <label class="form-label">الاسم الكامل <span class="text-danger">*</span></label>
                          <input type="text" id="custName" name="customer_name" class="form-control" required />
                        </div>
                        <div class="col-md-6">
                          <label class="form-label">رقم الهاتف <span class="text-danger">*</span></label>
                          <input type="tel" id="custPhone" name="customer_phone" class="form-control" placeholder="+20..." required />
                        </div>
                        <div class="col-12 mt-2">
                          <label class="form-label">البريد الإلكتروني (اختياري)</label>
                          <input type="email" id="custEmail" name="customer_email" class="form-control" placeholder="your@email.com" />
                        </div>
                      </div>
                      <div class="text-end mt-3">
                        <button type="button" class="btn btn-primary" onclick="goToStep(2)">
                          التالي: اختيار طريقة الدفع <i class="fas fa-arrow-right ms-2"></i>
                        </button>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Step 2: Payment Method Selection -->
                <div class="step-section" id="step2" style="display: none;">
                  <div class="card border-info mb-3">
                    <div class="card-header bg-info text-white">
                      <h6 class="mb-0"><i class="fas fa-credit-card me-2"></i>الخطوة 2: اختيار طريقة الدفع</h6>
                    </div>
                    <div class="card-body">
                      <div class="row g-3">
                        <div class="col-md-6">
                          <div class="payment-option" onclick="selectPaymentType('ewallet')">
                            <div class="card h-100 border-2 payment-card" data-type="ewallet">
                              <div class="card-body text-center">
                                <i class="fas fa-wallet fa-3x text-primary mb-3"></i>
                                <h5>محفظة إلكترونية</h5>
                                <p class="text-muted">فودافون كاش، أورانج كاش، إتصالات كاش</p>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="payment-option" onclick="selectPaymentType('visa')">
                            <div class="card h-100 border-2 payment-card" data-type="visa">
                              <div class="card-body text-center">
                                <i class="fas fa-credit-card fa-3x text-success mb-3"></i>
                                <h5>فيزا / ماستركارد</h5>
                                <p class="text-muted">بطاقة ائتمان أو خصم</p>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="text-between mt-3 d-flex justify-content-between">
                        <button type="button" class="btn btn-outline-secondary" onclick="goToStep(1)">
                          <i class="fas fa-arrow-left me-2"></i>السابق
                        </button>
                        <button type="button" class="btn btn-primary" id="nextToStep3" onclick="goToStep(3)" style="display: none;">
                          التالي: تفاصيل الدفع <i class="fas fa-arrow-right ms-2"></i>
                        </button>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Step 3: Payment Details -->
                <div class="step-section" id="step3" style="display: none;">
                  <div class="card border-success mb-3">
                    <div class="card-header bg-success text-white">
                      <h6 class="mb-0"><i class="fas fa-money-bill me-2"></i>الخطوة 3: تفاصيل الدفع</h6>
                    </div>
                    <div class="card-body">
                      <!-- E-wallet Options -->
                      <div id="ewalletOptions" style="display: none;">
                        <h6 class="mb-3">اختر المحفظة الإلكترونية:</h6>
                        <div class="row g-2">
                          <div class="col-md-4">
                            <div class="form-check">
                              <input class="form-check-input" type="radio" name="ewallet_type" id="vodafoneCash" value="vodafone_cash">
                              <label class="form-check-label" for="vodafoneCash">
                                <i class="fas fa-mobile-alt me-2 text-danger"></i>فودافون كاش
                              </label>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-check">
                              <input class="form-check-input" type="radio" name="ewallet_type" id="orangeCash" value="orange_cash">
                              <label class="form-check-label" for="orangeCash">
                                <i class="fas fa-mobile-alt me-2 text-warning"></i>أورانج كاش
                              </label>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-check">
                              <input class="form-check-input" type="radio" name="ewallet_type" id="etisalatCash" value="etisalat_cash">
                              <label class="form-check-label" for="etisalatCash">
                                <i class="fas fa-mobile-alt me-2 text-success"></i>إتصالات كاش
                              </label>
                            </div>
                          </div>
                        </div>
                      </div>

                      <!-- Visa Options -->
                      <div id="visaOptions" style="display: none;">
                        <h6 class="mb-3">معلومات البطاقة:</h6>
                        <div class="alert alert-info">
                          <i class="fas fa-info-circle me-2"></i>
                          سيتم تحويلك لصفحة الدفع الآمنة لإدخال بيانات البطاقة
                        </div>
                      </div>

                      <!-- Payment Instructions -->
                      <div id="paymentInstructions" class="alert alert-primary" style="display: none;">
                        <h6 id="instructionTitle">تعليمات الدفع</h6>
                        <div id="instructionContent"></div>
                      </div>

                      <!-- Receipt Upload -->
                      <div id="receiptUploadSection" style="display: none;">
                        <hr>
                        <h6 class="mb-3">رفع إيصال الدفع:</h6>
                        <input type="file" class="form-control" id="receiptFile" name="receipt_image" accept="image/*">
                        <small class="text-muted">يرجى رفع صورة واضحة لإيصال الدفع</small>
                      </div>

                      <div class="text-between mt-3 d-flex justify-content-between">
                        <button type="button" class="btn btn-outline-secondary" onclick="goToStep(2)">
                          <i class="fas fa-arrow-left me-2"></i>السابق
                        </button>
                        <button type="button" class="btn btn-success" id="payNowBtn" onclick="processPayment()" style="display: none;">
                          <i class="fas fa-credit-card me-2"></i>ادفع الآن
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Summary -->
              <div class="col-12">
                <div
                  class="p-3 rounded-3"
                  style="background: #fbfeff; border: 1px solid #eef4f7"
                >
                  <div class="d-flex justify-content-between">
                    <div class="muted small">Nights</div>
                    <div id="nightsVal" class="text-primary-strong">1</div>
                  </div>
                  <div class="d-flex justify-content-between">
                    <div class="muted small">
                      Total people (adults + children chargeable)
                    </div>
                    <div id="peopleVal" class="text-primary-strong">2</div>
                  </div>
                  <hr />
                  <div
                    class="d-flex justify-content-between align-items-center"
                  >
                    <div>
                      <strong>Total</strong>
                      <div class="muted small">EGP (estimated)</div>
                    </div>
                    <div>
                      <strong id="totalVal" class="text-primary-strong"
                        >EGP 0</strong
                      >
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-12 text-end">
                <button
                  type="button"
                  class="btn btn-outline-secondary me-2"
                  data-bs-dismiss="modal"
                >
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



    ---------
  