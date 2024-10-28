<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\AbsensiSiswa;
use App\Models\MataPelajaran;
use App\Models\Siswa;
use App\Repositories\AbsensiSiswaRepository;
use Carbon\Carbon;
use DateTime;
use Exception;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;
use stdClass;

class AbsensiSiswaController extends Controller
{
    private $absensiSiswaRepository;
    private $output;

    public function __construct(AbsensiSiswaRepository $absensiSiswaRepository)
    {
        $this->absensiSiswaRepository = $absensiSiswaRepository;
        $this->output = new stdClass();
        $this->output->responseCode = '';
        $this->output->responseDesc = '';
    }

    public function getAll(Request $request)
    {
        if (empty($request->id_absensi)) {
            throw new InvalidArgumentException("Parameter id_absensi tidak valid", 401);
        }

        $filter = new stdClass();
        $this->setIfNotEmpty($filter, 'id_absensi', $request->id_absensi);
        $this->setIfNotEmpty($filter, 'siswa_id', $request->siswa_id);
        $this->setIfNotEmpty($filter, 'id_guru', $request->id_guru);
        $list = $this->absensiSiswaRepository->getListAbsensiSiswa((array)$filter);

        $this->output->responseCode = "00";
        $this->output->responseDesc = "Sukses inquiry List Absensi Siswa";
        $this->output->responseData = $list;

        return response()->json($this->output);
    }

    public function doAbsensi(Request $request)
    {
        if (empty($request->id_absensi)) {
            throw new InvalidArgumentException("Parameter id_absensi wajib", 401);
        }
        if (empty($request->siswa_id)) {
            throw new InvalidArgumentException("Parameter siswa_id wajib", 401);
        }
        if (empty($request->mapel)) {
            throw new InvalidArgumentException("Parameter mapel wajib", 401);
        }

        $mapel = MataPelajaran::where('mapel', '=', $request->mapel)->first();
        $currentDateTime = Carbon::now('Asia/Jakarta');

        $query = DB::table('Absensi')
            ->leftJoin('Siswa', 'Siswa.kelas_id', '=', 'Absensi.kelas_id')
            ->where('Absensi.id', $request->id_absensi)
            ->where('Absensi.mapel_id', $mapel->id)
            ->where('Siswa.id', $request->siswa_id)
            ->where('Absensi.jam_mulai', '<=', $currentDateTime)
            ->where('Absensi.jam_akhir', '>=', $currentDateTime)
            ->select('Absensi.*');

        $res = $query->first();

        if (!empty($res)) {
            $insert = DB::table('AbsensiSiswa')->insert([
                'absensi_id' => $request->id_absensi,
                'siswa_id' => $request->siswa_id,
                'created_at' => Carbon::now('Asia/Jakarta')->format('Y-m-d H:i:s')
            ]);

            if ($insert) {
                $this->output->responseCode = "00";
                $this->output->responseDesc = "Sukses melakukan Absensi";
                $this->output->responseData = $insert;

                return response()->json($this->output);
            }
        }
    }
}
