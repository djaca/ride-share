<?php

namespace App;

use Illuminate\Database\Eloquent\Collection;

class EnrouteCitiesCollection extends Collection
{
    public function findByName($name)
    {
        return collect($this->items)
            ->first(function ($value, $key) use ($name) {
                return $value->city->name == $name;
            });
    }
}
