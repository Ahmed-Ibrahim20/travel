<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'tour_id' => 'required|exists:tours,id',
            'rate_plan_id' => 'required|exists:rate_plans,id',
            
            // Customer Information
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20|regex:/^[0-9+\-\s()]+$/',
            'customer_email' => 'nullable|email|max:255',
            
            // Booking Details
            'check_in_date' => 'required|date|after:today',
            'check_out_date' => 'required|date|after:check_in_date',
            'adults' => 'required|integer|min:1|max:20',
            'children' => 'nullable|integer|min:0|max:20',
            'room_type' => 'required|string|in:standard,pool_sea,sea_facing,superior',
            'special_requests' => 'nullable|string|max:1000',
            
            // Payment Information
            'payment_method' => 'required|string|in:bank_transfer,vodafone_cash,instapay',
            'payment_reference' => 'nullable|string|max:255',
        ];
    }

    /**
     * Get custom validation messages
     */
    public function messages(): array
    {
        return [
            'tour_id.required' => 'يجب اختيار الرحلة',
            'tour_id.exists' => 'الرحلة المختارة غير موجودة',
            'rate_plan_id.required' => 'يجب اختيار خطة السعر',
            'rate_plan_id.exists' => 'خطة السعر المختارة غير موجودة',
            
            'customer_name.required' => 'الاسم مطلوب',
            'customer_name.max' => 'الاسم لا يجب أن يزيد عن 255 حرف',
            'customer_phone.required' => 'رقم الهاتف مطلوب',
            'customer_phone.regex' => 'رقم الهاتف غير صحيح',
            'customer_email.email' => 'البريد الإلكتروني غير صحيح',
            
            'check_in_date.required' => 'تاريخ الوصول مطلوب',
            'check_in_date.after' => 'تاريخ الوصول يجب أن يكون بعد اليوم',
            'check_out_date.required' => 'تاريخ المغادرة مطلوب',
            'check_out_date.after' => 'تاريخ المغادرة يجب أن يكون بعد تاريخ الوصول',
            'adults.required' => 'عدد البالغين مطلوب',
            'adults.min' => 'يجب أن يكون هناك بالغ واحد على الأقل',
            'adults.max' => 'عدد البالغين لا يجب أن يزيد عن 20',
            'children.max' => 'عدد الأطفال لا يجب أن يزيد عن 20',
            'room_type.required' => 'نوع الغرفة مطلوب',
            'room_type.in' => 'نوع الغرفة غير صحيح',
            
            'payment_method.required' => 'طريقة الدفع مطلوبة',
            'payment_method.in' => 'طريقة الدفع غير صحيحة',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'tour_id' => 'الرحلة',
            'rate_plan_id' => 'خطة السعر',
            'customer_name' => 'اسم العميل',
            'customer_phone' => 'رقم الهاتف',
            'customer_email' => 'البريد الإلكتروني',
            'check_in_date' => 'تاريخ الوصول',
            'check_out_date' => 'تاريخ المغادرة',
            'adults' => 'عدد البالغين',
            'children' => 'عدد الأطفال',
            'room_type' => 'نوع الغرفة',
            'special_requests' => 'طلبات خاصة',
            'payment_method' => 'طريقة الدفع',
            'payment_reference' => 'مرجع الدفع',
        ];
    }
}
