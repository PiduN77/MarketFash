<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\OTPService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class OTPController extends Controller
{
    public function showVerifyForm()
    {
        return view('auth.verify');
    }

    public function verify(Request $request, OTPService $otpService)
    {
        $request->validate([
            'otp.*' => 'required|integer|min:0|max:9',
        ]);

        $user = Auth::user();
        $otpArray = $request->input('otp');
        $otpString = implode('', $otpArray);


        if (!is_numeric($otpString) || strlen($otpString) != 6) {
            return back()->withErrors(['otp' => 'Invalid OTP format.']);
        }

        $otp = (int) $otpString;

        if ($otpService->verifyOTP($user, $otp)) {
            if ($user->email_verified_at == null) {
                $user->email_verified_at = Carbon::now();
                $user->save();

                return redirect()->route('index')->with('status', 'Email successfully verified!');
            } else {
                return redirect()->route('seller.IDCard')->with('status', 'Email successfully verified!');
            }
        }

        return back()->withErrors(['otp' => 'Invalid OTP. Please try again.']);
    }
}
