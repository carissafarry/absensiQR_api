<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Repositories\AbsensiRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use stdClass;

class AbsensiController extends Controller
{
    private $absensiRepository;
    private $output;

    public function __construct(AbsensiRepository $absensiRepository)
    {
        $this->absensiRepository = $absensiRepository;
        $this->output = new stdClass();
        $this->output->responseCode = '';
        $this->output->responseDesc = '';
    }

    public function getAll(Request $request)
    {
        $filter = new stdClass();
        $this->setIfNotEmpty($filter, 'id_guru', $request->id_guru);
        $this->setIfNotEmpty($filter, 'id_absensi', $request->id_absensi);
        $list = $this->absensiRepository->getListAbsensi((array)$filter);
        // dd($list);

        $this->output->responseCode = "00";
        $this->output->responseDesc = "Sukses inquiry List Absensi";
        $this->output->responseData = $list;

        return response()->json($this->output);
    }

    public function getAbsensi(Request $request)
    {
        $filter = new stdClass();
        $this->setIfNotEmpty($filter, 'id_guru', $request->id_guru);
        $this->setIfNotEmpty($filter, 'id_absensi', $request->id_absensi);
        $list = $this->absensiRepository->getAbsensi((array)$filter);

        $this->output->responseCode = "00";
        $this->output->responseDesc = "Sukses inquiry Absensi";
        $this->output->responseData = $list;

        return response()->json($this->output);
    }

    public function create(Request $request)
    {
        $absensi = new Absensi();
        $absensi->kelas_id = $request->kelas_id;
        $absensi->guru_id = $request->guru_id;
        $absensi->mapel_id = $request->mapel_id;
        $absensi->jamMulai = $request->jamMulai;
        $absensi->jamAkhir = $request->jamAkhir;
        $this->absensiRepository->createAbsensi($absensi);

        $this->output->responseCode = '00';
        $this->output->responseDesc = 'Sukses menambahkan data Absensi';

        return response()->json($this->output);
    }

    public function update(Request $request) {
        $absensi = new Absensi();
        $this->setIfNotEmpty($absensi, 'kelas_id', $request->kelas_id);
        $this->setIfNotEmpty($absensi, 'guru_id', $request->guru_id);
        $this->setIfNotEmpty($absensi, 'mapel_id', $request->mapel_id);
        $this->setIfNotEmpty($absensi, 'jamMulai', $request->jamMulai);
        $this->setIfNotEmpty($absensi, 'jamAkhir', $request->jamAkhir);
        $this->absensiRepository->updateAbsensi($absensi, $request->id_absensi);

        $this->output->responseCode = '00';
        $this->output->responseDesc = 'Sukses mengupdate data Absensi';

        return response()->json($this->output);
    }

    public function delete(Request $request) {
        $this->absensiRepository->deleteAbsensi(['id' => $request->id]);

        $this->output->responseCode = '00';
        $this->output->responseDesc = 'Sukses menghapus data Absensi';

        return response()->json($this->output);
    }
}
