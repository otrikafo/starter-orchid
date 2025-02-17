<?php

namespace App\Orchid\Resources;

use App\Models\Agence;
use App\Models\Bien;
use App\Models\Fichier;
use Orchid\Crud\Resource;
use Orchid\Screen\Fields\Attach;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\TD;

class Biens extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = Bien::class;

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
            // Relation::make('images_secondaires')
            //     ->fromModel(Fichier::class, 'nom_fichier')
            //     ->title('Images secondaires'),
            Attach::make('images_secondaires')
                ->multiple()
                ->title('Ajouter les images')
                ->horizontal(),
            Input::make('titre')
                ->title('Titre'),
            Input::make('description')
                ->title('Description'),
            Input::make('prix')
                ->title('Prix'),
            Input::make('adresse')
                ->title('Adresse'),
            Input::make('ville')
                ->title('Ville'),
            Input::make('superficie')
                ->title('Superficie'),
            Select::make('nombre_pieces')
                ->options([
                    '1' => '1',
                    '2' => '2',
                    '3' => '3',
                    '4' => '4',
                    '5' => '5',
                    '6' => '6',
                    '7' => '7',
                    '8' => '8',
                    '9' => '9',
                    '10' => '10',
                ])
                ->title('Nombre de pièces'),
            Select::make('nombre_chambres')
                ->options([
                    '1' => '1',
                    '2' => '2',
                    '3' => '3',
                    '4' => '4',
                    '5' => '5',
                    '6' => '6',
                    '7' => '7',
                    '8' => '8',
                    '9' => '9',
                    '10' => '10',
                ])
                ->title('Nombre de chambres'),
            Select::make('nombre_salles_de_bain')
                ->options([
                    '1' => '1',
                    '2' => '2',
                    '3' => '3',
                    '4' => '4',
                    '5' => '5',
                    '6' => '6',
                    '7' => '7',
                    '8' => '8',
                    '9' => '9',
                    '10' => '10',
                ])
                ->title('Nombre de salles de bain'),
            Input::make('image_principale')
                ->title('Image principale'),
            Select::make('type_bien')
                ->options([
                    'Appartement' => 'Appartement',
                    'Maison' => 'Maison',
                    'Villa' => 'Villa',
                    'Terrain' => 'Terrain',
                    'Local commercial' => 'Local commercial',
                    'Bureau' => 'Bureau',
                    'Immeuble' => 'Immeuble',
                    'Autre' => 'Autre',
                ])
                ->title('Type de bien'),
            Select::make('type_transaction')
                ->options([
                    'Vente' => 'Vente',
                    'Location' => 'Location',
                ])
                ->title('Type de transaction'),
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
            TD::make('image_principale', 'Main image')
                ->render(function ($model) {
                    // $model->image_principale = Fichier::find($model->image_principale);
                    // dump($model);
                    if ($model->image_principale) {
                        return "<img src='/storage/{$model->image_principale}' alt='{$model->image_principale}' style='max-width: 100px; max-height: 100px;'>";
                    }
                }),

            TD::make('titre', 'Title'),
            // Agence
            TD::make('agence_id', 'Agency')
                ->render(function ($model) {
                    return $model->agence->raison_sociale;
                }),
            TD::make('description', 'Description'),
            TD::make('prix', 'Price'),
            TD::make('adresse', 'Address'),
            TD::make('ville', 'City'),
            // TD::make('superficie', 'Area'),
            // TD::make('nombre_pieces', 'Number of rooms'),
            // TD::make('nombre_chambres', 'Number of bedrooms'),
            // TD::make('nombre_salles_de_bain', 'Number of bathrooms'),
            TD::make('type_bien', 'Type of property'),
            TD::make('type_transaction', 'Transaction type'),
            // Afficher l'imae principale

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
