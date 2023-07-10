<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use App\Exceptions\OnboardingException;

class CanEditOnboarding
{
    /**
     * Handle an incoming request.
     *
     */
    public function handle(Request $request, Closure $next): Response
    {
        throw_if(Auth::user()->finishedOnboarding, OnboardingException::notAuthorized());

        return $next($request);
    }
}
