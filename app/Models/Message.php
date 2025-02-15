<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str; // Make sure to include this use statement

class Message extends Model
{
    // app/Message.php
    use HasFactory; // If you are using a Uuid trait

    public $incrementing = false; // **IMPORTANT: Disable auto-incrementing**

    protected $keyType = 'string'; // **IMPORTANT: Set key type to string for UUIDs**

    protected $primaryKey = 'id';
    /**
     * Fields that are mass assignable
     *
     * @var array
     */
    protected $fillable = ['message', 'sender_id', 'room_id', 'id'];

    /**
     * A message belong to a user
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sender()
    {
        return $this->belongsTo(Visiteur::class);
    }
}
