<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TicketRequest extends FormRequest
{
    public function rules()
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'status' => ['required', 'boolean'],
            'priority' => ['required', 'required', 'integer'],
        ];
    }

    public function authorize()
    {
        return true;
    }
}
