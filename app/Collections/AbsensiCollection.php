<?php

declare(strict_types=1);

namespace App\Collections;

use App\Models\Absensi;
use Illuminate\Database\Eloquent\Collection;

class AbsensiCollection extends Collection
{
    public function __construct(mixed $array)
    {
        $newarray = [];
        foreach ($array as $row) {
            $newarray[] = $row instanceof Absensi ? $row : new Absensi((array) $row);
        }
        parent::__construct($newarray);
    }
}
