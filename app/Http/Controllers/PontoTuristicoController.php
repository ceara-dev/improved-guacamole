<?php

namespace App\Http\Controllers;

use App\Models\PontoTuristico;
use App\Models\Comentario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class PontoTuristicoController extends Controller
{
    public function index(Request $request)
    {
        $categorias = PontoTuristico::where('ativo', true)
            ->select('categoria')->distinct()->orderBy('categoria')->pluck('categoria');

        $cidades = PontoTuristico::where('ativo', true)
            ->select('cidade')->distinct()->orderBy('cidade')->pluck('cidade');

        $ufs = PontoTuristico::where('ativo', true)
            ->select('estado')->distinct()->orderBy('estado')->pluck('estado');

        $user = Auth::user();
        $favoritosIds = $user ? $user->favoritos()->pluck('ponto_turistico_id')->toArray() : [];

        $pontos = PontoTuristico::where('ativo', true)
            ->busca($request->search)
            ->porCategoria($request->categoria)
            ->porCidade($request->cidade)
            ->porEstado($request->uf)
            ->ordenar($request->sort)
            ->paginate(9)
            ->withQueryString()
            ->through(fn ($ponto) => [
                'id' => $ponto->id,
                'nome' => $ponto->nome,
                'descricao' => $ponto->descricao,
                'descricao_curta' => $ponto->descricao_curta,
                'imagem' => $ponto->imagem,
                'imagens_count' => count($ponto->imagens ?? []),
                'cidade' => $ponto->cidade,
                'estado' => $ponto->estado,
                'categoria' => $ponto->categoria,
                'categoria_icone' => $ponto->categoria_icone,
                'avaliacao' => $ponto->avaliacao,
                'curtidas' => $ponto->curtidas,
                'visualizacoes' => $ponto->visualizacoes,
                'publicado_em' => $ponto->publicado_em,
                'estrelas' => $ponto->estrelas,
                'favoritado' => in_array($ponto->id, $favoritosIds),
            ]);

        return Inertia::render('Home', [
            'pontos' => $pontos,
            'categorias' => $categorias,
            'cidades' => $cidades,
            'ufs' => $ufs,
            'filtros' => $request->only(['search', 'categoria', 'cidade', 'sort', 'uf']),
        ]);
    }

    public function favoritos(Request $request)
    {
        $user = Auth::user();
        $categorias = PontoTuristico::where('ativo', true)
            ->select('categoria')->distinct()->orderBy('categoria')->pluck('categoria');

        $pontos = $user->favoritos()
            ->where('ativo', true)
            ->busca($request->search)
            ->porCategoria($request->categoria)
            ->porCidade($request->cidade)
            ->porEstado($request->uf)
            ->ordenar($request->sort)
            ->paginate(9)
            ->withQueryString()
            ->through(fn ($ponto) => [
                'id' => $ponto->id,
                'nome' => $ponto->nome,
                'descricao' => $ponto->descricao,
                'descricao_curta' => $ponto->descricao_curta,
                'imagem' => $ponto->imagem,
                'imagens_count' => count($ponto->imagens ?? []),
                'cidade' => $ponto->cidade,
                'estado' => $ponto->estado,
                'categoria' => $ponto->categoria,
                'categoria_icone' => $ponto->categoria_icone,
                'avaliacao' => $ponto->avaliacao,
                'curtidas' => $ponto->curtidas,
                'visualizacoes' => $ponto->visualizacoes,
                'publicado_em' => $ponto->publicado_em,
                'estrelas' => $ponto->estrelas,
                'favoritado' => true,
            ]);

        return Inertia::render('Favoritos', [
            'pontos' => $pontos,
            'categorias' => $categorias,
            'filtros' => $request->only(['search', 'categoria', 'cidade', 'sort', 'uf']),
        ]);
    }

    public function show(PontoTuristico $pontoTuristico)
    {
        $pontoTuristico->load(['comentarios' => function ($q) {
            $q->latest()->limit(5);
        }])->loadCount('comentarios');

        $pontoTuristico->increment('visualizacoes');

        $dados = $pontoTuristico->toArray();
        $dados['imagens'] = array_merge(
            [$pontoTuristico->imagem],
            $pontoTuristico->imagens ?? []
        );

        return Inertia::render('PontosTuristicos/Show', [
            'ponto' => array_merge($dados, [
                'categoria_icone' => $pontoTuristico->categoria_icone,
                'estrelas' => $pontoTuristico->estrelas,
                'comentarios_count' => $pontoTuristico->comentarios_count,
            ]),
        ]);
    }

    public function toggleFavorito(PontoTuristico $pontoTuristico)
    {
        $user = Auth::user();
        if (!$user) {
            return back()->with('flash', ['message' => 'Faça login para favoritar.']);
        }

        $user->favoritos()->toggle($pontoTuristico);

        return back();
    }

    public function curtir(PontoTuristico $pontoTuristico)
    {
        $pontoTuristico->increment('curtidas');
        return back();
    }

    public function descurtir(PontoTuristico $pontoTuristico)
    {
        $pontoTuristico->decrement('curtidas');
        return back();
    }

    public function comentar(Request $request, PontoTuristico $pontoTuristico)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:100',
            'conteudo' => 'required|string|max:500',
        ]);

        $pontoTuristico->comentarios()->create($validated);
        return back();
    }

    public function comentarios(PontoTuristico $pontoTuristico)
    {
        $comentarios = $pontoTuristico->comentarios()
            ->latest()
            ->get()
            ->map(fn ($c) => [
                'id' => $c->id,
                'nome' => $c->nome,
                'conteudo' => $c->conteudo,
                'created_at' => $c->created_at,
            ]);

        return response()->json(['comentarios' => $comentarios]);
    }
}
