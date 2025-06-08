<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JournalEntry extends Model
{
    public function user()
{
    return $this->belongsTo(User::class);
}

}
