<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Setoran;

class AdminController extends Controller
{
    public function dashboard()
    {
        $all_setoran = Setoran::orderBy('created_at', 'desc')->get();
        return view('admin.dashboard', compact('all_setoran'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Menunggu,Diproses,Selesai,Ditolak',
        ]);

        $setoran = Setoran::findOrFail($id);
        $setoran->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Status updated successfully');
    }

    public function destroy($id)
    {
        $setoran = Setoran::findOrFail($id);
        $setoran->delete();

        return redirect()->back()->with('success', 'Record deleted successfully');
    }
}
