<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = User::all();
        return view('Pelatih.PlayerPage', compact('user'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('SignUp');
    }

    public function logincreate()
    {
        return view('Login');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        // Validasi input
        try {
            $request->validate([
                'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
                'name' => 'required|string|max:255|unique:users',
                'email' => 'required|email|unique:users',
                'role' => 'required|in:Pemain,Pelatih',
                'password' => 'required|min:7',
            ]);

            // dd('Lolos Validasi');
        } catch (\Exception $e) {
            dd($e->getMessage()); // Menampilkan error jika ada
        }

        // Upload gambar jika ada
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('profile_images', 'public');
        }

        // Simpan user ke database
        User::create([
            'image' => $imagePath,
            'name' => $request->name, // Menggunakan name, bukan username
            'email' => $request->email,
            'role' => $request->role ?? 'pemain', // Default ke pemain
            'password' => Hash::make($request->password), // Hash password
        ]);

        return redirect('login');
    }

    public function login(Request $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $request->session()->regenerate(); // Regenerasi sesi setelah login

            if (Auth::user()->role === 'Pelatih') {
                return redirect()->route('pelatih.index')->with('success', 'Training saved successfully.');
            } elseif (Auth::user()->role === 'Pemain') {
                return redirect()->route('pemain.create')->with('success', 'Training saved successfully.');
            }
        }

        return response()->json(['message' => 'Email atau password salah!'], 401);
    }

    public function logout(Request $request)
    {
        Auth::logout(); // Logout user yang sedang login
        $request->session()->invalidate(); // Hapus session
        $request->session()->regenerateToken(); // Regenerasi CSRF token untuk keamanan

        return redirect()->route('login')->with('success', 'Anda telah logout!');
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
