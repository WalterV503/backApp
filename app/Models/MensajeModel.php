<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MensajeModel extends Model
{
    protected $table = 'mensaje';
    protected $fillable = ['fk_usuario_emisor_id', 'fk_usuario_receptor_id', 'contenido', 'estado', 'tipo_mensaje', 'referencia_mensaje', 'fecha_envio'];
}
