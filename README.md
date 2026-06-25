# 🗺️ OlharViajante

Plataforma de descoberta de pontos turísticos brasileiros, construída com **Laravel 13**, **Inertia.js v3**, **Vue 3** (Composition API), **Tailwind CSS v4** e **DaisyUI v5**.

---

## 🚀 Funcionalidades

- **Explorar destinos** — Grid paginado com busca, filtros por categoria/cidade/estado e ordenação
- **Detalhes do ponto turístico** — Galeria de imagens, avaliação por estrelas, informações, comentários, curtir e favoritar
- **Favoritos** — Autenticação necessária; lista pessoal de destinos salvos
- **Stories** — Barra estilo Instagram com previews dos destinos em destaque
- **Comentários** — Visitantes podem comentar (nome + texto) sem login
- **Perfil do usuário** — Avatar, bio, localização, estatísticas e edição de conta
- **Autenticação completa** — Cadastro, login, recuperação de senha
- **Tema dark/light** — Alternância persistida no localStorage
- **Design responsivo** — Mobile-first com sidebar adaptável

---

## 🧱 Stack

| Camada        | Tecnologia                                     |
|---------------|------------------------------------------------|
| Backend       | PHP 8.3+, Laravel 13                           |
| Frontend      | Vue 3 (Composition API, `<script setup>`)      |
| SSR/Middleware| Inertia.js v3 (`@inertiajs/vue3`)              |
| CSS           | Tailwind CSS v4 + DaisyUI v5                   |
| Build         | Vite 8 + laravel-vite-plugin                   |
| Database      | MySQL (`db_olharviajante`)                     |

---

## 📁 Estrutura do Projeto

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── Auth/
│   │   │   ├── LoginController.php
│   │   │   ├── RegisterController.php
│   │   │   ├── ForgotPasswordController.php
│   │   │   ├── ResetPasswordController.php
│   │   │   └── ProfileController.php
│   │   └── PontoTuristicoController.php
│   └── Middleware/
│       └── HandleInertiaRequests.php
├── Models/
│   ├── User.php
│   ├── PontoTuristico.php
│   └── Comentario.php
└── Providers/
    └── AppServiceProvider.php

database/
├── migrations/           # 8 migrations (tabelas + alterações)
└── seeders/              # DatabaseSeeder, PontoTuristicoSeeder (16 destinos),
                          # PontoTuristicoMassSeeder (1000 aleatórios), ComentarioSeeder

resources/js/
├── Components/           # 18 componentes reutilizáveis
│   ├── PostCard.vue
│   ├── PostGrid.vue
│   ├── Filters.vue
│   ├── SearchBar.vue
│   ├── LocationFilter.vue
│   ├── DestinosCarrossel.vue
│   ├── StoriesBar.vue
│   ├── Pagination.vue
│   ├── CommentsModal.vue
│   ├── StoryModal.vue
│   ├── InstagramPost.vue
│   ├── InstagramGrid.vue
│   ├── SkeletonGrid.vue
│   ├── PasswordStrength.vue
│   ├── NavLink.vue / Dropdown.vue / DropdownLink.vue / ResponsiveNavLink.vue
├── Pages/
│   ├── Home.vue
│   ├── Favoritos.vue
│   ├── Profile.vue
│   ├── PontosTuristicos/Show.vue
│   └── Auth/ (Login, Register, ForgotPassword, ResetPassword)
└── Layouts/
    ├── MainLayout.vue
    └── AuthenticatedLayout.vue

