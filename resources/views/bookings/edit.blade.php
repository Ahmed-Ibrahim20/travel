@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 mb-0 text-gray-800">تعديل الحجز</h1>
                    <p class="text-muted">{{ $booking->booking_reference }}</p>
                </div>
                <a href="{{ route('bookings.show', $booking->id) }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>العودة لتفاصيل الحجز
                </a>
            </div>

            <form action="{{ route('bookings.update', $booking->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <div class="col-lg-8">
                        <!-- Customer Information -->
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">معلومات العميل</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">اسم العميل <span class="text-danger">*</span></label>
                                            <input type="text" name="customer_name" class="form-control @error('customer_name') is-invalid @enderror" 
                                                   value="{{ old('customer_name', $booking->customer_name) }}" required>
                                            @error('customer_name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">رقم الهاتف <span class="text-danger">*</span></label>
                                            <input type="tel" name="customer_phone" class="form-control @error('customer_phone') is-invalid @enderror" 
                                                   value="{{ old('customer_phone', $booking->customer_phone) }}" required>
                                            @error('customer_phone')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="mb-3">
                                            <label class="form-label">البريد الإلكتروني</label>
                                            <input type="email" name="customer_email" class="form-control @error('customer_email') is-invalid @enderror" 
                                                   value="{{ old('customer_email', $booking->customer_email) }}">
                                            @error('customer_email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Booking Details -->
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">تفاصيل الحجز</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">تاريخ الوصول <span class="text-danger">*</span></label>
                                            <input type="date" name="check_in_date" class="form-control @error('check_in_date') is-invalid @enderror" 
                                                   value="{{ old('check_in_date', $booking->check_in_date->format('Y-m-d')) }}" required>
                                            @error('check_in_date')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">تاريخ المغادرة <span class="text-danger">*</span></label>
                                            <input type="date" name="check_out_date" class="form-control @error('check_out_date') is-invalid @enderror" 
                                                   value="{{ old('check_out_date', $booking->check_out_date->format('Y-m-d')) }}" required>
                                            @error('check_out_date')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label">عدد البالغين <span class="text-danger">*</span></label>
                                            <input type="number" name="adults" min="1" class="form-control @error('adults') is-invalid @enderror" 
                                                   value="{{ old('adults', $booking->adults) }}" required>
                                            @error('adults')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label">عدد الأطفال</label>
                                            <input type="number" name="children" min="0" class="form-control @error('children') is-invalid @enderror" 
                                                   value="{{ old('children', $booking->children) }}">
                                            @error('children')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label">نوع الغرفة</label>
                                            <select name="room_type" class="form-select @error('room_type') is-invalid @enderror">
                                                <option value="standard" {{ old('room_type', $booking->room_type) == 'standard' ? 'selected' : '' }}>Standard</option>
                                                <option value="pool_sea" {{ old('room_type', $booking->room_type) == 'pool_sea' ? 'selected' : '' }}>Pool/Sea View</option>
                                                <option value="sea_facing" {{ old('room_type', $booking->room_type) == 'sea_facing' ? 'selected' : '' }}>Sea-Facing</option>
                                                <option value="superior" {{ old('room_type', $booking->room_type) == 'superior' ? 'selected' : '' }}>Superior</option>
                                            </select>
                                            @error('room_type')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="mb-3">
                                            <label class="form-label">الطلبات الخاصة</label>
                                            <textarea name="special_requests" rows="3" class="form-control @error('special_requests') is-invalid @enderror">{{ old('special_requests', $booking->special_requests) }}</textarea>
                                            @error('special_requests')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Payment Information -->
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">معلومات الدفع</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">المبلغ الإجمالي <span class="text-danger">*</span></label>
                                            <input type="number" name="total_amount" step="0.01" class="form-control @error('total_amount') is-invalid @enderror" 
                                                   value="{{ old('total_amount', $booking->total_amount) }}" required>
                                            @error('total_amount')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">طريقة الدفع</label>
                                            <select name="payment_method" class="form-select @error('payment_method') is-invalid @enderror">
                                                <option value="bank_transfer" {{ old('payment_method', $booking->payment_method) == 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                                                <option value="vodafone_cash" {{ old('payment_method', $booking->payment_method) == 'vodafone_cash' ? 'selected' : '' }}>Vodafone Cash</option>
                                                <option value="instapay" {{ old('payment_method', $booking->payment_method) == 'instapay' ? 'selected' : '' }}>InstaPay</option>
                                            </select>
                                            @error('payment_method')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="mb-3">
                                            <label class="form-label">إيصال الدفع</label>
                                            @if($booking->receipt_image)
                                                <div class="mb-2">
                                                    <img src="{{ Storage::url($booking->receipt_image) }}" alt="Current Receipt" 
                                                         class="img-thumbnail" style="max-height: 100px;">
                                                    <p class="text-muted small">الإيصال الحالي</p>
                                                </div>
                                            @endif
                                            <input type="file" name="receipt_image" accept="image/*" class="form-control @error('receipt_image') is-invalid @enderror">
                                            <small class="text-muted">اترك فارغاً للاحتفاظ بالإيصال الحالي</small>
                                            @error('receipt_image')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Status and Actions -->
                    <div class="col-lg-4">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">حالة الحجز</h6>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label class="form-label">حالة الحجز</label>
                                    <select name="booking_status" class="form-select @error('booking_status') is-invalid @enderror">
                                        <option value="pending" {{ old('booking_status', $booking->booking_status) == 'pending' ? 'selected' : '' }}>قيد الانتظار</option>
                                        <option value="confirmed" {{ old('booking_status', $booking->booking_status) == 'confirmed' ? 'selected' : '' }}>مؤكد</option>
                                        <option value="cancelled" {{ old('booking_status', $booking->booking_status) == 'cancelled' ? 'selected' : '' }}>ملغي</option>
                                        <option value="completed" {{ old('booking_status', $booking->booking_status) == 'completed' ? 'selected' : '' }}>مكتمل</option>
                                    </select>
                                    @error('booking_status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">حالة الدفع</label>
                                    <select name="payment_status" class="form-select @error('payment_status') is-invalid @enderror">
                                        <option value="pending" {{ old('payment_status', $booking->payment_status) == 'pending' ? 'selected' : '' }}>قيد الانتظار</option>
                                        <option value="paid" {{ old('payment_status', $booking->payment_status) == 'paid' ? 'selected' : '' }}>مدفوع</option>
                                        <option value="refunded" {{ old('payment_status', $booking->payment_status) == 'refunded' ? 'selected' : '' }}>مسترد</option>
                                    </select>
                                    @error('payment_status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Tour Information (Read-only) -->
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">معلومات الرحلة</h6>
                            </div>
                            <div class="card-body">
                                <div class="mb-2">
                                    <strong>الرحلة:</strong>
                                    <p class="text-muted">{{ $booking->tour->getTranslatedTitle() }}</p>
                                </div>
                                <div class="mb-2">
                                    <strong>الباقة:</strong>
                                    <p class="text-muted">{{ $booking->ratePlan->getTranslatedName() }}</p>
                                </div>
                                <div class="mb-2">
                                    <strong>رقم الحجز:</strong>
                                    <p class="text-muted">{{ $booking->booking_reference }}</p>
                                </div>
                                <div class="mb-2">
                                    <strong>تاريخ الإنشاء:</strong>
                                    <p class="text-muted">{{ $booking->created_at->format('Y-m-d H:i') }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="card shadow mb-4">
                            <div class="card-body">
                                <div class="d-grid gap-2">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-2"></i>حفظ التغييرات
                                    </button>
                                    <a href="{{ route('bookings.show', $booking->id) }}" class="btn btn-outline-secondary">
                                        <i class="fas fa-times me-2"></i>إلغاء
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
