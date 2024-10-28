<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Repositories\AbsensiRepository;
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
        $this->setIfNotEmpty($filter, 'siswa_id', $request->siswa_id);
        $list = $this->absensiRepository->getListAbsensi((array)$filter);

        $this->output->responseCode = "00";
        $this->output->responseDesc = "Sukses inquiry List Absensi";
        $this->output->responseData = $list;

        return response()->json($this->output);
    }

    public function getAbsensi(Request $request)
    {
        $filter = new stdClass();
        $this->setIfNotEmpty($filter, 'id_absensi', $request->id_absensi);
        $this->setIfNotEmpty($filter, 'kelas_id', $request->kelas_id);
        $this->setIfNotEmpty($filter, 'guru_id', $request->guru_id);
        $this->setIfNotEmpty($filter, 'mapel_id', $request->mapel_id);
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
        $absensi->guru_id = $request->id_guru;
        $absensi->mapel_id = $request->mapel_id;
        $absensi->jam_mulai = $request->jam_mulai;
        $absensi->jam_akhir = $request->jam_akhir;
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
        $this->setIfNotEmpty($absensi, 'jam_mulai', $request->jam_mulai);
        $this->setIfNotEmpty($absensi, 'jam_akhir', $request->jam_akhir);
        $this->absensiRepository->updateAbsensi($absensi, $request->id_absensi);

        $this->output->responseCode = '00';
        $this->output->responseDesc = 'Sukses mengupdate data Absensi';

        return response()->json($this->output);
    }

    public function delete(Request $request) {
        $this->absensiRepository->deleteAbsensi(['id_absensi' => $request->id]);

        $this->output->responseCode = '00';
        $this->output->responseDesc = 'Sukses menghapus data Absensi';

        return response()->json($this->output);
    }
}
