<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FotoModel extends Model
{
    protected $table = 'foto';
    protected $fillable = ['fk_usuario_id', 'fk_tipoFoto_id', 'url_foto', 'fecha_subida'];
}
