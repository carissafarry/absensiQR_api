<?php

namespace App\Models;

use App\Collections\AbsensiCollection;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;

class Absensi extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable, HasFactory;

    protected $casts = [
        'id' => 'integer',
        'id_absensi' => 'integer',
        'kelas_id' => 'integer',
        'nama_kelas' => 'string',
        'guru_id' => 'integer',
        'nama_guru' => 'string',
        'mapel_id' => 'integer',
        'mata_pelajaran' => 'string',
        'jenjang' => 'string',
        'jamMulai' => 'datetime:Y-m-d H:i:s',
        'jamAkhir' => 'datetime:Y-m-d H:i:s',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'id',
        // 'id_absensi', // for request
        'kelas_id',
        // 'nama_kelas' => 'string', // for request
        'guru_id',
        // 'nama_guru', // for request
        'mapel_id',
        // 'mata_pelajaran', // for request
        // 'jenjang', // for request
        'jamMulai',
        'jamAkhir',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var string[]
     */
    protected $hidden = [];

    /**
     * Create a new Eloquent Collection instance.
     *
     * @param  array  $models
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function newCollection(array $models = [])
    {
        return new AbsensiCollection($models);
    }
}