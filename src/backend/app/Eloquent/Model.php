<?php

namespace App\Eloquent;


use App\Models\Components\Filterable;
use Closure;
use Exception;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;


/**
 * @property mixed $id
 */
class Model extends \Illuminate\Database\Eloquent\Model
{
    use Filterable;


    public static function begin(Closure $callback,Closure $catch = null)
    {
        DB::beginTransaction();

        try
        {
            $callback(); DB::commit();
        }
        catch (Exception $exception) {

            DB::rollBack();

            if ($catch) {
                return $catch($exception);
            }

            throw $exception;
        }
    }
}
