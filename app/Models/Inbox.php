<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Inbox extends Model
{
    use HasFactory;
    protected $table = 'inbox';
    protected $fillable = [
        'user_id',
        'journal_id',
        'inbox_number',
        'sender',
        'regarding',
        'entry_date',
        'inbox_origin',
        'type_id',
        'notes',
        'status',
        'file'
    ];
    public function type(){
        return $this->BelongsTo(Type::class, 'type_id');
    }
}

