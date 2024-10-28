<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Collections\AbsensiSiswaCollection;
use App\Models\AbsensiSiswa;
use Illuminate\Support\Facades\DB;

class AbsensiSiswaRepository
{
    public function getListAbsensiSiswa(array $filter): AbsensiSiswaCollection
    {
        $query = DB::table('Siswa')
        ->leftJoin('AbsensiSiswa', function ($join) use ($filter) {
            $join->on('Siswa.id', '=', 'AbsensiSiswa.siswa_id')
            ->where('AbsensiSiswa.absensi_id', '=', $filter['id_absensi']);
        })
        ->leftJoin('Absensi', function ($join) use ($filter) {
            $join->on('AbsensiSiswa.absensi_id', '=', 'Absensi.id');
            // ->where('Absensi.guru_id', '=', $filter['id_guru']); // Move guru_id to JOIN
        })
        ->leftJoin('User', 'Siswa.id', '=', 'User.id')
        ->select(
            'Siswa.id as siswa_id',
            'User.nama as nama_siswa',
            DB::raw("CASE WHEN AbsensiSiswa.siswa_id IS NOT NULL THEN 1 ELSE 0 END as status_absen")
        );

        if (!empty($filter['siswa_id'])) {
            $query->where('Siswa.id', '=', $filter['siswa_id']);
        }
        $sqlRaw =  vsprintf(str_replace('?', '%s', $query->toSql()), array_map(function ($binding) {
            return is_numeric($binding) ? $binding : "'" . $binding . "'";
        }, $query->getBindings()));
        // dd($sqlRaw);
        return AbsensiSiswa::hydrate($query->get()->toArray());
    }
}
