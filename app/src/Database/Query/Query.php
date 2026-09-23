<?php

declare(strict_types=1);

namespace App\Database\Query;

interface Query
{
    public function build(): CompiledQuery;
}