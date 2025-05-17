<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReplyRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'message' => ['required'],
            'ticket_id' => ['required', 'exists:tickets,id'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
