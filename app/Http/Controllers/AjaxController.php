<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;

class AjaxController extends Controller
{
    public function __construct(
        private User $user,
    ) { }

    public function user()
    {
        $users = $this->user()->select('id', 'nama')->get();
        $results = $users->map(function($k) {
            return ['id' => $k->id, 'text' => $k->nama];
        });
        return response()->json(['results' => $results]);
    }
}