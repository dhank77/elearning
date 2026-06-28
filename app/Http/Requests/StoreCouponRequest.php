<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Validation\Rule;

class StoreCouponRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->role === 'teacher';
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'course_id' => ['required', Rule::exists('courses', 'id')->where('teacher_id', $this->user()->id)],
            'code' => ['required', 'string', 'max:255', 'unique:coupons,code'],
            'discount_percentage' => ['required', 'numeric', 'min:0', 'max:100'],
            'description' => ['nullable', 'string'],
            'is_active' => ['nullable', 'boolean'],
            'expires_at' => ['nullable', 'date'],
        ];
    }
}
