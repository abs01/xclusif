<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sponsors extends Model
//Esta tabla está aislada del resto de la estructura. Principalmente con el objetivo de guardar la publicidad que se muestra en la plataforma
{
    protected $fillable = [
        'company_name',
        'content',
        'file_path',
        'publicity_url',
        'is_active',
    ];
}
