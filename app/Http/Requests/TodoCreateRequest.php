<?php
declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TodoCreateRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => ['required', 'max:255'],
            'note' => ['sometimes', 'nullable', 'string', 'max:255'],
        ];
    }

    public function authorize()
    {
        return true;
    }
}
