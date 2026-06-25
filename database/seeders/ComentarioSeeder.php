<?php

namespace Database\Seeders;

use App\Models\Comentario;
use App\Models\PontoTuristico;
use Illuminate\Database\Seeder;

class ComentarioSeeder extends Seeder
{
    public function run(): void
    {
        $comentarios = [
            'Cristo Redentor' => [
                ['nome' => 'Maria', 'conteudo' => 'Lugar incrível! A vista é de tirar o fôlego!'],
                ['nome' => 'João', 'conteudo' => 'Vale muito a pena visitar. Melhor horário: pôr do sol.'],
                ['nome' => 'Ana', 'conteudo' => 'Patrimônio mundial, todo brasileiro deveria ir ao menos uma vez.'],
            ],
            'Parque Ibirapuera' => [
                ['nome' => 'Carlos', 'conteudo' => 'Perfeito para um passeio em família. Muito verde!'],
                ['nome' => 'Julia', 'conteudo' => 'Amoooo o parque! Vou todo fim de semana.'],
            ],
            'Pelourinho' => [
                ['nome' => 'Pedro', 'conteudo' => 'Cultura e história em cada esquina. Salvador é linda!'],
                ['nome' => 'Luiza', 'conteudo' => 'A música ao vivo é imperdível!'],
            ],
            'Igreja de São Francisco de Assis' => [
                ['nome' => 'Rafael', 'conteudo' => 'A arquitetura barroca mais bonita do Brasil.'],
                ['nome' => 'Camila', 'conteudo' => 'O Aleijadinho era um gênio. Obra de arte!'],
            ],
            'Praia do Forte' => [
                ['nome' => 'Thiago', 'conteudo' => 'Água cristalina e muito sossego. Ideal para relaxar.'],
            ],
            'Parque Nacional da Tijuca' => [
                ['nome' => 'Fernanda', 'conteudo' => 'Trilhas maravilhosas! A cachoeira é refrescante.'],
                ['nome' => 'Lucas', 'conteudo' => 'Maior floresta urbana do mundo, orgulho nacional!'],
            ],
            'Mercado Central de Belo Horizonte' => [
                ['nome' => 'Paulo', 'conteudo' => 'Melhor lugar para comer em BH. O pão de queijo é sensacional!'],
                ['nome' => 'Marina', 'conteudo' => 'Comprei artesanato lindo e comi muito queijo mineiro.'],
            ],
            'Museu do Ipiranga' => [
                ['nome' => 'Ricardo', 'conteudo' => 'Museu lindo e muito bem cuidado. História pura!'],
            ],
            'Jardim Botânico do Rio de Janeiro' => [
                ['nome' => 'Beatriz', 'conteudo' => 'Lugar mágico! As orquídeas são deslumbrantes.'],
                ['nome' => 'Felipe', 'conteudo' => 'Imperdível para quem ama natureza. Muito bem conservado.'],
            ],
            'Teatro Amazonas' => [
                ['nome' => 'Sofia', 'conteudo' => 'Arquitetura deslumbrante! A visita guiada é excelente.'],
                ['nome' => 'Gabriel', 'conteudo' => 'Símbolo da nossa cultura. Orgulho amazonense!'],
            ],
            'Beto Carrero World' => [
                ['nome' => 'Isabela', 'conteudo' => 'Diversão garantida para todas as idades!'],
                ['nome' => 'Matheus', 'conteudo' => 'Melhor parque da América Latina, sem dúvidas!'],
                ['nome' => 'Larissa', 'conteudo' => 'Fui com as crianças e foi o melhor passeio do ano!'],
            ],
            'Ouro Preto' => [
                ['nome' => 'Vitor', 'conteudo' => 'Cidade histórica mais bonita do Brasil.'],
                ['nome' => 'Amanda', 'conteudo' => 'As ladeiras e igrejas são de emocionar qualquer um.'],
            ],
            'Fernando de Noronha' => [
                ['nome' => 'Diego', 'conteudo' => 'Paraíso na Terra! Água mais cristalina que já vi.'],
                ['nome' => 'Tatiane', 'conteudo' => 'Mergulho inesquecível. Os golfinhos são um espetáculo!'],
                ['nome' => 'Bruno', 'conteudo' => 'Caro mas cada centavo vale a pena. Lugar único!'],
            ],
            'Bonito' => [
                ['nome' => 'Patrícia', 'conteudo' => 'Natureza exuberante! A gruta do Lago Azul é imperdível.'],
                ['nome' => 'Eduardo', 'conteudo' => 'Melhor destino de ecoturismo do Brasil. Flutuação nos rios é fantástica!'],
            ],
        ];

        foreach ($comentarios as $pontoNome => $comentariosList) {
            $ponto = PontoTuristico::where('nome', $pontoNome)->first();
            if ($ponto) {
                foreach ($comentariosList as $comentario) {
                    $ponto->comentarios()->create($comentario);
                }
            }
        }
    }
}
