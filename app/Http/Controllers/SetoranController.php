<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setoran;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class SetoranController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $setorans = Setoran::latest()->get();
        return response()->json([
            'success' => true,
            'message' => 'Daftar setoran berhasil diambil',
            'data' => $setorans
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:100',
            'jenis_sampah' => 'required|string|max:50',
            'berat' => 'required|numeric',
            'keterangan' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        $data = $validator->validated();
        $data['kode_tiket'] = 'TKT-' . date('Y') . '-' . strtoupper(Str::random(6));
        $data['status'] = 'Menunggu';

        $setoran = Setoran::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Setoran berhasil dibuat',
            'data' => $setoran
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $setoran = Setoran::find($id);

        if (!$setoran) {
            return response()->json([
                'success' => false,
                'message' => 'Setoran tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Detail setoran berhasil diambil',
            'data' => $setoran
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $setoran = Setoran::find($id);

        if (!$setoran) {
            return response()->json([
                'success' => false,
                'message' => 'Setoran tidak ditemukan'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'nama' => 'sometimes|string|max:100',
            'jenis_sampah' => 'sometimes|string|max:50',
            'berat' => 'sometimes|numeric',
            'keterangan' => 'nullable|string',
            'status' => 'sometimes|in:Menunggu,Diproses,Selesai,Ditolak',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        $setoran->update($validator->validated());

        return response()->json([
            'success' => true,
            'message' => 'Setoran berhasil diperbarui',
            'data' => $setoran
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $setoran = Setoran::find($id);

        if (!$setoran) {
            return response()->json([
                'success' => false,
                'message' => 'Setoran tidak ditemukan'
            ], 404);
        }

        $setoran->delete();

        return response()->json([
            'success' => true,
            'message' => 'Setoran berhasil dihapus'
        ]);
    }

    /**
     * Custom search by ticket code (public but maybe protected by requirement)
     */
    public function checkByTicket(Request $request)
    {
        $request->validate(['kode_tiket' => 'required|string']);
        $setoran = Setoran::where('kode_tiket', $request->kode_tiket)->first();

        if (!$setoran) {
            return response()->json([
                'success' => false,
                'message' => 'Kode tiket tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Data setoran ditemukan',
            'data' => $setoran
        ]);
    }
}
