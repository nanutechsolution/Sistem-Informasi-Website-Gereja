<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User; // Pastikan model User di-import
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Role; // Import model Role dari Spatie

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                    ->orWhere('email', 'like', "%$search%");
            });
        }

        if ($request->filled('role')) {
            $query->whereHas('roles', function ($q) use ($request) {
                $q->where('name', $request->role);
            });
        }

        $users = $query->paginate(10)->withQueryString(); // Keep query params on pagination
        $allRoles = Role::pluck('name'); // Assuming Spatie Role model

        return view('admin.users.index', compact('users', 'allRoles'));
    }
    /**
     * Tampilkan form untuk membuat pengguna baru.
     */
    public function create()
    {
        $roles = Role::orderBy('name')->get(); // Ambil semua peran yang tersedia
        return view('admin.users.create', compact('roles'));
    }

    /**
     * Simpan pengguna baru ke database.
     */
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users,email',
                'password' => 'required|string|min:8|confirmed',
                'roles' => 'required|array', // Harus memilih setidaknya satu peran
                'roles.*' => 'exists:roles,id', // Pastikan ID peran valid
            ]);

            $user = User::create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'password' => Hash::make($validatedData['password']),
            ]);

            $user->syncRoles($validatedData['roles']); // Tetapkan peran ke pengguna

            return redirect()->route('admin.users.index')->with('success', 'Pengguna berhasil ditambahkan!');
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Error storing User:', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Tampilkan detail pengguna (opsional).
     */
    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    /**
     * Tampilkan form untuk mengedit pengguna.
     */
    public function edit(User $user)
    {
        $roles = Role::orderBy('name')->get(); // Ambil semua peran yang tersedia
        return view('admin.users.edit', compact('user', 'roles'));
    }

    /**
     * Perbarui pengguna di database.
     */
    public function update(Request $request, User $user)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
                'password' => 'nullable|string|min:8|confirmed', // Password opsional saat update
                'roles' => 'required|array', // Harus memilih setidaknya satu peran
                'roles.*' => 'exists:roles,id', // Pastikan ID peran valid
            ]);

            $user->name = $validatedData['name'];
            $user->email = $validatedData['email'];

            if (!empty($validatedData['password'])) {
                $user->password = Hash::make($validatedData['password']);
            }
            $user->save();

            $user->syncRoles($validatedData['roles']); // Perbarui peran pengguna

            return redirect()->route('admin.users.index')->with('success', 'Pengguna berhasil diperbarui!');
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Error updating User:', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui data: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Hapus pengguna dari database.
     */
    public function destroy(User $user)
    {
        try {
            // Jangan izinkan admin menghapus dirinya sendiri
            if (auth()->user()->id === $user->id) {
                return redirect()->back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
            }

            $user->delete();
            return redirect()->route('admin.users.index')->with('success', 'Pengguna berhasil dihapus!');
        } catch (\Exception $e) {
            Log::error('Error deleting User:', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus data: ' . $e->getMessage());
        }
    }
}