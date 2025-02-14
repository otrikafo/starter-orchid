<?php

namespace App\Orchid\Resources;

use App\Models\Visiteur;
use Orchid\Crud\Resource;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\TD;

class VisiteurRessource extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = Visiteur::class;

    /**
     * Get the fields displayed by the resource.
     *
     * @return array
     */
    public function fields(): array
    {
        return [
            Input::make('email')
                ->title('Email')
                ->placeholder('Enter Email here'),
            Input::make('password')
                ->title('Password')
                ->placeholder('Enter Password here'),
            Input::make('nom')
                ->title('Nom')
                ->placeholder('Enter Nom here'),
            Input::make('prenom')
                ->title('Prenom')
                ->placeholder('Enter Prenom here'),
            Input::make('adresse')
                ->title('Adresse')
                ->placeholder('Enter Adresse here'),
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
            TD::make('email', 'Email'),
            TD::make('nom', 'Nom'),
            TD::make('prenom', 'Prenom'),
            TD::make('adresse', 'Adresse'),

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
        return [];
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
