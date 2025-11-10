<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $productoId = $this->route('producto') ? $this->route('producto')->id : null;

        return [
        'codigo' => 'required|string|max:255|unique:productos,codigo,' . $productoId,
        'nombre' => 'required|string|max:255',
        'categoria' => 'nullable|string|max:255',
        'stock' => 'required|integer|min:0',
        'precio' => 'required|numeric|min:0.01',
    ];
    }
}
