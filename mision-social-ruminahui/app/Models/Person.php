<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    use HasFactory;

    // Definir el nombre de la tabla explícitamente
    protected $table = 'persons';

    // Definir la clave primaria
    protected $primaryKey = 'dni';
    
    // Indicar que la clave primaria no es auto-incremental
    public $incrementing = false;

    // Definir el tipo de la clave primaria
    protected $keyType = 'string';

    // Definir los campos que pueden ser asignados en masa
    protected $fillable = [
        'dni',
        'name',
        'last_name',
        'email',
        'birthday',
        'gender',
        'address',
        'phone',
        'neighborhood_id',
        'user_id'
    ];

    // Ocultar los campos que no deberían estar disponibles en JSON
    protected $hidden = [];

    // Definir las relaciones si las hay
    public function user()
    {
        return $this->hasOne(User::class);
    }

    // Relación con el modelo Neighborhood
    public function neighborhood()
    {
        return $this->belongsTo(Neighborhood::class);
    }
}
