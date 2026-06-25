<?php

namespace Database\Seeders;

use App\Models\PontoTuristico;
use Illuminate\Database\Seeder;

class PontoTuristicoMassSeeder extends Seeder
{
    private array $cidadesPorEstado = [
        'AC' => ['Rio Branco', 'Cruzeiro do Sul', 'Sena Madureira', 'Tarauacá', 'Feijó', 'Brasiléia', 'Senador Guiomard', 'Plácido de Castro'],
        'AL' => ['Maceió', 'Arapiraca', 'Palmeira dos Índios', 'Rio Largo', 'Penedo', 'São Miguel dos Campos', 'União dos Palmares', 'Santana do Ipanema', 'Delmiro Gouveia'],
        'AM' => ['Manaus', 'Parintins', 'Itacoatiara', 'Manacapuru', 'Coari', 'Tabatinga', 'Maués', 'Manicoré', 'Humaitá', 'Iranduba'],
        'AP' => ['Macapá', 'Santana', 'Laranjal do Jari', 'Oiapoque', 'Porto Grande', 'Mazagão'],
        'BA' => ['Salvador', 'Feira de Santana', 'Vitória da Conquista', 'Camaçari', 'Juazeiro', 'Ilhéus', 'Lauro de Freitas', 'Porto Seguro', 'Barreiras', 'Alagoinhas', 'Itabuna', 'Jequié', 'Teixeira de Freitas', 'Paulo Afonso', 'Eunápolis', 'Santo Antônio de Jesus', 'Valença', 'Candeias'],
        'CE' => ['Fortaleza', 'Caucaia', 'Juazeiro do Norte', 'Maracanaú', 'Sobral', 'Crato', 'Itapipoca', 'Maranguape', 'Iguatu', 'Quixadá', 'Russas', 'Canindé', 'Crateús', 'Aquiraz', 'Pacatuba'],
        'DF' => ['Brasília', 'Taguatinga', 'Ceilândia', 'Gama', 'Planaltina', 'Sobradinho', 'Guará', 'Samambaia'],
        'ES' => ['Vitória', 'Vila Velha', 'Serra', 'Cariacica', 'Cachoeiro de Itapemirim', 'Linhares', 'Colatina', 'São Mateus', 'Guarapari', 'Aracruz', 'Nova Venécia'],
        'GO' => ['Goiânia', 'Aparecida de Goiânia', 'Anápolis', 'Rio Verde', 'Luziânia', 'Águas Lindas de Goiás', 'Valparaíso de Goiás', 'Trindade', 'Formosa', 'Novo Gama', 'Itumbiara', 'Jataí', 'Catalão', 'Caldas Novas'],
        'MA' => ['São Luís', 'Imperatriz', 'Timon', 'Caxias', 'Codó', 'Paço do Lumiar', 'Açailândia', 'Bacabal', 'Santa Inês', 'Balsas', 'Chapadinha', 'Barreirinhas', 'Pinheiro', 'Grajaú'],
        'MG' => ['Belo Horizonte', 'Uberlândia', 'Contagem', 'Juiz de Fora', 'Betim', 'Montes Claros', 'Ribeirão das Neves', 'Uberaba', 'Governador Valadares', 'Ipatinga', 'Divinópolis', 'Sete Lagoas', 'Santa Luzia', 'Poços de Caldas', 'Patos de Minas', 'Barbacena', 'Ouro Preto', 'Tiradentes', 'Diamantina', 'Mariana', 'São João del-Rei', 'Araxá', 'Lavras', 'Itajubá'],
        'MS' => ['Campo Grande', 'Dourados', 'Três Lagoas', 'Corumbá', 'Ponta Porã', 'Naviraí', 'Bonito', 'Nova Andradina', 'Aquidauana', 'Jardim', 'Paranaíba', 'Amambai'],
        'MT' => ['Cuiabá', 'Várzea Grande', 'Rondonópolis', 'Sinop', 'Tangará da Serra', 'Sorriso', 'Cáceres', 'Lucas do Rio Verde', 'Primavera do Leste', 'Barra do Garças', 'Alta Floresta', 'Nova Mutum', 'Chapada dos Guimarães'],
        'PA' => ['Belém', 'Ananindeua', 'Santarém', 'Marabá', 'Castanhal', 'Parauapebas', 'Itaituba', 'Bragança', 'Abaetetuba', 'Cametá', 'Altamira', 'Tucuruí', 'Redenção', 'Barcarena', 'Salinópolis', 'Alenquer'],
        'PB' => ['João Pessoa', 'Campina Grande', 'Santa Rita', 'Patos', 'Bayeux', 'Sousa', 'Cajazeiras', 'Cabedelo', 'Guarabira', 'Sapé', 'Mamanguape', 'Itabaiana', 'Monteiro'],
        'PE' => ['Recife', 'Jaboatão dos Guararapes', 'Olinda', 'Caruaru', 'Petrolina', 'Paulista', 'Cabo de Santo Agostinho', 'Camaragibe', 'Garanhuns', 'Vitória de Santo Antão', 'Igarassu', 'São Lourenço da Mata', 'Fernando de Noronha', 'Gravatá', 'Arcoverde', 'Serra Talhada'],
        'PI' => ['Teresina', 'Parnaíba', 'Picos', 'Floriano', 'Campo Maior', 'Piripiri', 'Barras', 'Altos', 'Oeiras', 'Luís Correia', 'Pedro II', 'São Raimundo Nonato'],
        'PR' => ['Curitiba', 'Londrina', 'Maringá', 'Ponta Grossa', 'Cascavel', 'São José dos Pinhais', 'Foz do Iguaçu', 'Colombo', 'Guarapuava', 'Paranaguá', 'Araucária', 'Toledo', 'Apucarana', 'Pinhais', 'Campo Largo', 'Arapongas', 'Almirante Tamandaré', 'Umuarama', 'Cambé', 'Campo Mourão'],
        'RJ' => ['Rio de Janeiro', 'São Gonçalo', 'Duque de Caxias', 'Nova Iguaçu', 'Niterói', 'Campos dos Goytacazes', 'Belford Roxo', 'São João de Meriti', 'Petrópolis', 'Volta Redonda', 'Magé', 'Itaboraí', 'Cabo Frio', 'Angra dos Reis', 'Armação dos Búzios', 'Paraty', 'Teresópolis', 'Nova Friburgo', 'Barra Mansa', 'Macaé', 'Rio das Ostras', 'Arraial do Cabo'],
        'RN' => ['Natal', 'Mossoró', 'Parnamirim', 'São Gonçalo do Amarante', 'Ceará-Mirim', 'Caicó', 'Açu', 'Currais Novos', 'Touros', 'Santa Cruz', 'Macau', 'Pau dos Ferros'],
        'RO' => ['Porto Velho', 'Ji-Paraná', 'Ariquemes', 'Cacoal', 'Vilhena', 'Jaru', 'Rolim de Moura', 'Guajará-Mirim', 'Machadinho do Oeste', 'Pimenta Bueno'],
        'RR' => ['Boa Vista', 'Rorainópolis', 'Caracaraí', 'Mucajaí', 'Alto Alegre', 'Pacaraima', 'São João da Baliza', 'Bonfim'],
        'RS' => ['Porto Alegre', 'Caxias do Sul', 'Pelotas', 'Canoas', 'Santa Maria', 'Novo Hamburgo', 'São Leopoldo', 'Passo Fundo', 'Uruguaiana', 'Santa Cruz do Sul', 'Bento Gonçalves', 'Gramado', 'Canela', 'Cachoeirinha', 'Gravataí', 'São Borja', 'Rio Grande', 'Santana do Livramento', 'Torres', 'Bagé', 'Erechim', 'Ijuí', 'Alegrete'],
        'SC' => ['Florianópolis', 'Joinville', 'Blumenau', 'São José', 'Chapecó', 'Itajaí', 'Criciúma', 'Palhoça', 'Balneário Camboriú', 'Lages', 'Brusque', 'Tubarão', 'Pomerode', 'Penha', 'Camboriú', 'Navegantes', 'Rio do Sul', 'Jaraguá do Sul', 'Mafra'],
        'SE' => ['Aracaju', 'Nossa Senhora do Socorro', 'Lagarto', 'Itabaiana', 'Estância', 'Propriá', 'Tobias Barreto', 'Simão Dias', 'Capela', 'Laranjeiras', 'Canindé de São Francisco'],
        'SP' => ['São Paulo', 'Guarulhos', 'Campinas', 'São Bernardo do Campo', 'Santo André', 'Osasco', 'Sorocaba', 'Ribeirão Preto', 'São José dos Campos', 'Santos', 'Mogi das Cruzes', 'Jundiaí', 'Carapicuíba', 'Piracicaba', 'Bauru', 'São Vicente', 'Franca', 'Guarujá', 'Taubaté', 'Praia Grande', 'São José do Rio Preto', 'Limeira', 'Suzano', 'Taboão da Serra', 'Sumaré', 'Indaiatuba', 'Barueri', 'Embu das Artes', 'Cotia', 'Atibaia', 'Araraquara', 'Jacareí', 'São Carlos', 'Marília', 'Presidente Prudente', 'Americana', 'Araçatuba', 'Rio Claro', 'Itu', 'Botucatu', 'Bragança Paulista', 'Salto', 'Ibiúna', 'Campos do Jordão', 'Ubatuba', 'Ilhabela', 'São Sebastião', 'Boituva', 'Pirassununga', 'Tatuí', 'Vinhedo', 'Valinhos', 'Itatiba', 'Louveira', 'Jaguariúna', 'Holambra', 'Bertioga', 'Caraguatatuba', 'São Roque', 'Mairiporã', 'Cunha'],
        'TO' => ['Palmas', 'Araguaína', 'Gurupi', 'Porto Nacional', 'Paraíso do Tocantins', 'Colinas do Tocantins', 'Araguatins', 'Guaraí', 'Tocantinópolis', 'Miracema do Tocantins', 'Augustinópolis', 'Dianópolis'],
    ];

