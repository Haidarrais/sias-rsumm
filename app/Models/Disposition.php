<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Disposition extends Model
{
    protected $table = 'disposition';
    use HasFactory;
    protected $fillable = [
        'surat_id',
        'tujuan',
        'catatan',
        'created_at',
        'updated_at',
    ];
    public function inbox(){
        return $this->BelongsTo(Inbox::class, 'surat_id');
    }
}
