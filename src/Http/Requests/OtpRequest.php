<?php

namespace BenBjurstrom\Otpz\Http\Requests;

use BenBjurstrom\Otpz\Actions\AttemptOtp;
use BenBjurstrom\Otpz\Exceptions\OtpAttemptsException;
use BenBjurstrom\Otpz\Models\Concerns\Otpable;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class OtpRequest extends FormRequest
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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'code' => ['required', 'string', 'size:9'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $code = preg_replace('/[^0-9A-Z]/', '', strtoupper($this->code));
        $this->merge([
            'code' => $code,
        ]);
    }
}
