<?php

namespace App\Orchid\Resources;

use App\Models\Agence;
use App\Models\AvisAgence;
use App\Models\Visiteur;
use Orchid\Crud\Resource;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\TD;

class AvisAgenceRessource extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = AvisAgence::class;

    /**
     * Get the fields displayed by the resource.
     *
     * @return array
     */
    public function fields(): array
    {
        return [
            Relation::make('agence_id')
                ->fromModel(Agence::class, 'raison_sociale')
                ->title('Agence'),
            Relation::make('visiteur_id')
                ->fromModel(Visiteur::class, 'nom')
                ->title('Visiteur'),
            Input::make('note')
                ->title('Note'),
            Input::make('commentaire')
                ->title('Commentaire'),
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
            TD::make('agence_id', 'Agence')
                ->render(function ($model) {
                    return $model->agence->raison_sociale;
                }),
            TD::make('visiteur_id', 'Visiteur')
                ->render(function ($model) {
                    return $model->visiteur->nom;
                }),
            TD::make('note', 'Note'),
            TD::make('commentaire', 'Commentaire'),
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
