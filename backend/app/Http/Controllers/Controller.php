<?php

namespace App\Http\Controllers;

use App\Eloquent\Traits\Filterable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use InvalidArgumentException;

class Controller extends BaseController
{
    use AuthorizesRequests;
    use DispatchesJobs;
    use ValidatesRequests;


    public function useFilter(
        Model|Relation|Builder|string $model,
        ?Request $request = null,
        array $filters = []
    )
    {
        if (is_string($model)) {
            if (class_exists($model) && is_subclass_of($model, Model::class)) {
                $model = new $model;
            } else {
                throw new InvalidArgumentException('Invalid model class');
            }
        }

        if ($model instanceof Model) {

            if (in_array(Filterable::class, class_uses_recursive($model))) {
                /**@var $model Filterable */
                $model = $model->asFilter(builder: $model)->first();
            }

            return $model;
        }

        $instance = $model->getModel();

        if (in_array(Filterable::class, class_uses_recursive($instance))) {
            /**@var $instance Filterable */
            $model = $instance->asFilter(filters: $filters, request: $request, builder: $model);
        }

        return $model;
    }
}
