<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mail extends Model
{
    use HasFactory;
    protected $fillable =
    [
        'user_id',
        'journal_id',
        'number',
        'sender',
        'destination',
        'regarding',
        'entry_date',
        'origin',
        'notes',
        'type_id',
        'mail_type',
        'status',
        'file',
    ];
    public function type()
    {
        return $this->belongsTo(Type::class);
    }
    public function disposition(){
        return $this->hasMany(Disposition::class, 'user_id', 'id');
    }
}
