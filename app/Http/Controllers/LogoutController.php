<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\StatefulGuard;
use Laravel\Fortify\Contracts\LogoutResponse;

class LogoutController extends Controller
{
    public $guard;
    public function __construct(StatefulGuard $guard)
    {
        $this->guard = $guard;
    }
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $this->guard->logout();

        //$request->session()->invalidate();

        //$request->session()->regenerateToken();

        return app(LogoutResponse::class);
    }
}
