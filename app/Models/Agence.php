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

class Agence extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, AsSource, Filterable, Attachable;

    protected $table = 'agences';
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
        'raison_sociale',
        'siege',
        'nif',
        'stat',
        'email',
        'password',
        'is_validated',
        'validated_at',
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
        'is_validated' => 'boolean',
        'validated_at' => 'datetime',
    ];

    /**
     * Get the biens associated with the Agence.
     */
    public function biens(): HasMany
    {
        return $this->hasMany(Bien::class, 'agence_id');
    }

    /**
     * Get the avisAgences associated with the Agence.
     */
    public function avisAgences(): HasMany
    {
        return $this->hasMany(AvisAgence::class, 'agence_id');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->id = Str::uuid(); // Generate UUID on creation
        });
    }

    public function messages()
    {
        return $this->morphMany(Message::class, 'sender');
    }
}
