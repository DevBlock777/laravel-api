<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class GeneratePromptRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'image' => [
                'required', 
                'image', 
                "file",
                "mimes:png,jpg,jpeg,gif,svg",
                'max:10240', //10MB
                "dimensions:min_width=100,min_height=100,max_width=5000,max_height=5000",

                ]
        ];
    }

    public function messages(): array
    {
        return [
            "image.required" => "Please upload an image.",
            "image.image" => "The uploaded file must be an image.",
            "image.file" => "The uploaded file must be a valid file.",
            "image.mimes" => "The uploaded image must be in one of the following formats: png, jpg, jpeg, gif, svg.",
            "image.max" => "The uploaded image must not exceed 10MB in size.",
            "image.dimensions" => "The uploaded image dimensions must be between 100x100 and 5000x5000 pixels."
        ];
    }
}
