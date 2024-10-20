<?php

declare(strict_types=1);

namespace App\Collections;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class UsersCollection extends Collection
{
    public function __construct(mixed $array)
    {
        $newarray = [];
        foreach ($array as $row) {
            $newarray[] = $row instanceof User ? $row : new User((array) $row);
        }
        parent::__construct($newarray);
    }
}
