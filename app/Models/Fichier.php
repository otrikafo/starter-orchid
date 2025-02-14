<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Fichier extends Model
{
    use HasFactory;

    protected $table = 'fichiers';
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
        'chemin',
        'nom_fichier',
        'mime_type',
        'taille',
    ];

    /**
     * The biens that belong to the Fichier (images secondaires).
     */
    public function biensSecondaires(): BelongsToMany
    {
        return $this->belongsToMany(Bien::class, 'images_secondaires', 'fichier_id', 'bien_id');
    }
}
