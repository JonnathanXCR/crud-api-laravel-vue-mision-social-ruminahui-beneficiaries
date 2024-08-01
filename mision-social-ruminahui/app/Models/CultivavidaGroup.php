<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CultivavidaGroup extends Model
{
    use HasFactory;

    protected $table = 'cultivavida_groups';

    // Definir los campos que pueden ser asignados en masa
    protected $fillable = [
        'tutor',
        'description'
    ];

    // Relación con el modelo User
    public function tutorUser()
    {
        return $this->belongsTo(User::class, 'tutor');
    }
}
