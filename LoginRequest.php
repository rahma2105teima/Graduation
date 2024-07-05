<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use App\Models\Owner;
use App\Models\Admin;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ];
    }

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function authenticate()
    {
        $credentials = $this->only('email', 'password');

        try {
            // Attempt user authentication
            if (Auth::guard('web')->attempt($credentials, $this->filled('remember'))) {
                $user = Auth::guard('web')->user();
                Log::info('User authentication success');
                return response()->json([
                    'success' => true,
                    'message' => 'Success you are logged in as user',
                    'user' => $user
                ]);
            }

            // Attempt owner authentication
            $owner = Owner::where('email', $credentials['email'])->first();
            if ($owner && Hash::check($credentials['password'], $owner->password)) {
                Auth::guard('owner')->login($owner);
                $user = Auth::guard('owner')->user();
                Log::info('Owner authentication success');
                return response()->json([
                    'success' => true,
                    'message' => 'Success you are logged in as owner',
                    'user' => $user
                ]);
            }

            // Attempt admin authentication
            if (Auth::guard('admin')->attempt($credentials)) {
                $admin = Admin::where('email', $credentials['email'])->first();
                if ($admin && Hash::check($credentials['password'], $admin->password)) {
                    Auth::guard('admin')->login($admin);
                    $user = Auth::guard('admin')->user();
                    Log::info('Admin authentication success');
                    return response()->json([
                        'success' => true,
                        'message' => 'Success you are logged in as admin',
                        'user' => $user
                    ]);
                }
            }

            // Authentication failed
            Log::info('Authentication failed');
            throw ValidationException::withMessages([
                'email' => 'Invalid credentials.',
            ]);
        } catch (\Exception $e) {
            Log::error('Authentication error: ' . $e->getMessage());
            throw $e; // Rethrow the exception for global error handling
        }
    }
}
