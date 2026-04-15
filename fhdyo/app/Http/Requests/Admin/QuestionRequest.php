<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class QuestionRequest extends FormRequest
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
        // Debug: Check what we're getting
        $questionId = null;
        if ($this->question instanceof \App\Models\Question) {
            $questionId = $this->question->id;
        } elseif (is_numeric($this->question)) {
            $questionId = $this->question;
        } elseif (request()->route('question')) {
            $questionId = request()->route('question')->id;
        }
        
        return [
            'unit_id' => 'required|exists:units,id',
            'question' => 'required|string|max:1000|unique:questions,question,' . $questionId . ',id',
            'is_critical' => 'required|boolean',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'unit_id.required' => 'Bo\'lim tanlanishi shart.',
            'unit_id.exists' => 'Tanlangan bo\'lim mavjud emas.',
            'question.required' => 'Savol matni kiritilishi shart.',
            'question.unique' => 'Bu savol allaqachon mavjud.',
            'question.max' => 'Savol matni 1000 ta belgidan oshmasligi kerak.',
            'is_critical.required' => 'Muhimlik holati belgilanishi shart.',
            'is_critical.boolean' => 'Muhimlik holati faqat true yoki false bo\'lishi mumkin.',
        ];
    }
}
