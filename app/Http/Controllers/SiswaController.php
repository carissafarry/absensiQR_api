<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Siswa;
use Illuminate\Support\Facades\DB;

class SiswaController extends Controller
{
    public function getAll(Request $request)
    {
        $query = DB::table('Siswa');

        $list = Siswa::hydrate($query->get()->toArray());
        return $list;
    }

    public function getAbsensi(Request $request, $id) {}

    public function create(Request $request) {}

    public function update(Request $request) {}

    public function delete(Request $request) {}
}
