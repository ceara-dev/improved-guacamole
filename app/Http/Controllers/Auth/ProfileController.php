<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\PontoTuristico;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class ProfileController extends Controller
{
    public function edit(Request $request)
    {
        $user = Auth::user();

        $favoritos = $user->favoritos()
            ->where('ativo', true)
            ->take(12)
            ->get()
            ->map(fn ($p) => [
                'id' => $p->id,
                'nome' => $p->nome,
                'imagem' => $p->imagem,
                'categoria' => $p->categoria,
                'categoria_icone' => $p->categoria_icone,
                'cidade' => $p->cidade,
                'estado' => $p->estado,
                'avaliacao' => $p->avaliacao,
                'favoritado' => true,
            ]);

        $favoritosCount = $user->favoritos()->where('ativo', true)->count();
        $totalCurtidas = PontoTuristico::whereIn(
            'id',
            $user->favoritos()->where('ativo', true)->pluck('ponto_turistico_id')
        )->sum('curtidas');
        $totalVisualizacoes = PontoTuristico::whereIn(
            'id',
            $user->favoritos()->where('ativo', true)->pluck('ponto_turistico_id')
        )->sum('visualizacoes');

        return Inertia::render('Profile', [
            'user' => $user,
            'favoritos' => $favoritos,
            'stats' => [
                'favoritos' => $favoritosCount,
                'curtidas' => $totalCurtidas,
                'visualizacoes' => $totalVisualizacoes,
            ],
        ]);
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'bio' => 'nullable|string|max:500',
            'location' => 'nullable|string|max:255',
        ]);

        $user->update($validated);

        return back()->with('flash', [
            'message' => 'Perfil atualizado com sucesso!',
        ]);
    }

    public function updateAvatar(Request $request)
    {
        $request->validate([
            'avatar' => 'required|image|max:2048',
        ]);

        $user = Auth::user();
        $path = $request->file('avatar')->store('avatars', 'public');

        if ($user->avatar) {
            Storage::disk('public')->delete($user->avatar);
        }

        $user->update(['avatar' => $path]);

        return back()->with('flash', [
            'message' => 'Foto atualizada com sucesso!',
        ]);
    }

    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => 'required|current_password',
            'password' => 'required|string|min:8|confirmed',
        ]);

        Auth::user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        return back()->with('flash', [
            'message' => 'Senha alterada com sucesso!',
        ]);
    }
}
