<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class RoleController extends Controller
{
    /**
     * Create a new role.
     *
     * @param  Request  $request
     * @return Response
     */
    public function createRole(Request $request): Response
    {
        $validatedData = $request->validate([
            'name' => 'required|unique:roles',
            'posiada_uprawnienia' => 'boolean',
            'mountain_group_id' => 'nullable|exists:mountain_groups,id',
        ]);

        $role = Role::create($validatedData);

        return response(['message' => 'Rola stworzona pomyślnie', 'role' => $role], 201);
    }


    /**
     * Display the specified role.
     *
     * @return Response
     */
    public function showRoles(): Response
    {
        $roles = Role::all();

        return response(['roles' => $roles], 200);
    }

    /**
     * Update an existing role.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function updateRole(Request $request, $id): Response
    {
        $role = Role::findOrFail($id);

        $validatedData = $request->validate([
            'name' => 'required|unique:roles,name,'.$role->id,
            'posiada_uprawnienia' => 'boolean',
            'mountain_group_id' => 'nullable|exists:mountain_groups,id',
        ]);

        $role->update($validatedData);

        return response(['message' => 'Rola zaktualizowana pomyślnie', 'role' => $role], 200);
    }

    /**
     * Delete a role.
     *
     * @param  int  $id
     * @return Response
     */
    public function deleteRole($id): Response
    {
        $role = Role::findOrFail($id);
        $role->delete();

        return response(['message' => 'Rola usunięta pomyślnie'], 200);
    }
}
