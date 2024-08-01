<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Neighborhood extends Model
{
    use HasFactory;

    // Definir los campos que pueden ser asignados en masa
    protected $fillable = [
        'name',
        'description'
    ];

    // Relación con el modelo Person
    public function persons()
    {
        return $this->hasMany(Person::class);
    }
}
