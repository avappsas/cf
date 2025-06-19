<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Objeto;
use App\Models\Tipo_Bienes;


class Biene extends Model
{
    use HasFactory;

    protected $table = 'bienes';

    // Especificar el nombre de la columna primaria
    protected $primaryKey = 'id_bien';

    // Permitir que Laravel reconozca la relación con el caso
    protected $fillable = ['id_caso', 'bien_asegurado', 'objeto', 'tipo', 'caracteristicas', 'fotos', 'detalles'];

    public $timestamps = false; // Si no usas columnas de timestamps (created_at, updated_at)

 

    // Relación con Caso (si tienes el modelo Caso configurado)
    public function caso()
    {
        return $this->belongsTo(Caso::class, 'id_Caso');
    }
 
    public function valoraciones()
    {
        return $this->hasMany(Valoracione::class, 'id_bien', 'id_bien');
    }

    // Definir la relación con el modelo Objeto
    public function objetoRelacionado()
    {
        return $this->belongsTo(Objeto::class, 'objeto', 'id');
    }

    public function imagenes()
    {
        return $this->hasMany(Image::class, 'id_bien', 'id_bien');
    }

    public function tipoBienes()
    {
        return $this->belongsTo(Tipo_Bienes::class, 'tipo', 'id');
    }
    
}
