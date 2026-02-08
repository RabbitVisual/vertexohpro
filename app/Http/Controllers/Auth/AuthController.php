<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;

class AuthController extends Controller
{
    /**
     * Show the login form.
     */
    public function showLoginForm()
    {
        return view('vertexhomepage::auth.login');
    }

    /**
     * Handle the login request.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required_without:cpf|email|nullable',
            'cpf' => 'required_without:email|string|nullable',
            'password' => 'required|string',
        ]);

        $remember = $request->boolean('remember');
        $loginField = $request->has('email') && $request->email ? 'email' : 'cpf';
        $loginValue = $request->input($loginField);

        // Clean CPF if necessary
        if ($loginField === 'cpf') {
            $loginValue = preg_replace('/\D/', '', $loginValue);
        }

        if (Auth::attempt([$loginField => $loginValue, 'password' => $request->password], $remember)) {
            $request->session()->regenerate();

            // Update user tracking
            $user = Auth::user();
            $user->update([
                'last_login_at' => Carbon::now(),
                'last_login_ip' => $request->ip(),
            ]);

            // Role-based redirection
            if ($user->hasRole('admin')) {
                return redirect()->intended(route('admin.dashboard'))->with('success', 'Bem-vindo ao Painel Administrativo, ' . $user->first_name . '!');
            }

            return redirect()->intended(route('teacherpanel.index'))->with('success', 'Bem-vindo de volta, ' . $user->first_name . '!');
        }

        throw ValidationException::withMessages([
            ($loginField === 'email' ? 'email' : 'cpf') => [__('auth.failed')],
        ]);
    }

    /**
     * Show the registration form.
     */
    public function showRegistrationForm()
    {
        return view('vertexhomepage::auth.register');
    }

    /**
     * Handle the registration request.
     */
    public function register(Request $request)
    {
        $data = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'cpf' => 'required|string|unique:users',
            'phone' => 'required|string',
            'birth_date' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Clean values
        $cpf = preg_replace('/\D/', '', $data['cpf']);
        $phone = preg_replace('/\D/', '', $data['phone']);

        try {
            $birthDate = Carbon::createFromFormat('d/m/Y', $data['birth_date'])->format('Y-m-d');
        } catch (\Exception $e) {
            throw ValidationException::withMessages(['birth_date' => 'Data de nascimento inválida.']);
        }

        $user = User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'cpf' => $cpf,
            'phone' => $phone,
            'birth_date' => $birthDate,
            'password' => Hash::make($data['password']),
            'status' => 'active', // Default status
            'membership' => 'free', // Default membership
            'theme' => 'light', // Default theme
        ]);

        // Assign default role if needed (spatie/laravel-permission)
        // $user->assignRole('user');

        Auth::login($user);

        // Role-based redirection (default for new users is usually teacher/user)
        if ($user->hasRole('admin')) {
            return redirect(route('admin.dashboard'))->with('success', 'Conta criada com sucesso! Bem-vindo ao Painel Administrativo.');
        }

        return redirect(route('teacherpanel.index'))->with('success', 'Conta criada com sucesso! Bem-vindo ao Vertex Oh Pro!');
    }

    /**
     * Handle the logout request.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('info', 'Sessão encerrada com sucesso.');
    }

    /**
     * Passwords reset methods (Basic implementation for UI)
     */
    public function showForgotPasswordForm()
    {
        return view('vertexhomepage::auth.forgot-password');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);
        // Simplified for this overhaul, usually uses Password Broker
        return back()->with('status', 'Se o e-mail existir em nossa base, um link de recuperação será enviado.');
    }

    public function showResetPasswordForm(Request $request, $token)
    {
        return view('vertexhomepage::auth.reset-password', ['request' => $request, 'token' => $token]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Simplified reset logic
        return redirect()->route('login')->with('success', 'Senha redefinida com sucesso! Faça login com sua nova senha.');
    }
}
