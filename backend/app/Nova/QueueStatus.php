<?php

namespace App\Nova;

use App\Nova\Filters\LocationFilter;
use Illuminate\Http\Request;
use JetBrains\PhpStorm\Pure;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Yna\NovaSwatches\Swatches;

class QueueStatus extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\QueueStatus::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static string $title = 'name';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static array $search = [
        'id', 'name', 'status',
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            //ID::make(__('ID'), 'id')->sortable(),
            Text::make('Ad', 'name')->sortable()
                ->rules([
                    'required',
                    'string',
                ]),
            Text::make('Status', 'status')->sortable()
                ->rules([
                    'required',
                    'numeric',
                ]),
            Swatches::make('Color', 'color')->rules(['required']),
        ];
    }

    public static function authorizedToCreate(Request $request)
    {
        return false;
    }

    public function authorizedToUpdate(Request $request)
    {
        return false;
    }

    public function authorizedToDelete(Request $request)
    {
        return false;
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    #[Pure]
    public function cards(Request $request): array
    {
        return [
        ];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function filters(Request $request): array
    {
        return [
            new LocationFilter(),
        ];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function lenses(Request $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function actions(Request $request)
    {
        return [];
    }
}
