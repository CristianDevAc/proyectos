<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
     public function __construct()
    {
        $this->middleware('can:ver usuarios')->only('index');
        $this->middleware('can:crear usuarios')->only(['create', 'store']);
        $this->middleware('can:editar usuarios')->only(['edit', 'update']);
    }
    public function index()
    {
        $usuarios = User::with('roles')->get();
        return view('admin.usuarios.index', compact('usuarios'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('admin.usuarios.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required|exists:roles,name',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->assignRole($request->role);

        return redirect()->route('admin.usuarios.index')->with('success', 'Usuario creado correctamente.');
    }
    public function edit(User $user)
    {
        $roles = Role::all();
        return view('admin.usuarios.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:6|confirmed', // contraseña opcional
            'role' => 'required|exists:roles,name',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            // Solo actualiza si la contraseña fue ingresada
            $user->password = Hash::make($request->password);
        }

        $user->save();

        // Actualizar rol
        $user->syncRoles([$request->role]);

        return redirect()->route('admin.usuarios.index')->with('success', 'Usuario actualizado correctamente.');
    }
}
