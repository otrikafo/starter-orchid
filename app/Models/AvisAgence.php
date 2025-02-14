<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Orchid\Screen\AsSource;
use Orchid\Attachment\Attachable;
use Orchid\Filters\Filterable;
use Illuminate\Support\Str;

class AvisAgence extends Model
{
    use HasFactory, AsSource, Filterable, Attachable;

    protected $table = 'avis_agences';
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
        'visiteur_id',
        'note',
        'commentaire',
    ];

    /**
     * Get the agence that owns the AvisAgence.
     */
    public function agence(): BelongsTo
    {
        return $this->belongsTo(Agence::class, 'agence_id');
    }

    /**
     * Get the visiteur that owns the AvisAgence.
     */
    public function visiteur(): BelongsTo
    {
        return $this->belongsTo(Visiteur::class, 'visiteur_id');
    }
}
