<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Gate;

class AdminController extends Controller
{
    protected string $policyClass;

    public function isAble($ability, $targetModel)
    {
        try {
            Gate::authorize($ability, [$targetModel, $this->policyClass]);
            return true;
        } catch (AuthorizationException $e) {
            return false;
        }
    }
}
