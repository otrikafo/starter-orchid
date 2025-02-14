<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Orchid\Screen\AsSource;
use Orchid\Attachment\Attachable;
use Orchid\Filters\Filterable;
use Illuminate\Support\Str;

class Bien extends Model
{
    use HasFactory, AsSource, Filterable, Attachable;

    protected $table = 'biens';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'agence_id',
        'titre',
        'description',
        'prix',
        'adresse',
        'ville',
        'superficie',
        'nombre_pieces',
        'nombre_chambres',
        'nombre_salles_de_bain',
        'type_bien',
        'type_transaction',
        'image_principale',
    ];

    /**
     * Get the agence that owns the Bien.
     */
    public function agence(): BelongsTo
    {
        return $this->belongsTo(Agence::class, 'agence_id');
    }

    /**
     * The fichiers that belong to the Bien (images secondaires).
     */
    public function imagesSecondaires(): BelongsToMany
    {
        return $this->belongsToMany(Fichier::class, 'images_secondaires', 'bien_id', 'fichier_id');
    }

    /**
     * Get the contacts associated with the Bien.
     */
    public function contacts(): HasMany
    {
        return $this->hasMany(Contact::class, 'bien_id');
    }

    // Définir les enums ici pour la validation (si vous souhaitez la centraliser dans le modèle)
    public const TYPE_BIEN_ENUM = ['maison', 'appartement', 'terrain', 'commerce'];
    public const TYPE_TRANSACTION_ENUM = ['vente', 'location'];
}
