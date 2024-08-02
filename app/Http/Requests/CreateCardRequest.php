<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateCardRequest extends FormRequest
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
            "title"=> ['required'],
            "display_email"=> ['required', 'email'],
            "main_color"=> ['required'],
            "description"=> ['required']
        ];
    }
    protected function prepareForValidation(){
        $this->merge([
            'main_color' => $this->mainColor,
            'display_email' => $this->displayEmail,
            'image_url' => $this->imageUrl
        ]);
    }
}
