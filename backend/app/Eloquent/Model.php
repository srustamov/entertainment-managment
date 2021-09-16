<?php

namespace App\Eloquent;


use App\Models\Components\Filterable;


/**
 * @property mixed $id
 */
class Model extends \Illuminate\Database\Eloquent\Model
{
    use Filterable;
}
