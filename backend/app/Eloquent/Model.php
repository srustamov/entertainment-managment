<?php

namespace App\Eloquent;


use App\Models\Components\Filterable;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;


/**
 * @property mixed $id
 */
class Model extends \Illuminate\Database\Eloquent\Model
{
    use Filterable;
}
