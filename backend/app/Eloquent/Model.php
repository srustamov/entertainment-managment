<?php

namespace App\Eloquent;

use App\Eloquent\Traits\Filterable;
use App\Eloquent\Traits\ResolveRouteBinding;

/**
 * @property mixed $id
 */
class Model extends \Illuminate\Database\Eloquent\Model
{
    use Filterable;
    use ResolveRouteBinding;
}
