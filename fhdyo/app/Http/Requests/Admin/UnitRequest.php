<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UnitRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Placeholder - implement admin authorization
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255|unique:units,name,' . $this->unit?->id,
            'description' => 'nullable|string|max:1000',
            'category' => 'required|in:ajrim,nikoh',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Bo\'lim nomi kiritilishi shart.',
            'name.unique' => 'Bu nomdagi bo\'lim allaqachon mavjud.',
            'name.max' => 'Bo\'lim nomi 255 ta belgidan oshmasligi kerak.',
            'description.max' => 'Tavsif 1000 ta belgidan oshmasligi kerak.',
            'category.required' => 'Kategoriya tanlanishi shart.',
            'category.in' => 'Kategoriya faqat "ajrim" yoki "nikoh" bo\'lishi mumkin.',
        ];
    }
}
