<?php

declare(strict_types=1);

namespace App\Collections;

use App\Models\Guru;
use Illuminate\Database\Eloquent\Collection;

class GuruCollection extends Collection
{
    public function __construct(mixed $array)
    {
        $newarray = [];
        foreach ($array as $row) {
            $newarray[] = $row instanceof Guru ? $row : new Guru((array) $row);
        }
        parent::__construct($newarray);
    }
}