    private array $categorias = [
        'Parque', 'Museu', 'Cultural', 'Igreja', 'Praia',
        'Natural', 'Gastronômico', 'Monumento', 'Aventura', 'Histórico',
    ];

    private array $prefixosNomes = [
        'Mirante do', 'Parque da', 'Praça da', 'Igreja de', 'Museu do',
        'Forte de', 'Cachoeira do', 'Lago do', 'Morro do', 'Pico do',
        'Vale do', 'Gruta da', 'Serra do', 'Recanto do', 'Sítio do',
        'Centro Histórico de', 'Orla da', 'Jardim do', 'Monumento ao', 'Memorial da',
    ];

    private array $tiposNomes = [
        'Sol', 'Lua', 'Serra', 'Vale', 'Rio', 'Mar', 'Monte', 'Pedra',
        'Bosque', 'Campo', 'Fonte', 'Torre', 'Portal', 'Cruzeiro', 'Santos',
        'Águas', 'Vista', 'Horizonte', 'Liberdade', 'Paz', 'Natureza',
        'Esperança', 'Fé', 'Encanto', 'Sonhos', 'Vento', 'Nuvem',
        'Ipê', 'Palmeira', 'Jequitibá', 'Pau-Brasil', 'Araucária',
    ];

    private array $descricoes = [
        'Local ideal para visitar em família, com infraestrutura completa e paisagens de tirar o fôlego.',
        'Um dos pontos mais visitados da região, oferecendo uma experiência única de contato com a natureza.',
        'Construção histórica do século XVIII, preservada como patrimônio cultural e aberta à visitação.',
        'Área de preservação ambiental com trilhas ecológicas, cachoeiras e rica biodiversidade.',
        'Vista panorâmica espetacular, especialmente no pôr do sol. Perfeito para fotos e momentos especiais.',
        'Espaço cultural com exposições, apresentações e oficinas que valorizam a cultura local.',
        'Praia de águas cristalinas e areias brancas, cercada por coqueirais e falésias impressionantes.',
        'Parque urbano com ampla área verde, lagos, pistas de caminhada e espaços de lazer.',
        'Museu com acervo diversificado que conta a história da região desde os tempos coloniais.',
        'Igreja de arquitetura barroca deslumbrante, com altares dourados e obras de arte sacra.',
        'Feira livre tradicional com artesanato local, comidas típicas e apresentações musicais.',
        'Cachoeira com queda d\'água de mais de 50 metros, com piscinas naturais para banho.',
        'Trilha de nível moderado que leva ao topo de uma montanha com vista de 360° da região.',
        'Complexo turístico com piscinas naturais, restaurantes e áreas de descanso em meio à natureza.',
        'Mirante natural com vista para o mar e a cidade, ideal para contemplar o entardecer.',
        'Antiga fazenda colonial transformada em museu, com mobiliário original e jardins históricos.',
        'Reserva ecológica com programas de educação ambiental e observação de aves.',
        'Bairro histórico com ruas de paralelepípedo, casarões coloridos e muito charme.',
        'Centro de aventura com rapel, tirolesa, escalada e outras atividades radicais.',
        'Gastronomia local imperdível, com restaurantes típicos e ingredientes frescos da região.',
    ];

