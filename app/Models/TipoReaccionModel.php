<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoReaccionModel extends Model
{
    protected $table = 'tipo_reaccion';
    protected $fillable = ['Nombre_Reaccion'];
}
