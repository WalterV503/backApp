<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PublicacionFotoModel extends Model
{
    protected $table = 'publicacion_foto';
    protected $primaryKey = 'fk_publicacion_id';
    protected $fillable = ['fk_publicacion_id', 'fk_foto_id'];
}
