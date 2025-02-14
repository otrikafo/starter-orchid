<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Orchid\Screen\AsSource;
use Orchid\Attachment\Attachable;
use Orchid\Filters\Filterable;
use Illuminate\Support\Str;

class Contact extends Model
{
    use HasFactory, AsSource, Filterable, Attachable;

    protected $table = 'contacts';
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
        'bien_id',
        'visiteur_id',
        'agence_id',
        'message',
    ];

    /**
     * Get the bien that owns the Contact.
     */
    public function bien(): BelongsTo
    {
        return $this->belongsTo(Bien::class, 'bien_id');
    }

    /**
     * Get the visiteur that owns the Contact.
     */
    public function visiteur(): BelongsTo
    {
        return $this->belongsTo(Visiteur::class, 'visiteur_id');
    }

    /**
     * Get the agence that owns the Contact.
     */
    public function agence(): BelongsTo
    {
        return $this->belongsTo(Agence::class, 'agence_id');
    }
}
