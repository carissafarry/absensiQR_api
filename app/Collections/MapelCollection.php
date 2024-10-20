<?php

declare(strict_types=1);

namespace App\Collections;

use App\Models\MataPelajaran;
use Illuminate\Database\Eloquent\Collection;

class MapelCollection extends Collection
{
    public function __construct(mixed $array)
    {
        $newarray = [];
        foreach ($array as $row) {
            $newarray[] = $row instanceof MataPelajaran ? $row : new MataPelajaran((array) $row);
        }
        parent::__construct($newarray);
    }
}
