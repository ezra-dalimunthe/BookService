<?php
namespace App\Http\Controllers;

use Auth;
trait AuthorizationTrait
{
    public function allowRole($rolenames)
    {

        $user = Auth::user();
        if (!$user) {
            abort(401);
        }
        $roles = array_column($user->roles, "role");

        if (!array_intersect($rolenames, $roles)) {
            abort(403, "Forbidden due to lack access-right");
        }

    }
}
