<?php

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;

class UserFilter extends QueryFilter
{
    public function search(?string $search): Builder
    {
        $likeStr = '%' . $search . '%';

        return $this->builder->
            where('name', 'like', $likeStr)
            ->orWhere('email', 'like', $likeStr);
    }
}
