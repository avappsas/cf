<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Oficina extends Model
{
    protected $table = 'Oficinas';
    protected $primaryKey = 'Id';
    public $timestamps = false; // si no tienes created_at/updated_at
}