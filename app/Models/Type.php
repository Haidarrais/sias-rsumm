<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    protected $table = 'types';
    use HasFactory;
    protected $fillable = [
        'name',
        'created_at',
        'updated_at',
    ];
    public function inbox(){
        return $this->HasMany(Inbox::class);
    }
}
