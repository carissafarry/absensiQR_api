<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Collections\AbsensiCollection;
use App\Models\Absensi;
use Illuminate\Support\Facades\DB;

class AbsensiRepository
{
    public function getListAbsensi(array $filter): AbsensiCollection
    {
        $query = DB::table('Absensi');
        $query
            ->leftJoin('Kelas', 'Absensi.kelas_id', '=', 'Kelas.id')
            ->leftJoin('Guru', 'Absensi.guru_id', '=', 'Guru.id')
            ->leftJoin('User as GuruUser', 'Guru.id', '=', 'GuruUser.id') // To get Guru's name
            ->leftJoin('MataPelajaran', 'Absensi.mapel_id', '=', 'MataPelajaran.id')
            ->select(
                'Absensi.id as id_absensi',
                'Absensi.kelas_id as kelas_id',
                'Kelas.nama as nama_kelas',
                'GuruUser.nama as nama_guru',
                'MataPelajaran.mapel as mata_pelajaran',
                'Kelas.jenjang as jenjang',
                'Absensi.jamMulai',
                'Absensi.jamAkhir'
            );

        if (!empty($filter['siswa_id'])) {
            $siswa_id = $filter['siswa_id'];
            $query->whereExists(function ($subquery) use ($siswa_id) {
                $subquery->select(DB::raw(1))
                    ->from('Siswa')
                    ->whereColumn('Siswa.kelas_id', 'Kelas.id')
                    ->where('Siswa.id', $siswa_id);
            });

            // Add the `done` field
            $query->addSelect(DB::raw(
                "CASE
                    WHEN EXISTS (
                        SELECT 1 FROM AbsensiSiswa
                        WHERE AbsensiSiswa.absensi_id = Absensi.id
                        AND AbsensiSiswa.siswa_id = $siswa_id
                    )
                    THEN 1
                    ELSE 0
                END as done"
            ));
        }

        if (!empty($filter['id_guru'])) {
            $query = $query->where('Absensi.guru_id', $filter['id_guru']);
        }
        return Absensi::hydrate($query->get()->toArray());
    }

    public function getAbsensi(array $filter)
    {
        $query = DB::table('Absensi');
        $query
            ->leftJoin('Kelas', 'Absensi.kelas_id', '=', 'Kelas.id')
            ->leftJoin('Guru', 'Absensi.guru_id', '=', 'Guru.id')
            ->leftJoin('User as GuruUser', 'Guru.id', '=', 'GuruUser.id') // To get Guru's name
            ->leftJoin('MataPelajaran', 'Absensi.mapel_id', '=', 'MataPelajaran.id')
            ->select(
                'Absensi.id as id_absensi',
                'Kelas.nama as nama_kelas',
                'GuruUser.nama as nama_guru',
                'MataPelajaran.mapel as mata_pelajaran',
                'Kelas.jenjang as jenjang',
                'Absensi.jamMulai',
                'Absensi.jamAkhir'
            );

        if (!empty($filter['id_absensi'])) {
            $query = $query->where('Absensi.id', $filter['id_absensi']);
        }
        if (!empty($filter['kelas_id'])) {
            $query = $query->where('Absensi.kelas_id', $filter['kelas_id']);
        }
        if (!empty($filter['guru_id'])) {
            $query = $query->where('Absensi.guru_id', $filter['guru_id']);
        }
        if (!empty($filter['mapel_id'])) {
            $query = $query->where('Absensi.mapel_id', $filter['mapel_id']);
        }
        return (array) $query->first();
        // return new Absensi((array) $query->first());
    }

    public function createAbsensi(Absensi $absensi)
    {
        DB::transaction(function () use ($absensi, &$result) {
            $result = DB::table('Absensi')->insert($absensi->toArray());
        });

        return $result;
    }

    public function updateAbsensi(Absensi $absensi, $id_absensi)
    {
        DB::transaction(function () use ($id_absensi, $absensi, &$result) {
            $result = DB::table('Absensi')
            ->where('id', $id_absensi)
                ->update($absensi->toArray());
        });

        return $result;
    }

    public function deleteAbsensi($filter)
    {
        $result = DB::table('Absensi')
            ->where('id', $filter['id'])
            ->delete();

        return $result;
    }
}
