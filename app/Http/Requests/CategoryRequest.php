<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        $id = $this->route('category');
        return [
            'name' => "required|string|min:3|max:255|unique:categories,name,$id",//this attribute (id) here for ignoring it.
            'parent_id' => 'nullable|int|exists:categories,id',
            'description' => 'nullable|string',
            'image' => 'image|mimes:*|min:1048576',
            'status' => 'required|in:active,archived',
        ];
    }

    public function messages()
    {
        // this function is for making a custom error messages.
        return [
            'unique' => 'This name Already been Taken!',
            'required' => 'This Field (:attribute) is Required!',
        ];
    }
}
