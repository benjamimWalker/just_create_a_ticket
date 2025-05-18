<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTicketStatusRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'status' => ['required', 'boolean']
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
