<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PublicacionModel extends Model
{
    protected $table = 'publicacion';

    protected $fillable = [ 'fk_usuario_id', 'contenido', 'url_publicacion'];
}
