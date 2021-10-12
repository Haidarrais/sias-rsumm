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
        'division_id',
        'catatan',
        'created_at',
        'updated_at',
    ];
    public function mail(){
        return $this->BelongsTo(Mail::class, 'mail_id');
    }
}
