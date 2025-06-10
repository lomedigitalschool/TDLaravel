<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JournalEntry extends Model
{
    use HasFactory;

    protected $fillable = [
        'titre',
        'contenu',
        'humeur',
        'image',
        'est_public',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

