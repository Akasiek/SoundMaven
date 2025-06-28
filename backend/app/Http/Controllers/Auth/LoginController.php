<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\LoginRequest;
use Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class LoginController
{
    public function displayLoginForm(Request $request): Response
    {
        $lastVisitedPage = parse_url(url()->previous('/'), PHP_URL_HOST) === request()->getHost()
            ? url()->previous('/')
            : '/';

        if ($request->session()->has('url.intended')) {
            $request->session()->put('url.intended', $lastVisitedPage);
        }

        return Inertia::render('auth/Login', ['status' => $request->session()->get('status')]);
    }

    public function login(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        return redirect()->intended();
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->back();
    }
}
