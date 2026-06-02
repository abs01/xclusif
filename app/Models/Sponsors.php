<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sponsors extends Model
{
    protected $fillable = [
        'company_name',
        'content',
        'file_path',
        'publicity_url',
        'is_active',
    ];
}
