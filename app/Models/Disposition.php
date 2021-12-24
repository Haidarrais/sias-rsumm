<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Disposition extends Model
{
    protected $table = 'disposition';
    use HasFactory;
    protected $fillable = [
        'mail_id',
        'user_id',
        'catatan',
        'status',
        'urgency',
        'file',
        'type',
        'created_at',
        'updated_at',
    ];
    public function mail(){
        return $this->BelongsTo(Mail::class, 'mail_id');
    }
    public function user(){
        return $this->BelongsTo(User::class, 'user_id');
    }
}
