<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ImageSecondaire extends Model
{
    use HasFactory;

    protected $table = 'images_secondaires';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'bien_id',
        'fichier_id',
        'id'
    ];

    /**
     * Get the bien that owns the ImageSecondaire.
     */
    public function bien(): BelongsTo
    {
        return $this->belongsTo(Bien::class, 'bien_id');
    }

    /**
     * Get the fichier that owns the ImageSecondaire.
     */
    public function fichier(): BelongsTo
    {
        return $this->belongsTo(Fichier::class, 'fichier_id');
    }
}
