<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MahasiswaController extends Controller
{
    public function index()
    {
        $data = Mahasiswa::orderByDesc('id')->get();

        return response()->json([
            'status'  => true,
            'message' => 'Data mahasiswa berhasil dimuat',
            'data'    => $data,
        ], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nim'     => 'required|string|min:5|max:30|unique:mahasiswas,nim',
            'nama'    => 'required|string|max:120',
            'jurusan' => 'required|string|max:100',
        ], [
            'nim.required'     => 'NIM wajib diisi.',
            'nim.min'          => 'NIM minimal 5 karakter.',
            'nim.unique'       => 'NIM sudah terdaftar.',
            'nama.required'    => 'Nama lengkap wajib diisi.',
            'jurusan.required' => 'Jurusan wajib diisi.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'message' => 'Validasi data gagal',
                'errors'  => $validator->errors(),
            ], 422);
        }

        $mahasiswa = Mahasiswa::create($validator->validated());

        return response()->json([
            'status'  => true,
            'message' => 'Data mahasiswa berhasil ditambahkan',
            'data'    => $mahasiswa,
        ], 201);
    }

    // DETAIL SATU DATA (GET /api/mahasiswa/{id})
    public function show($id)
    {
        $mahasiswa = Mahasiswa::find($id);

        if (!$mahasiswa) {
            return response()->json([
                'status'  => false,
                'message' => 'Data mahasiswa tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'status'  => true,
            'message' => 'Detail data mahasiswa',
            'data'    => $mahasiswa,
        ], 200);
    }

    // UPDATE (PUT/PATCH /api/mahasiswa/{id})
    public function update(Request $request, $id)
    {
        $mahasiswa = Mahasiswa::find($id);

        if (!$mahasiswa) {
            return response()->json([
                'status'  => false,
                'message' => 'Data mahasiswa tidak ditemukan',
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'nim'     => 'required|string|min:5|max:30|unique:mahasiswas,nim,' . $id,
            'nama'    => 'required|string|max:120',
            'jurusan' => 'required|string|max:100',
        ], [
            'nim.required'     => 'NIM wajib diisi.',
            'nim.min'          => 'NIM minimal 5 karakter.',
            'nim.unique'       => 'NIM sudah digunakan mahasiswa lain.',
            'nama.required'    => 'Nama lengkap wajib diisi.',
            'jurusan.required' => 'Jurusan wajib diisi.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'message' => 'Validasi perubahan data gagal',
                'errors'  => $validator->errors(),
            ], 422);
        }

        $mahasiswa->update($validator->validated());

        return response()->json([
            'status'  => true,
            'message' => 'Data mahasiswa berhasil diperbarui',
            'data'    => $mahasiswa,
        ], 200);
    }

    // DELETE (DELETE /api/mahasiswa/{id})
    public function destroy($id)
    {
        $mahasiswa = Mahasiswa::find($id);

        if (!$mahasiswa) {
            return response()->json([
                'status'  => false,
                'message' => 'Data mahasiswa tidak ditemukan',
            ], 404);
        }

        $mahasiswa->delete();

        return response()->json([
            'status'  => true,
            'message' => 'Data mahasiswa berhasil dihapus',
        ], 200);
    }
}