<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CultivavidaGroupPerson extends Model
{
    use HasFactory;
    
    protected $table = 'cultivavida_group_person';

    // Definir los campos que pueden ser asignados en masa
    protected $fillable = [
        'cultivavida_group_id',
        'person_dni'
    ];

    // Relación con el modelo CultivavidaGroup
    public function group()
    {
        return $this->belongsTo(CultivavidaGroup::class, 'group_id');
    }

    // Relación con el modelo Person
    public function person()
    {
        return $this->belongsTo(Person::class, 'person_dni', 'dni');
    }
}
