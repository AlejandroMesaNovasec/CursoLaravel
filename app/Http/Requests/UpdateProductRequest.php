<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
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
            'name'=> 'required|string|max:150',
            'description' => 'required|max:255',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:category,id'
        ];
    }

    public function messages()
    {
        return[
                'name.required'=> "Eyy care monda necesitas porner un name",
                'name.string'=> "Eyy care monda necesitas ser un texto",
                'description.string'=> "Eyy care monda necesitas ser un texto",
                'description.max'=> "Eyy care monda la descrption es mas corta",
                'price.numeric'=> "Eyy care monda necesitas el precio en numero bobolo"
            ];
    }
}
