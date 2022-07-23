<?php

namespace App\Eloquent;


use App\Eloquent\Traits\Filterable;


/**
 * @property mixed $id
 */
class Model extends \Illuminate\Database\Eloquent\Model
{
    use Filterable;
}
