<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use App\Services\JshshirService;

class UserEntryRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'my_jshshir' => [
                'required',
                'string',
                'digits:14',
                'different:partner_jshshir',
                function ($attribute, $value, $fail) {
                    $jshshirService = new JshshirService();
                    
                    if (!$jshshirService->validateJshshir($value)) {
                        $fail('JSHSHIR noto\'g\'ri formatda yoki noto\'g\'ri tekshirish raqamiga ega.');
                    }
                },
            ],
            'partner_jshshir' => [
                'required',
                'string',
                'digits:14',
                'different:my_jshshir',
                function ($attribute, $value, $fail) {
                    $jshshirService = new JshshirService();
                    
                    if (!$jshshirService->validateJshshir($value)) {
                        $fail('Sherikning JSHSHIRi noto\'g\'ri formatda yoki noto\'g\'ri tekshirish raqamiga ega.');
                    }
                },
            ],
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'my_jshshir.required' => 'Sizning JSHSHIRingizni kiriting.',
            'my_jshshir.digits' => 'JSHSHIR 14 ta raqamdan iborat bo\'lishi kerak.',
            'my_jshshir.different' => 'Sizning JSHSHIRingiz va sherigingizning JSHSHIRi bir xil bo\'lmasligi kerak.',
            'partner_jshshir.required' => 'Sherigingizning JSHSHIRini kiriting.',
            'partner_jshshir.digits' => 'Sherigingizning JSHSHIRi 14 ta raqamdan iborat bo\'lishi kerak.',
            'partner_jshshir.different' => 'Sherigingizning JSHSHIRi va sizning JSHSHIRingiz bir xil bo\'lmasligi kerak.',
        ];
    }

    /**
     * Configure the validator instance.
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $jshshirService = new JshshirService();
            $myJshshir = $this->input('my_jshshir');
            $partnerJshshir = $this->input('partner_jshshir');

            // Check if active session already exists
            if ($myJshshir && $partnerJshshir && $jshshirService->hasActiveSession($myJshshir, $partnerJshshir)) {
                $validator->errors()->add('partner_jshshir', 'Ushbu juftlik allaqachon ro\'yxatdan o\'tgan.');
            }
        });
    }
}
