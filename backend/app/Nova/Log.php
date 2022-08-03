<?php

namespace App\Nova;

use Illuminate\Http\Request;
use JetBrains\PhpStorm\Pure;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\KeyValue;
use Laravel\Nova\Fields\MorphTo;
use Laravel\Nova\Fields\Text;

class Log extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \Spatie\Activitylog\Models\Activity::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static string $title = 'log_name';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static array $search = [
        'id', 'description', 'event', 'subject_type', 'causer',
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
            Text::make('description')->readonly()->sortable(),
            Text::make('Type', 'subject_type')->readonly()->sortable(),
            Text::make('Subject id', 'subject_id')->readonly()->sortable(),
            Text::make('Event', 'event')->readonly()->sortable(),
            MorphTo::make('Couser', 'causer', User::class)->readonly(),
            DateTime::make('Created at', 'created_at')->sortable()->readonly(),
            Text::make('Properties', 'properties')->readonly(),
            //            KeyValue::make('Changes','properties**.attributes**')->readonly()

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
