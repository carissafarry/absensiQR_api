<?php

declare(strict_types=1);

namespace App\Collections;

use App\Models\Kelas;
use Illuminate\Database\Eloquent\Collection;

class KelasCollection extends Collection
{
    public function __construct(mixed $array)
    {
        $newarray = [];
        foreach ($array as $row) {
            $newarray[] = $row instanceof Kelas ? $row : new Kelas((array) $row);
        }
        parent::__construct($newarray);
    }
}
