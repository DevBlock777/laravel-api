<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
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
            "title" => "required|string|min:2",
            "body" => "required|string|min:2",
        ];
    }

    public function messages(){
        return[
            "title" => "Le titre est requis",
            "title.string" => "Le titre doit etre une chaine de caracteres",
            "title.min" => "Le titre doit contenir au moins :min caracteres",
            "body"=> "Body est requis",
            "body.string" => "Body doit etre une chaine de caracteres",
            "body.min" => "Body doit contenir au moins :min caracteres",
        ];
    }
}
