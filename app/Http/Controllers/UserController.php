<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = \App\Models\User::all();
        return view('admin.users.manageuser', compact('users'));
    }

    public function create()
    {
        // Only allow admins
        if (\Illuminate\Support\Facades\Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }
        return view('admin.users.create');
    }

    public function manage(Request $request)
    {
        $query = \App\Models\User::query();

        if ($request->filled('from')) {
            $query->whereDate('created_at', '>=', $request->from);
        }
        if ($request->filled('to')) {
            $query->whereDate('created_at', '<=', $request->to);
        }
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        $users = $query->get();

        return view('admin.users.manageuser', compact('users'));
    }

    public function edit($id)
    {
        $user = \App\Models\User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    public function destroy($id)
    {
        $user = \App\Models\User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.users.manage')->with('success', 'User deleted successfully.');
    }

    public function export(Request $request)
    {
        $type = $request->input('type', 'csv');
        $query = \App\Models\User::query();

        if ($request->filled('from')) {
            $query->whereDate('created_at', '>=', $request->from);
        }
        if ($request->filled('to')) {
            $query->whereDate('created_at', '<=', $request->to);
        }
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        $users = $query->get();

        if ($type === 'pdf') {
            // PDF export using dompdf
            $pdf = Pdf::loadView('admin.users.export_pdf', compact('users'));
            return $pdf->download('users.pdf');
        } else {
            // CSV export
            $filename = 'users.csv';
            $headers = [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => "attachment; filename=\"$filename\"",
            ];

            $callback = function() use ($users) {
                $handle = fopen('php://output', 'w');
                // Header row
                fputcsv($handle, ['First Name', 'Last Name', 'Username', 'Email', 'Role', 'Created At']);
                // Data rows
                foreach ($users as $user) {
                    fputcsv($handle, [
                        $user->first_name,
                        $user->last_name,
                        $user->username,
                        $user->email,
                        $user->role,
                        $user->created_at,
                    ]);
                }
                fclose($handle);
            };

            return Response::stream($callback, 200, $headers);
        }
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'role' => 'required|in:admin,security',
            'password' => 'required|string|confirmed|min:8',
        ]);

        $user = User::create([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'username' => $validated['username'],
            'email' => $validated['email'],
            'role' => $validated['role'],
            'password' => Hash::make($validated['password']),
        ]);

        // Redirect or return as needed
        return redirect()->route('admin.users.manage')->with('success', 'User registered successfully.');
    }
    public function update(Request $request, User $user)
    {
        $rules = [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users,username,' . $user->id],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'role' => ['required', 'string', 'in:admin,security'],
        ];

        // Only validate password fields if password is being changed
        if ($request->filled('password')) {
            $rules['password'] = ['required', 'string', 'min:8', 'confirmed'];
        }

        $validated = $request->validate($rules);

        // Update user data
        $user->update([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'username' => $validated['username'],
            'email' => $validated['email'],
            'role' => $validated['role'],
        ]);

        // Update password if provided (admin can reset any user's password)
        if ($request->filled('password')) {
            $user->update([
                'password' => Hash::make($validated['password'])
            ]);
        }

        return redirect()->route('admin.users.manage')
                        ->with('success', 'User updated successfully.');
    }
}
