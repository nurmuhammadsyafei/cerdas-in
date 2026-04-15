<?php

namespace App\Http\Controllers\API\Master;

use App\Http\Controllers\Controller;
use App\Models\GuruSekolah;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GuruController extends Controller
{
    public function index(Request $request)
    {
        $guruRoleId = Role::where('name', 'guru')->value('id');

        $query = User::where('role_id', $guruRoleId)
            ->with(['guruSekolah.sekolah']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->boolean('all')) {
            return response()->json([
                'data' => $query->orderBy('name')->get()->map([$this, 'formatGuru']),
            ]);
        }

        $paginated = $query->orderBy('name')->paginate(15);

        return response()->json([
            'data'          => collect($paginated->items())->map([$this, 'formatGuru']),
            'current_page'  => $paginated->currentPage(),
            'last_page'     => $paginated->lastPage(),
            'total'         => $paginated->total(),
            'per_page'      => $paginated->perPage(),
        ]);
    }

    public function formatGuru(User $user): array
    {
        $gs = $user->guruSekolah;
        return [
            'user_code'    => $user->user_code,
            'name'         => $user->name,
            'email'        => $user->email,
            'is_active'    => $user->is_active,
            'foto_url'     => $gs?->foto ? asset('storage/' . $gs->foto) : null,
            'sekolah_id'   => $gs?->sekolah_id,
            'nama_sekolah' => $gs?->sekolah?->nama_sekolah,
        ];
    }

    public function show(User $user)
    {
        $user->load('guruSekolah.sekolah');
        return response()->json($this->formatGuru($user));
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'sekolah_id' => 'nullable|integer|exists:app_sekolah,id',
            'foto'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $gs = GuruSekolah::firstOrNew(['user_id' => $user->id]);

        if ($request->filled('sekolah_id')) {
            $gs->sekolah_id = $data['sekolah_id'];
        } elseif (!$gs->exists) {
            return response()->json([
                'success' => false,
                'message' => 'Pilih sekolah terlebih dahulu.',
            ], 422);
        }

        if ($request->hasFile('foto')) {
            if ($gs->foto) {
                Storage::disk('public')->delete($gs->foto);
            }
            $gs->foto = $request->file('foto')->store('guru', 'public');
        }

        $gs->save();

        return response()->json([
            'success' => true,
            'message' => 'Data guru berhasil diperbarui.',
            'data'    => $this->formatGuru($user->fresh(['guruSekolah.sekolah'])),
        ]);
    }
}
