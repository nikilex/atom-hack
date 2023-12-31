<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Backpack\CRUD\app\Models\Traits\CrudTrait;

class OperationQueue extends Model
{
    use HasFactory;
 //   use \Backpack\CRUD\app\Models\Traits\HasIdentifiableAttribute;
    use CrudTrait;

    protected $table = 'operation_queue';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    // protected $fillable = [];
    // protected $hidden = [];
    // protected $dates = [];
}
