<?php

namespace App\Nova;

use App\Nova\Filters\LocationFilter;
use Illuminate\Http\Request;
use JetBrains\PhpStorm\Pure;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\MorphTo;
use Laravel\Nova\Fields\Number;

class Queue extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Queue::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static string $title = 'number';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static array $search = [
        'id', 'number',
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
            BelongsTo::make('Location', 'location')->sortable(),

            BelongsTo::make('Status', 'status', QueueStatus::class),

            MorphTo::make('Tip', 'queueable')->readonly(),

            Number::make('Növbə', 'number')->sortable()->readonly(),
            DateTime::make('Tarix', 'created_at')->sortable()->readonly(),
            DateTime::make('Başlama tarixi', 'started_at')->sortable()->nullable(),
            DateTime::make('Bitmə tarixi', 'end_at')->sortable()->nullable(),
        ];
    }

    public static function authorizedToCreate(Request $request)
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
