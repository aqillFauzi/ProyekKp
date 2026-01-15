<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ForgotPasswordController extends Controller
{
    // 1. Tampilkan Form Input Email
    public function showForgetPasswordForm()
    {
        return view('auth.forgetPassword');
    }

    // 2. Proses Kirim Link ke Email
    public function submitForgetPasswordForm(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users']);

        $token = Str::random(64);

        DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => Carbon::now()
        ]);

        Mail::send('email.forgetPassword', ['token' => $token], function($message) use($request){
            $message->to($request->email);
            $message->subject('Reset Password Notification');
        });

        return back()->with('message', 'Kami telah mengirimkan link reset password ke email Anda!');
    }

    // 3. Tampilkan Form Ganti Password Baru (INI YANG TADI ERROR / HILANG)
    public function showResetPasswordForm($token)
    {
        return view('auth.forgetPasswordLink', ['token' => $token]);
    }

    // 4. Proses Simpan Password Baru (Sudah ada validasi 60 Menit)
    public function submitResetPasswordForm(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users',
            'password' => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required'
        ]);

        // Ambil data token
        $tokenData = DB::table('password_resets')
                        ->where([
                            'email' => $request->email, 
                            'token' => $request->token
                        ])
                        ->first();

        // Cek 1: Apakah token ada?
        if(!$tokenData){
            return back()->withInput()->with('error', 'Token tidak valid atau email salah!');
        }

        // Cek 2: Apakah token sudah kadaluarsa (60 menit)?
        $waktuBuat = Carbon::parse($tokenData->created_at);
        $waktuSekarang = Carbon::now();

        if ($waktuSekarang->diffInMinutes($waktuBuat) > 60) {
            DB::table('password_resets')->where('email', $request->email)->delete();
            return back()->withInput()->with('error', 'Link sudah kadaluarsa!');
        }

        // Update Password
        User::where('email', $request->email)
            ->update(['password' => Hash::make($request->password)]);

        // Hapus Token
        DB::table('password_resets')->where(['email'=> $request->email])->delete();

        return redirect('/login')->with('message', 'Password berhasil diubah! Silakan login.');
    }
}