    public function run(): void
    {
        $faker = \Faker\Factory::create('pt_BR');

        $estados = array_keys($this->cidadesPorEstado);
        $total = 1000;

        $this->command?->info("Gerando {$total} pontos turísticos...");

        $bar = $this->command?->getOutput()->createProgressBar($total);
        $bar?->start();

        $chunk = [];

        for ($i = 0; $i < $total; $i++) {
            $estado = $faker->randomElement($estados);
            $cidade = $faker->randomElement($this->cidadesPorEstado[$estado]);
            $categoria = $faker->randomElement($this->categorias);

            $nome = $this->gerarNome($faker, $categoria, $cidade, $estado);
            $descricao = $faker->randomElement($this->descricoes);
            $slugNome = str($nome)->slug('-');

            $chunk[] = [
                'nome' => $nome,
                'descricao' => $descricao,
                'descricao_curta' => mb_substr($descricao, 0, 100) . '.',
                'imagem' => "https://picsum.photos/seed/{$slugNome}/800/600",
                'imagens' => $faker->boolean(30)
                    ? json_encode(array_map(fn ($n) => "https://picsum.photos/seed/{$slugNome}-{$n}/800/600", range(2, rand(3, 6))))
                    : null,
                'cidade' => $cidade,
                'estado' => $estado,
                'categoria' => $categoria,
                'avaliacao' => round(rand(30, 50) / 10, 1),
                'latitude' => rand(-33, 5) + rand(0, 999999) / 10000000,
                'longitude' => rand(-73, -34) + rand(0, 999999) / 10000000,
                'horario_funcionamento' => $faker->optional(0.7)->randomElement(['08:00 - 18:00', '09:00 - 17:00', '07:00 - 19:00', '06:00 - 22:00', '24 horas', '08:00 - 12:00, 13:00 - 17:00']),
                'preco_entrada' => $faker->optional(0.5)->randomFloat(2, 5, 200),
                'tags' => json_encode($faker->randomElements(['turismo', 'viagem', 'natureza', 'aventura', 'cultura', 'história', 'gastronomia', 'lazer', 'ecoturismo', 'fotografia'], rand(2, 5))),
                'visualizacoes' => rand(100, 50000),
                'curtidas' => rand(10, 5000),
                'publicado_em' => $faker->dateTimeBetween('-2 years', 'now')->format('Y-m-d H:i:s'),
                'ativo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ];

            if (count($chunk) >= 50) {
                PontoTuristico::insert($chunk);
                $chunk = [];
                $bar?->advance(50);
            }
        }

        if (!empty($chunk)) {
            PontoTuristico::insert($chunk);
            $bar?->advance(count($chunk));
        }

        $bar?->finish();
        $this->command?->newLine();
        $this->command?->info("{$total} pontos turísticos inseridos com sucesso!");
    }

    private function gerarNome(\Faker\Generator $faker, string $categoria, string $cidade, string $estado): string
    {
        $modelos = [
            "{$categoria} {$cidade}",
            "{$cidade} {$categoria}",
            "{$faker->randomElement($this->prefixosNomes)} {$faker->randomElement($this->tiposNomes)}",
            "Complexo {$categoria} de {$cidade}",
            "{$cidade} - {$faker->randomElement($this->tiposNomes)} {$categoria}",
        ];

        $categoriaMap = [
            'Praia' => ["Praia de {$cidade}", "Praia do {$faker->randomElement($this->tiposNomes)}", "{$cidade} - Praia {$faker->randomElement($this->tiposNomes)}"],
            'Parque' => ["Parque {$cidade}", "Parque {$faker->randomElement($this->tiposNomes)}", "Parque Natural de {$cidade}"],
            'Museu' => ["Museu de {$cidade}", "Museu {$faker->randomElement($this->tiposNomes)}", "Museu Histórico de {$cidade}"],
            'Igreja' => ["Igreja de {$faker->randomElement(['São', 'Santa', 'Nossa Senhora', 'Santo'])} {$faker->randomElement($this->tiposNomes)}", "Catedral de {$cidade}", "Capela {$faker->randomElement($this->tiposNomes)}"],
            'Natural' => ["Cachoeira {$faker->randomElement($this->tiposNomes)}", "Trilha {$faker->randomElement($this->tiposNomes)}", "Reserva Natural de {$cidade}"],
            'Monumento' => ["Monumento a {$faker->randomElement($this->tiposNomes)}", "{$cidade} - {$faker->randomElement($this->tiposNomes)} Monumento"],
            'Cultural' => ["Centro Cultural de {$cidade}", "Espaço {$faker->randomElement(['Cultural', 'Arte', 'Música'])} {$cidade}"],
            'Histórico' => ["Centro Histórico de {$cidade}", "{$cidade} Colonial"],
            'Aventura' => ["{$cidade} Aventura", "Parque Radical {$faker->randomElement($this->tiposNomes)}"],
            'Gastronômico' => ["Feira Gastronômica de {$cidade}", "Mercado {$cidade}"],
        ];

        $opcoes = array_merge($modelos, $categoriaMap[$categoria] ?? []);
        return $faker->randomElement($opcoes);
    }
}
