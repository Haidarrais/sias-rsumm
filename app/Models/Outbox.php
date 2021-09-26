<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Outbox extends Model
{
    use HasFactory;
    protected $table = 'outbox';
    protected $fillable = [
        'user_id',
        'journal_id',
        'outbox_number',
        'sender',
        'regarding',
        'destination',
        'entry_date',
        'outbox_origin',
        'type_id',
        'notes',
        'status',
        'file'
    ];
    public function type(){
        return $this->BelongsTo(Type::class, 'type_id');
    }
}

