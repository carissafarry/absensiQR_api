<?php

declare(strict_types=1);

namespace App\Collections;

use App\Models\AbsensiSiswa;
use Illuminate\Database\Eloquent\Collection;

class AbsensiSiswaCollection extends Collection
{
    public function __construct(mixed $array)
    {
        $newarray = [];
        foreach ($array as $row) {
            $newarray[] = $row instanceof AbsensiSiswa ? $row : new AbsensiSiswa((array) $row);
        }
        parent::__construct($newarray);
    }
}
