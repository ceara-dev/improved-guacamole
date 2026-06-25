<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PontoTuristico extends Model
{
    protected $table = 'pontos_turisticos';
    protected $fillable = [
        'nome',
        'descricao',
        'descricao_curta',
        'imagem',
        'imagens',
        'video_url',
        'cidade',
        'estado',
        'categoria',
        'avaliacao',
        'latitude',
        'longitude',
        'horario_funcionamento',
        'preco_entrada',
        'tags',
        'visualizacoes',
        'curtidas',
        'publicado_em',
        'ativo',
    ];

    protected function casts(): array
    {
        return [
            'avaliacao' => 'decimal:1',
            'latitude' => 'decimal:7',
            'longitude' => 'decimal:7',
            'preco_entrada' => 'decimal:2',
            'tags' => 'array',
            'imagens' => 'array',
            'visualizacoes' => 'integer',
            'curtidas' => 'integer',
            'publicado_em' => 'datetime',
            'ativo' => 'boolean',
        ];
    }

    public function scopeBusca($query, ?string $search)
    {
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nome', 'like', "%{$search}%")
                  ->orWhere('descricao', 'like', "%{$search}%")
                  ->orWhere('descricao_curta', 'like', "%{$search}%");
            });
        }
    }

    public function scopePorCategoria($query, ?string $categoria)
    {
        if ($categoria) {
            $query->where('categoria', $categoria);
        }
    }

    public function scopePorEstado($query, ?string $uf)
    {
        if ($uf) {
            $query->where('estado', $uf);
        }
    }

    public function scopePorCidade($query, ?string $cidade)
    {
        if ($cidade) {
            $query->where('cidade', $cidade);
        }
    }

    public function scopeOrdenar($query, ?string $sort)
    {
        match ($sort) {
            'antigos' => $query->oldest(),
            'melhores' => $query->orderByDesc('avaliacao'),
            'visualizados' => $query->orderByDesc('visualizacoes'),
            default => $query->latest(),
        };
    }

    public function getEstrelasAttribute(): string
    {
        $cheia = floor($this->avaliacao);
        $metade = ($this->avaliacao - $cheia) >= 0.5 ? 1 : 0;
        $vazia = 5 - $cheia - $metade;
        return str_repeat('★', $cheia)
            . ($metade ? '½' : '')
            . str_repeat('☆', $vazia);
    }

    public function comentarios()
    {
        return $this->hasMany(Comentario::class);
    }

    public function usersFavoritaram()
    {
        return $this->belongsToMany(User::class, 'favoritos', 'ponto_turistico_id', 'user_id')
            ->withTimestamps();
    }

    public function getCategoriaIconeAttribute(): string
    {
        return match ($this->categoria) {
            'Parque' => '🌳',
            'Museu' => '🏛️',
            'Cultural' => '🎭',
            'Igreja' => '⛪',
            'Praia' => '🏖️',
            'Natural' => '🌿',
            'Gastronômico' => '🍽️',
            'Monumento' => '🗿',
            'Aventura' => '🎢',
            'Histórico' => '🏰',
            default => '📍',
        };
    }
}
