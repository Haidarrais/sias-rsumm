<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'type', 'description', 'status'];
}
// $table->bigInteger('user_id');
// $table->integer('type')->comment('1 : inbox; 2 : outbox; 3 : disposition');
// $table->integer('status')->comment('0 : unread; 1 : read;');
// $table->string('description');