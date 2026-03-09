<?php

namespace App\Http\Controllers;

use App\Models\AuthModel;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{

    // Function untuk validasi form menggunakan Validator
    private function validateForm(Request $request, array $rules)
    {
        $validator = Validator::make($request->all(), $rules);
        return $validator;
    }

    // Function untuk halaman login
    public function index()
    {
        return view('auth.login');
    }

    // Function untuk halaman proses login
    public function proses_login(Request $request)
{
    $username = $request->username;
    $password = $request->password;

    // Ambil data user
    $data = AuthModel::where('username', $username)->first();

    if (!$data) {
        Session::flash('username_tidak_valid', 'Username tidak valid. Silakan coba lagi.');
        return redirect('/auth');
    }

    // cek password
    if (Hash::check($password, $data->password)) {

        // buat session
        $request->session()->regenerate();
        session(['username_ID' => $username]);

        Session::flash('app', 'Selamat datang ' . $username);

        return redirect('/dashboard');
    }

    Session::flash('password_tidak_valid', 'Password Anda tidak valid. Silakan coba lagi.');
    return redirect('/auth')->withInput();
}

    // Function proses registrasi
    public function registrasi()
    {
        return view('auth.registrasi');
    }

    // Function proses registrasi
    public function proses_registrasi(Request $request)
    {

        // Inisialisasi variabel validasi
        $validatedData = $this->validateForm($request, [
            'username' => 'unique:tbl_auth'
        ]);

        // Cek jika username sudah ada yang memiliki
        if ($validatedData->fails()) {

            // Berikan pesan 
            Session::flash('error_registrasi', 'Registrasi gagal. Silakan coba kembali.');

            // Redirect ke halaman registrasi
            return redirect('/registrasi');

            // Misalkan username belum ada yang memiliki atau belum terdaftar
        } else {

            //  Inisialisasi untuk melakukan insert
            $registrasi = new AuthModel();
            $registrasi->email = $request->email;
            $registrasi->username = $request->username;
            $registrasi->password = Hash::make($request->password); 

            // Jika berhasil registrasi
            if ($registrasi->save()) {

                // Berikan pesan jika proses registrasi telah sukses 
                Session::flash('sukses_registrasi', 'Anda berhasil registrasi. Silakan login terlebih dahulu.');

                // Dan redirect ke halaman login
                return redirect('/auth')->withInput();
            }
        }
    }

    // Function untuk halaman lupa password
    public function lupaPassword()
    {
        return view('auth.lupa_password');
    }

    // Function proses lupa password
    public function proses_lupa_password(Request $request)
    {

        // Ambil nilai name form
        $username = $request->input('username');
        $password = $request->input('password');
        $password2 = $request->input('password2');

        // Ambil data dari tabel tbl_auth berdasarkan username
        $data = AuthModel::where('username', $username)->first();

        // Cek jika username nya itu tidak ada dalam tabel tbl_auth
        if (!$data) {

            // Berikan pesan 
            Session::flash('gagal_di_ubah', 'Lupa password gagal di ubah. Silakan coba lagi.');

            // Lalu alihkan ke halaman lupa password
            return redirect('/lupa_password');

            // Jika pengguna memasukkan password itu tidak sesuai dengan konfirmasi password
        } else if ($password !== $password2) {

            // Berikan pesan tertentu bahwa konfirmasi password tidak sesuai
            Session::flash('gagal_konfirmasi', 'Konfirmasi password tidak sesuai. Silakan coba lagi.');

            // Lalu alihkan ke halaman lupa password
            return redirect('/lupa_password')->withInput();

            // Misalkan proses ubah password berhasil     
        } else {

            // Update password berdasarkan where username pada field username
            $affected = AuthModel::where('username', $username)
                ->update(['password' =>  Hash::make($password)]);

            // Jika berhasil ubah password
            if ($affected == true) {

                // Berikan pesan tertentu bahwa password berhasil di ubah
                Session::flash('sukses_di_ubah', 'Berhasil mengubah password.');

                // Lalu alihkan ke halaman login
                return redirect('/auth')->withInput();
            }
        }
    }

    // Function untuk logout
    public function logout(Request $request)
    {
        // Melakukan logout pada user yang sedang login
        Auth::guard('admin')->logout();

        // Membatalkan dan hapus sesi yang sedang berjalan
        $request->session()->invalidate();

        // Membuat token baru untuk menghindari serangan CSRF
        $request->session()->regenerateToken();

        // Menampilkan pesan sukses pada session
        Session::flash('logout', 'Anda berhasil logout.');

        // Kembali ke halaman login dan hapus cookie jika ada
        return redirect()->intended('/auth')->withCookie(Cookie::forget('log_'));
    }
}
