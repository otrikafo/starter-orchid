<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Orchid\Screen\AsSource;
use Orchid\Attachment\Attachable;
use Orchid\Filters\Filterable;
use Illuminate\Support\Str;

class Visiteur extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, AsSource, Filterable, Attachable;

    protected $table = 'visiteurs';
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
        'email',
        'password',
        'nom',
        'prenom',
        'adresse',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Get the contacts associated with the Visiteur.
     */
    public function contacts(): HasMany
    {
        return $this->hasMany(Contact::class, 'visiteur_id');
    }

    /**
     * Get the avisAgences associated with the Visiteur.
     */
    public function avisAgences(): HasMany
    {
        return $this->hasMany(AvisAgence::class, 'visiteur_id');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->id = Str::uuid(); // Generate UUID on creation
        });
    }

    // Messsages
    public function messages()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }
}
