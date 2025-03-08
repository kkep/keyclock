<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Khayrullin\KeycloakWebGuard\Facades\KeycloakWeb;

class UserController extends Controller
{
    public function __invoke(Request $request)
    {
        // return KeycloakWeb::getUsers(['search' => $request->input('search'), 'max' => 5]);
        return UserResource::collection(
            User::where('name', "~*", $request->input('search'))->get()
        );
    }
}
