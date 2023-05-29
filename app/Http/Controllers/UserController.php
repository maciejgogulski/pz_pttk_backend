<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function assignRole(Request $request)
    {
        $roleId = $request->input('role_id');
        $userId = $request->input('user_id');

        $role = Role::find($roleId);
        $user = User::find($userId);

        if ($role && $user) {
            $user->assignRole($role);
            return response()->json(['message' => 'Rola zostala przypisana uzytkownikowi.']);
        } else {
            return response()->json(['error' => 'Nie mozna przypisac roli uzytkownikowi.'], 400);
        }
    }

    public function removeRole(Request $request)
    {
        $roleId = $request->input('role_id');
        $userId = $request->input('user_id');

        $role = Role::find($roleId);
        $user = User::find($userId);

        if ($role && $user) {
            $user->revokeRole($role);
            return response()->json(['message' => 'Rola zostala usunieta uzytkownikowi.']);
        } else {
            return response()->json(['error' => 'Nie mozna usunac roli uzytkownikowi.'], 400);
        }
    }

    public function showUsersWithRoles()
    {
        $users = User::with('roles')->get();

        return response(['users' => $users], 200);
    }
}
