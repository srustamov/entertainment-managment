<?php

namespace App\Nova;

use Illuminate\Http\Request;
use JetBrains\PhpStorm\Pure;
use Laravel\Nova\Cards\Help;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class ActivityItem extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\ActivityItem::class;

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
        'id','name','color','price','size','period'
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
            ID::make(__('ID'), 'id')->sortable(),

            BelongsTo::make('Activity'),

            Text::make('Name','name')->sortable()
                ->rules('required', 'max:255'),
            Text::make('Color','color')->sortable()
                ->rules( 'max:255'),
            Text::make('Price','price')->sortable()
                ->rules( 'required', 'max:255'),
            Text::make('Period','period')->sortable()
                ->rules( 'required', 'max:255'),
        ];
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
    public function filters(Request $request) : array
    {
        return [
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