routes/
└── web.php               # 20+ rotas (home, auth, CRUD comentários, favoritar)
```

---

## 🗄️ Banco de Dados

### Tabelas

| Tabela               | Descrição                                      |
|----------------------|------------------------------------------------|
| `users`              | Usuários (name, email, password, avatar, bio, location) |
| `pontos_turisticos`  | Destinos (nome, descrição, imagens, categoria, estado, avaliação, etc.) |
| `comentarios`        | Comentários (ponto_turistico_id, nome, conteudo) |
| `favoritos`          | Favoritos (user_id FK, ponto_turistico_id FK, unique pair) |
| `cache`, `cache_locks` | Cache do Laravel                             |
| `jobs`, `job_batches`, `failed_jobs` | Filas                |

### Migrations (8 arquivos)

1. `create_users_table` — users, password_reset_tokens, sessions
2. `create_cache_table` — cache, cache_locks
3. `create_jobs_table` — jobs, job_batches, failed_jobs
4. `create_pontos_turisticos_table` — pontos_turisticos (15 colunas)
5. `create_comentarios_table` — comentarios
6. `add_imagens_to_pontos_turisticos` — adiciona coluna `imagens` (json)
7. `add_profile_fields_to_users_table` — adiciona avatar, bio, location
8. `create_favoritos_table` — favoritos (com unique constraint)

---

## 🧠 Modelos e Relacionamentos

| Modelo          | Relacionamentos |
|-----------------|----------------|
| `User`          | `hasMany(PontoTuristico)`, `belongsToMany(Favoritos)` |
| `PontoTuristico`| `hasMany(Comentario)`, `belongsToMany(Favoritos)`, scopes de busca/filtro/ordenação |
| `Comentario`    | `belongsTo(PontoTuristico)` |

### Scopes do `PontoTuristico`

- `busca(?search)` — LIKE em nome, descricao, descricao_curta
- `porCategoria(?categoria)` — WHERE categoria
- `porEstado(?uf)` — WHERE estado
- `porCidade(?cidade)` — WHERE cidade
- `ordenar(?sort)` — `antigos`, `melhores`, `visualizados`, default (mais recentes)

---

## 🌐 Rotas

### Públicas
| Método | URI | Ação |
|--------|-----|------|
| GET | `/` | Home com grid de destinos |
| GET | `/pontos-turisticos/{id}` | Detalhes do destino |
| POST | `/pontos-turisticos/{id}/curtir` | Curtir |
| POST | `/pontos-turisticos/{id}/descurtir` | Descurtir |
| POST | `/pontos-turisticos/{id}/comentar` | Comentar (público) |
| GET | `/pontos-turisticos/{id}/comentarios` | Listar comentários (JSON) |

### Autenticação (guest)
| Método | URI | Ação |
|--------|-----|------|
| GET/POST | `/login` | Login |
| GET/POST | `/register` | Cadastro |
| GET/POST | `/forgot-password` | Esqueci senha |
| GET/POST | `/reset-password/{token}` | Redefinir senha |

### Autenticadas (auth)
| Método | URI | Ação |
|--------|-----|------|
| POST | `/logout` | Logout |
| GET/PATCH | `/profile` | Editar perfil |
| POST | `/profile/avatar` | Upload avatar |
| POST | `/profile/password` | Alterar senha |
| GET | `/favoritos` | Lista de favoritos |
| POST | `/pontos-turisticos/{id}/favoritar` | Favoritar/desfavoritar |

---

## 🖥️ Componentes Frontend

| Componente | Função |
|-----------|--------|
| `PostCard` | Card de destino com imagem, avaliação, like/favoritar |
| `PostGrid` | Grid responsivo (1-3 colunas) |
| `Filters` | Filtros por categoria, estado, cidade, ordenação |
| `SearchBar` | Campo de busca estilo Join |
| `LocationFilter` | Geolocalização via IP (ip-api.com) |
| `DestinosCarrossel` | Carrossel horizontal de destinos em alta |
| `StoriesBar` | Barra de stories estilo Instagram |
| `Pagination` | Navegação entre páginas |
| `CommentsModal` | Modal de comentários |
| `StoryModal` | Modal de preview de story |
| `InstagramPost` | Post estilo Instagram com animação de coração |
| `InstagramGrid` | Grid de fotos estilo Instagram |
| `SkeletonGrid` | Skeleton loading (6 placeholders) |
| `PasswordStrength` | Indicador de força de senha |

---

## 🛠️ Instalação

```bash
# 1. Clonar
git clone git@github.com:ceara-dev/improved-guacamole.git
cd improved-guacamole

# 2. Instalar dependências PHP
composer install

# 3. Configurar ambiente
cp .env.example .env
php artisan key:generate

# 4. Configurar .env (banco MySQL)
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=db_olharviajante
DB_USERNAME=root
DB_PASSWORD=

# 5. Migrar e seedar
php artisan migrate
php artisan db:seed

# 6. Instalar dependências JS
npm install

# 7. Build assets
npm run build

# 8. Servir
php artisan serve
# Em outro terminal:
npm run dev
```

### Script de setup completo
```bash
composer run setup
```

### Desenvolvimento com hot-reload
```bash
composer run dev
```

---

## 🧪 Testes

```bash
composer run test
```

---

## 📄 Licença

MIT
