<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comentario extends Model
{
    protected $fillable = [
        'ponto_turistico_id',
        'nome',
        'conteudo',
    ];

    public function pontoTuristico()
    {
        return $this->belongsTo(PontoTuristico::class);
    }
}
