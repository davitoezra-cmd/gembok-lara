<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    /**
     * Tampilkan halaman kamera selfie absen.
     * Semua role kecuali customer bisa akses.
     *
     * GET /attendance
     */
    public function index()
    {
        $user = Auth::user();

        // 🟩 LOGIKA FILTER: Tentukan role berdasarkan kata di email
        $role = 'user';
        if (str_contains($user->email, 'admin')) {
            $role = 'admin';
        } elseif (str_contains($user->email, 'teknisi')) {
            $role = 'technician';
        }

        // 🛑 JIKA BUKAN ADMIN / TEKNISI, TOLAK AKSES
        if ($role === 'user') {
            abort(403, 'Hanya Admin dan Teknisi yang diperbolehkan melakukan absensi.');
        }

        $absenHariIni = Attendance::hariIni($user->id);
        $sudahCheckIn  = $absenHariIni?->check_in  !== null;
        $sudahCheckOut = $absenHariIni?->check_out !== null;

        return view('attendance.index', compact(
            'user',
            'role',
            'absenHariIni',
            'sudahCheckIn',
            'sudahCheckOut',
        ));
    }

    /**
     * Simpan data absen.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'photo'     => ['required', 'string'],
                'latitude'  => ['nullable', 'numeric'],
                'longitude' => ['nullable', 'numeric'],
                'address'   => ['nullable', 'string', 'max:255'],
                'type'      => ['required', 'in:check_in,check_out'],
                'notes'     => ['nullable', 'string', 'max:500'],
            ]);

            $user = Auth::user();
            $type = $request->type; 

            // 🟩 Tentukan role untuk disimpan ke tabel attendances
            $role = 'admin';
            if (str_contains($user->email, 'teknisi')) {
                $role = 'technician';
            } elseif (!str_contains($user->email, 'admin')) {
                // Jika user biasa tembus lewat api, langsung block
                return response()->json(['success' => false, 'message' => 'Akses ditolak.'], 403);
            }

            $photoPath = $this->simpanFotoBase64($request->photo, $user->id);
            if (! $photoPath) {
                return response()->json(['success' => false, 'message' => 'Gagal menyimpan foto.'], 422);
            }

            $status = 'hadir';
            if ($type === 'check_in') {
                $batasJamMasuk = Carbon::today()->setTime(8, 30); 
                $status = now()->greaterThan($batasJamMasuk) ? 'terlambat' : 'hadir';
            }

            $attendance = Attendance::where('user_id', $user->id)
                ->whereDate('date', today())
                ->firstOrNew();

            if (! $attendance->exists) {
                $attendance->user_id = $user->id;
                $attendance->date    = today()->toDateString();
                $attendance->role    = $role; // Disimpan sesuai hasil deteksi email tadi
                $attendance->status  = $status;
            }

            if ($type === 'check_in' && $attendance->check_in !== null) {
                return response()->json(['success' => false, 'message' => 'Anda sudah check-in.'], 422);
            }
            if ($type === 'check_out' && $attendance->check_out !== null) {
                return response()->json(['success' => false, 'message' => 'Anda sudah check-out.'], 422);
            }
            if ($type === 'check_out' && $attendance->check_in === null) {
                return response()->json(['success' => false, 'message' => 'Anda belum check-in.'], 422);
            }

            $attendance->latitude  = $request->latitude;
            $attendance->longitude = $request->longitude;
            $attendance->address   = $request->address;
            $attendance->notes     = $request->notes;

            if ($type === 'check_in') {
                $attendance->check_in = now();
                $attendance->photo    = $photoPath; 
                $attendance->status   = $status;
            } else {
                $attendance->check_out = now();
                $attendance->photo     = $photoPath; 
            }

            $attendance->save();

            return response()->json([
                'success' => true,
                'message' => $type === 'check_in' ? 'Check-in berhasil!' : 'Check-out berhasil!',
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error_asli' => $e->getMessage(),
            ], 500);
        }
    }
    

    /**
     * Simpan foto base64 ke storage dan kembalikan path relatif.
     */
    protected function simpanFotoBase64(string $base64, int $userId): ?string
    {
        if (! preg_match('/^data:image\/(png|jpg|jpeg);base64,/', $base64, $m)) {
            return null;
        }

        $ext = $m[1] === 'jpeg' ? 'jpg' : $m[1];
        $data = preg_replace('/^data:image\/(png|jpg|jpeg);base64,/', '', $base64);
        $data = base64_decode($data);
        if ($data === false) return null;

        $filename = 'attendance/' . $userId . '_' . Str::random(12) . '.' . $ext;
        Storage::disk('public')->put($filename, $data);
        return 'storage/' . $filename;
    }

}
