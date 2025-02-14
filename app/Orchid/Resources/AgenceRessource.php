<?php

namespace App\Orchid\Resources;

use App\Models\Agence;
use Orchid\Crud\Resource;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Sight;
use Orchid\Screen\TD;

class AgenceRessource extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = Agence::class;

    /**
     * Get the fields displayed by the resource.
     *
     * @return array
     */
    public function fields(): array
    {
        return [
            Input::make('raison_sociale')
                ->title('Raison Sociale')
                ->placeholder('Enter Raison Sociale here'),
            Input::make('siege')
                ->title('Siege')
                ->placeholder('Enter Siege here'),
            Input::make('nif')
                ->title('Nif')
                ->placeholder('Enter Nif here'),
            Input::make('stat')
                ->title('Stat')
                ->placeholder('Enter Stat here'),
            Input::make('email')
                ->title('Email')
                ->placeholder('Enter Email here'),
            Input::make('password')
                ->title('Password')
                ->placeholder('Enter Password here'),
        ];
    }

    /**
     * Get the columns displayed by the resource.
     *
     * @return TD[]
     */
    public function columns(): array
    {
        return [
            TD::make('id'),
            TD::make('raison_sociale', 'Raison Sociale'),
            TD::make('siege'),
            TD::make('nif'),
            TD::make('stat'),
            TD::make('email'),
            TD::make('created_at', 'Date of creation')
                ->render(function ($model) {
                    return $model->created_at->toDateTimeString();
                }),

            TD::make('updated_at', 'Update date')
                ->render(function ($model) {
                    return $model->updated_at->toDateTimeString();
                }),
        ];
    }

    /**
     * Get the sights displayed by the resource.
     *
     * @return Sight[]
     */
    public function legend(): array
    {
        return [
            Sight::make('id'),
            Sight::make('raison_sociale'),
            Sight::make('siege'),
            Sight::make('nif'),
            Sight::make('stat'),
        ];
    }

    /**
     * Get the filters available for the resource.
     *
     * @return array
     */
    public function filters(): array
    {
        return [];
    }
}
