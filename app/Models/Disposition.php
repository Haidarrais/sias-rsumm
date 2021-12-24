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
        'tujuan',
        'catatan',
        'status',
        'urgency',
        'file',
        'type',
        'created_at',
        'updated_at',
    ];
    public function scopeKaryawan($query)
    {
        $query->where('type', 5);
    }
    public function scopeKabid($query)
    {
        $query->where('type', 4);
    }
    public function scopeWadir($query)
    {
        $query->where('type', 3);
    }
    public function mail(){
        return $this->BelongsTo(Mail::class, 'mail_id');
    }
}
