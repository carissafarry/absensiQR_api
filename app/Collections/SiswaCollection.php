<?php

declare(strict_types=1);

namespace App\Collections;

use App\Models\Siswa;
use Illuminate\Database\Eloquent\Collection;

class SiswaCollection extends Collection
{
    public function __construct(mixed $array)
    {
        $newarray = [];
        foreach ($array as $row) {
            $newarray[] = $row instanceof Siswa ? $row : new Siswa((array) $row);
        }
        parent::__construct($newarray);
    }
}
