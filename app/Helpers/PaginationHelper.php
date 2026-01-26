<?php

namespace App\Helpers;
use Illuminate\Pagination\LengthAwarePaginator;
class PaginationHelper
{
    public static function getStartingNumber($paginator)
    {
        return ($paginator->currentPage() - 1) * $paginator->perPage() + 1;
    }
}
