<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http; 

class DeteksiController extends Controller
{
    public function index()
    {
        // Halaman awal, kirim variabel kosong agar tidak error di view
        return view('welcome'); 
    }

    public function prosesAnalisa(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'mode' => 'required',
        ]);

        // URL Python
        $pythonUrl = 'http://127.0.0.1:5001/proses';

        try {
            $response = null;

            // KASUS A: INPUT DARI KAMERA (Base64)
            if ($request->filled('camera_image')) {
                $response = Http::asForm()->post($pythonUrl, [
                    'mode' => $request->mode,
                    'camera_image' => $request->camera_image
                ]);
            } 
            // KASUS B: INPUT DARI UPLOAD FILE (Logika fopen yang Anda minta)
            else if ($request->hasFile('foto_koin')) {
                $file = $request->file('foto_koin');
                $photo = fopen($file->getRealPath(), 'r');

                $response = Http::attach(
                    'file_gambar', $photo, $file->getClientOriginalName()
                )->post($pythonUrl, [
                    'mode' => $request->mode
                ]);
            } 
            else {
                return view('welcome', ['error' => 'Harap ambil foto atau upload gambar!']);
            }

            // 2. Cek Hasil
            if ($response->successful()) {
                $data = $response->json();
                
                if(isset($data['status']) && $data['status'] == 'sukses') {
                    // SUKSES: Langsung load view dengan data (Bukan Redirect/Session)
                    return view('welcome', ['hasil_deteksi' => $data]);
                } else {
                    return view('welcome', ['error' => 'Gagal: ' . ($data['pesan'] ?? 'Unknown error')]);
                }
            } else {
                return view('welcome', ['error' => 'Gagal koneksi ke Python. Pastikan app.py jalan!']);
            }

        } catch (\Exception $e) {
            return view('welcome', ['error' => 'Error Sistem: ' . $e->getMessage()]);
        }
    }
}