<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InvitationRequest extends FormRequest
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
        return [
            'user_id' => 'required|exists:users,id', // Receiver's user ID
            'sender_id' => 'required|exists:users,id', // Sender's user ID
            'conversation_id' => 'required|exists:conversations,id', // Conversation ID
            'status' => 'required|in:pending,accepted,declined',
        ];
    }

    public function messages(): array
    {
        return [
            'user_id.required' => 'User ID is required.',
            'sender_id.required' => 'Sender ID is required.',
            'conversation_id.required' => 'Conversation ID is required.',
            'status.in' => 'Status must be one of the following: pending, accepted, declined.',
        ];
    }
}
