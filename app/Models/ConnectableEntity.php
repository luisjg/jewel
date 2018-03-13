<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConnectableEntity extends Model {
    protected $table='faculty.connectable';     // Overrides convention of table name being departments
    protected $primaryKey = 'connectable_id';   // Override convention of PK being 'id'
    public $incrementing = false;
}
