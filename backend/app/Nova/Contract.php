<?php

namespace App\Nova;

use Illuminate\Http\Request;
use JetBrains\PhpStorm\Pure;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Textarea;

class Contract extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Contract::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    //public static string $title = 'start_date';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static array $search = [
        'start_date',
        'expire_date',
        'description',
        'price',
        'custom_data',
        'status',
    ];


    public function title()
    {
        return $this->location->name ?? "";
    }

    /**
     * Get the fields displayed by the resource.
     *
     * @param Request $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            ID::make(__('ID'), 'id')->sortable(),

            BelongsTo::make('Location'),
            BelongsTo::make('Client', 'user'),

            Date::make('Start Date', 'start_date')->sortable()
                ->rules('required', 'string'),
            Date::make('Expire Date', 'expire_date')->sortable()
                ->rules('required', 'string'),
            Textarea::make('Description', 'description')->sortable()
                ->rules('required', 'string'),
            Number::make('Price', 'price')->sortable()
                ->rules('required', 'numeric'),

            Boolean::make('Bitib', function ($contract) {
                return $contract->expire_date < now()->format('Y-m-d H:i:s');
            })
                ->sortable()
                ->trueValue(true)
                ->falseValue(false),

            Boolean::make('Active', 'status')
                ->trueValue('1')
                ->falseValue('0')
                ->creationRules('required', 'numeric', 'min:0', 'max:1')
                ->updateRules('required', 'numeric', 'min:0', 'max:1'),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param Request $request
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
     * @param Request $request
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
     * @param Request $request
     * @return array
     */
    public function lenses(Request $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param Request $request
     * @return array
     */
    public function actions(Request $request)
    {
        return [];
    }
}
