<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\PasswordResetOtp;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class OtpPasswordResetController extends Controller
{
    /**
     * Show forgot password form (enter email)
     */
    public function showForgotForm()
    {
        return view('auth.passwords.otp-email');
    }

    /**
     * Send OTP to email
     */
    public function sendOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ], [
            'email.exists' => 'No account found with this email address.',
        ]);

        // Invalidate previous OTPs
        PasswordResetOtp::where('email', $request->email)->update(['is_used' => true]);

        // Generate 6-digit OTP
        $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        // Store OTP (valid for 10 minutes)
        PasswordResetOtp::create([
            'email' => $request->email,
            'otp' => $otp,
            'expires_at' => Carbon::now()->addMinutes(10),
        ]);

        // Send OTP email
        $user = User::where('email', $request->email)->first();
        Mail::send([], [], function ($message) use ($request, $otp, $user) {
            $message->to($request->email)
                    ->subject('EMS - Password Reset OTP')
                    ->html("
                        <div style='font-family:Inter,Arial,sans-serif;max-width:480px;margin:0 auto;'>
                            <div style='background:linear-gradient(135deg,#6366f1,#8b5cf6);padding:32px;border-radius:16px 16px 0 0;text-align:center;'>
                                <h1 style='color:#fff;margin:0;font-size:24px;'>🔐 Password Reset</h1>
                            </div>
                            <div style='background:#fff;padding:32px;border:1px solid #e5e7eb;border-top:none;border-radius:0 0 16px 16px;'>
                                <p style='color:#374151;font-size:15px;'>Hi <strong>{$user->name}</strong>,</p>
                                <p style='color:#6b7280;font-size:14px;'>Use this OTP to reset your password. It's valid for <strong>10 minutes</strong>.</p>
                                <div style='background:#f8fafc;border:2px dashed #6366f1;border-radius:12px;padding:20px;text-align:center;margin:24px 0;'>
                                    <span style='font-size:36px;font-weight:800;letter-spacing:8px;color:#6366f1;font-family:monospace;'>{$otp}</span>
                                </div>
                                <p style='color:#9ca3af;font-size:12px;text-align:center;'>If you didn't request this, please ignore this email.</p>
                            </div>
                            <p style='text-align:center;color:#9ca3af;font-size:11px;margin-top:16px;'>© " . date('Y') . " EMS Portal</p>
                        </div>
                    ");
        });

        return redirect()->route('password.otp.verify.form', ['email' => $request->email])
                         ->with('success', 'OTP sent to your email! Check your inbox.');
    }

    /**
     * Show OTP verification form
     */
    public function showVerifyForm(Request $request)
    {
        return view('auth.passwords.otp-verify', ['email' => $request->email]);
    }

    /**
     * Verify OTP
     */
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required|string|size:6',
        ]);

        $otpRecord = PasswordResetOtp::where('email', $request->email)
            ->where('otp', $request->otp)
            ->where('is_used', false)
            ->where('expires_at', '>', Carbon::now())
            ->latest()
            ->first();

        if (!$otpRecord) {
            return back()->withErrors(['otp' => 'Invalid or expired OTP. Please try again.'])->withInput();
        }

        // Mark OTP as verified (but not used until password is actually reset)
        return redirect()->route('password.otp.reset.form', [
            'email' => $request->email,
            'token' => base64_encode($request->email . '|' . $request->otp),
        ]);
    }

    /**
     * Show reset password form
     */
    public function showResetForm(Request $request)
    {
        return view('auth.passwords.otp-reset', [
            'email' => $request->email,
            'token' => $request->token,
        ]);
    }

    /**
     * Reset the password
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'token' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Decode and verify token
        $decoded = base64_decode($request->token);
        $parts = explode('|', $decoded);
        if (count($parts) !== 2 || $parts[0] !== $request->email) {
            return back()->withErrors(['email' => 'Invalid reset token.']);
        }

        $otp = $parts[1];

        // Verify OTP is still valid
        $otpRecord = PasswordResetOtp::where('email', $request->email)
            ->where('otp', $otp)
            ->where('is_used', false)
            ->where('expires_at', '>', Carbon::now())
            ->latest()
            ->first();

        if (!$otpRecord) {
            return redirect()->route('password.otp.forgot')
                           ->withErrors(['email' => 'OTP has expired. Please request a new one.']);
        }

        // Reset password
        $user = User::where('email', $request->email)->first();
        $user->password = Hash::make($request->password);
        $user->save();

        // Mark OTP as used
        $otpRecord->update(['is_used' => true]);

        return redirect()->route('login')->with('success', 'Password reset successfully! Please login with your new password.');
    }
}
