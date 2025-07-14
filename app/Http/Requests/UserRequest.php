<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use PhpParser\Node\Expr\FuncCall;

class UserRequest extends ApiFormRequest
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
            'name'=>'required|string|max:255',
            'email'=>'required|string|email|max:255|unique:users',
            'password'=>'required|string|min:8',

        ];
    }


    public function messages()
    {
        return [
            'name.required' => "Eyy care monda necesitas porner un name",
            'name.string' => "Eyy care monda necesitas ser un texto",
            'name.max' => "Eyy care monda necesitas ser un texto mas corto",
            'email.required' => "Eyy care monda necesitas porner un email", // Changed from 'name'
            'email.string' => "Eyy care monda necesitas ser un texto",
            'email.max' => "Eyy care monda necesitas ser un texto mas corto",
            'email.email' => "Eyy care monda necesitas ser un email válido",
            'email.unique' => "Eyy care monda necesitas ser un email único",
            'password.required' => "Eyy care monda necesitas porner una contraseña", // Changed from 'name'
            'password.string' => "Eyy care monda necesitas ser un texto",
            'password.min' => "Eyy care monda necesitas ser un texto mas largo",
        ];
}
}
