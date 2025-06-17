<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Masukan extends Model
{
    protected $table = 'masukan';

    protected $fillable = [
        'user_id', 'pesan'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}