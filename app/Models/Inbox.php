<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        'notes',
        'status',
        'file'
    ];
}
