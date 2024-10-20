<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function getAll(Request $request)
    {
        $query = DB::table('Pengguna')
            ->select('id_pengguna', 'nama_pengguna');

        $listUsers = User::hydrate($query->get()->toArray());
        return $listUsers;
    }

    public function getUser(Request $request, $id) {}

    public function create(Request $request) {}

    public function update(Request $request) {}

    public function delete(Request $request) {}
}
