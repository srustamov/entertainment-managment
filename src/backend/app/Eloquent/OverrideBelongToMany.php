<?php


namespace App\Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

trait OverrideBelongToMany
{
    /**
     * @param Builder $query
     * @param Model $parent
     * @param $table
     * @param $foreignPivotKey
     * @param $relatedPivotKey
     * @param $parentKey
     * @param $relatedKey
     * @param null $relationName
     * @return BelongsToManyOrOne
     */
    protected function newBelongsToMany(
        Builder $query,
        Model $parent,
                $table,
                $foreignPivotKey,
                $relatedPivotKey,
                $parentKey,
                $relatedKey,
                $relationName = null
    ): BelongsToManyOrOne
    {
        return new BelongsToManyOrOne($query, $parent, $table, $foreignPivotKey, $relatedPivotKey, $parentKey, $relatedKey, $relationName);
    }
}
