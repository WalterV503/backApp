<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReaccionModel extends Model
{
    protected $table ='reaccion';
    protected $fillable = [
        'fk_usuario_id',
        'fk_publicacion_id',
        'fk_tipoReaccion_id',
        'fecha_reaccion',
    ];
}
