<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends ApiFormRequest
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
            'email'=>'required|string|email|max:255',
            'password'=>'required|string|min:8',
        ];
    }

    
    public function messages(){
        return [
            'email.required'=> "Eyy care monda necesitas porner un name",
            'email.string'=> "Eyy care monda necesitas ser un texto",
            'email.max'=> "Eyy care monda necesitas ser un texto mas corto",
            'email.email'=> "Eyy care monda necesitas ser un email",
            'password.required'=> "Eyy care monda necesitas porner un name",
            'password.string'=> "Eyy care monda necesitas ser un texto",
            'password.min'=> "Eyy care monda necesitas ser un texto mas largo",
        ]; 
    }
}
