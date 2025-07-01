<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class UserController extends Controller
{
    /**
     * Mostrar todos los usuarios.
     */
    public function index()
    {
        return response()->json(User::all(), 200);
    }

    /**
     * Crear un nuevo usuario.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'lastname' => 'required|string',
            'birthday' => 'required|string',
            'phone' => 'required|string',
            'age' => 'required|integer',
            'sex' => 'required|string',
            'description' => 'nullable|string',
            'direccion' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'photo' => 'nullable|string|max:1000', // ✅ usamos 'photo' como URL string
        ]);

        $data = $request->all(); // ✅ ahora sí tomamos todo, incluido photo

        $data['password'] = bcrypt($data['password']);

        $usuario = User::create($data);

        return response()->json(['usuario' => $usuario], 201);
    }



    /**
     * Mostrar un usuario específico.
     */
    public function show(string $id)
    {
        $usuario = User::findOrFail($id);
        return response()->json($usuario, 200);
    }

    /**
     * Actualizar un usuario.
     */
    public function update(Request $request, $id)
    {
        $usuario = User::findOrFail($id);

        $request->validate([
            'name' => 'sometimes|required|string',
            'lastname' => 'sometimes|required|string',
            'birthday' => 'sometimes|required|string',
            'phone' => 'sometimes|required|string',
            'age' => 'sometimes|required|integer',
            'sex' => 'sometimes|required|string',
            'description' => 'nullable|string',
            'photo' => 'nullable|string',
            'direccion' => 'sometimes|required|string',
            'email' => 'sometimes|required|email|unique:users,email,' . $usuario->id,
            'password' => 'nullable|string|min:6'
        ]);

        $data = $request->all();

        if (!empty($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        } else {
            unset($data['password']);
        }

        $usuario->update($data);

        return response()->json(['usuario' => $usuario], 200);
    }

    /**
     * Eliminar un usuario.
     */
    public function destroy(string $id)
    {
        $usuario = User::findOrFail($id);
        $usuario->delete();
        return response()->json(['message' => 'Usuario eliminado correctamente'], 200);
    }
}