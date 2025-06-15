<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Category;
use App\Models\Reimbursement;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class ReimbursementController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }

        // Load reimbursements with their related category
        $reimbursements = $user->reimbursements()
            ->with('category') // eager load relasi category
            ->latest()
            ->get();

        return response()->json([
            'message' => 'List of your reimbursements',
            'dataUser' => $user->name,
            'data' => $reimbursements
        ]);
    }

    public function store(Request $request)
    {
        $userId = Auth::id();

        $validated = $request->validate([
            'title'        => 'nullable|string|max:255',
            'description'  => 'nullable|string',
            'amount'       => 'nullable|numeric',
            'category_id'  => 'nullable|exists:categories,id',
            'proof_file'   => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        $category = Category::findOrFail($validated['category_id']);

        $totalBulanIni = Reimbursement::where('user_id', $userId)
            ->where('category_id', $validated['category_id'])
            ->whereYear('submitted_at', now()->year)
            ->whereMonth('submitted_at', now()->month)
            ->sum('amount');

        $totalSetelahTambah = $totalBulanIni + $validated['amount'];

        if ($totalSetelahTambah > $category->limit_per_month) {
            return response()->json([
                'message' => 'Limit bulanan untuk kategori ini telah terlampaui.',
                'limit'   => $category->limit_per_month,
                'total_sekarang' => $totalBulanIni,
                'total_setelah_ditambah' => $totalSetelahTambah
            ], 422);
        }

        if ($request->hasFile('proof_file')) {
            $file = $request->file('proof_file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('proofs', $filename, 'public');
            $validated['proof_file'] = $path;
        }

        // Set nilai otomatis
        $validated['user_id'] = $userId;
        $validated['status'] = 'pending';
        $validated['submitted_at'] = now();

        $reimbursement = Reimbursement::create($validated);

        ActivityLog::create([
            'user_id'    => Auth::id(),
            'action'     => 'create',
            'description' => 'Membuat reimbursement baru',
        ]);

        return response()->json([
            'message' => 'Reimbursement berhasil dibuat',
            'data' => $reimbursement->load('category')
        ]);
    }
    public function show(Reimbursement $reimbursement)
    {
        $this->authorizeAccess($reimbursement);
        return response()->json($reimbursement->load('category'));
    }

    public function update(Request $request, Reimbursement $reimbursement)
    {
        $this->authorizeAccess($reimbursement);

        $validated = $request->validate([
            'title'       => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'amount'      => 'sometimes|required|numeric',
            'category_id' => 'sometimes|required|exists:categories,id',
            'proof_file'  => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        if ($request->hasFile('proof_file')) {
            if ($reimbursement->proof_file) {
                Storage::disk('public')->delete($reimbursement->proof_file);
            }

            $path = $request->file('proof_file')->store('proofs', 'public');
            $validated['proof_file'] = $path;
        }

        $reimbursement->update($validated);

        //  Logging
        ActivityLog::create([
            'user_id'    => Auth::id(),
            'action'     => 'create',
            'description' => 'Update reimbursement',
        ]);

        return response()->json([
            'message' => 'Reimbursement updated',
            'data' => $reimbursement->load('category')
        ]);
    }


    public function destroy(Reimbursement $reimbursement)
    {
        $this->authorizeAccess($reimbursement);

        if ($reimbursement->proof_file) {
            Storage::disk('public')->delete($reimbursement->proof_file);
        }

        $reimbursement->delete(); // soft delete

        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'delete',
            'description' => 'Menghapus reimbursement (soft delete) ID: ' . $reimbursement->id
        ]);

        return response()->json(['message' => 'Reimbursement deleted (soft)']);
    }

    protected function authorizeAccess(Reimbursement $reimbursement)
    {
        $userId = Auth::id();
        if ($reimbursement->user_id !== $userId) {
            abort(403, 'Unauthorized');
        }
    }

    // manager ==========================================
    public function managerIndex()
    {
        $reimbursements = Reimbursement::with(['user', 'category'])
            ->latest()
            ->get();

        return response()->json([
            'message' => 'List of all reimbursements (manager)',
            'data' => $reimbursements
        ]);
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected',
        ]);

        $reimbursement = Reimbursement::findOrFail($id);

        $reimbursement->status = $request->status;

        if ($request->status === 'approved') {
            $reimbursement->approved_at = now();
        }

        $reimbursement->save();

        // 🔍 Logging
        ActivityLog::create([
            'user_id'    => Auth::id(),
            'action'     => 'create',
            'description' => 'Update status reimbursement',
        ]);

        return response()->json([
            'message' => 'Status updated successfully',
            'data' => $reimbursement
        ]);
    }

    public function cekSoftDelete()
    {
        // Ambil semua data reimbursement yang sudah di-soft delete
        $data = Reimbursement::onlyTrashed()->get();

        if ($data) {
            return response()->json([
                'message' => 'Data reimbursement yang sudah di-soft delete',
                'data' => $data
            ]);
        } else {
            return response()->json([
                'message' => 'Akses Ditolak'
            ]);
        }
    }
    public function adminIndex()
    {
        $reimbursements = Reimbursement::with(['user', 'category'])
            ->latest()
            ->get();

        return response()->json([
            'message' => 'List of all reimbursements (admin)',
            'data' => $reimbursements
        ]);
    }

    public function trashed()
    {
        Log::info('✅ Masuk ke method trashed()');

        try {
            $trashed = Reimbursement::onlyTrashed()
                ->with(['user', 'category'])
                ->latest()
                ->get();

            return response()->json([
                'message' => 'Reimbursement yang sudah dihapus (soft delete)',
                'data' => $trashed
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], 500);
        }
    }


    public function restore($id)
    {
        $reimbursement = Reimbursement::onlyTrashed()->findOrFail($id);
        $reimbursement->restore();

        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'restore',
            'description' => 'Mengembalikan reimbursement ID: ' . $id
        ]);

        return response()->json(['message' => 'Reimbursement restored']);
    }
}
