<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\ResetsPasswords;
// use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Password;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    // Overridding this function from the trait to use the Alert
    protected function sendResetResponse(Request $request, $response)
    {
        if ($request->wantsJson()) {
            return new JsonResponse(['message' => trans($response)], 200);
        }
        Alert::success('Success!!!', 'Password Changed Successfully');

        return redirect($this->redirectPath())
                            ->with('status', trans($response));
    }

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;
}
