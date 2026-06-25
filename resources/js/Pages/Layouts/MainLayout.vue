<template>
    <div class="min-h-screen bg-base-200 overflow-x-hidden">
        <header class="bg-base-100/90 backdrop-blur-md border-b border-base-200 sticky top-0 z-50 transition-all duration-300">
            <div class="max-w-7xl mx-auto px-4 sm:px-6">
                <div class="flex items-center justify-between h-16 gap-4">
                    <!-- Logo -->
                    <Link href="/" class="flex items-center gap-2 shrink-0">
                        <span class="text-2xl">👁️</span>
                        <span class="text-lg font-bold tracking-tight hidden sm:inline">OlharViajante</span>
                    </Link>

                    <!-- Search -->
                    <div class="flex-1 max-w-md hidden sm:block">
                        <div class="relative">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 absolute left-3 top-1/2 -translate-y-1/2 text-base-content/30" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                            <input
                                type="text"
                                :value="searchText"
                                @input="buscar"
                                placeholder="Buscar pontos turísticos..."
                                class="input input-sm w-full bg-base-200/70 border-base-200 text-sm pl-9 rounded-full focus:bg-base-100 transition-colors"
                            />
                        </div>
                    </div>

                    <!-- Nav -->
                    <nav class="flex items-center gap-1">
                        <Link href="/" class="btn btn-ghost btn-sm gap-1.5 text-sm" :class="rotaAtiva === '/' ? 'text-primary font-semibold' : 'text-base-content/60'">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                            <span class="hidden sm:inline">Início</span>
                        </Link>

                        <template v-if="user">
                            <Link href="/favoritos" class="btn btn-ghost btn-sm gap-1.5 text-sm hidden sm:inline-flex" :class="rotaAtiva === '/favoritos' ? 'text-primary font-semibold' : 'text-base-content/60'">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                </svg>
                            </Link>
                            <div class="dropdown dropdown-end">
                                <button class="btn btn-ghost btn-sm btn-circle" tabindex="0">
                                    <div class="w-7 h-7 rounded-full bg-gradient-to-br from-primary to-secondary flex items-center justify-center text-white text-xs font-bold overflow-hidden">
                                        <img v-if="user.avatar" :src="`/storage/${user.avatar}`" class="w-full h-full object-cover" />
                                        <span v-else>{{ iniciais }}</span>
                                    </div>
                                </button>
                                <ul tabindex="0" class="dropdown-content menu menu-sm bg-base-100 rounded-xl shadow-xl border border-base-200 w-48 mt-2 p-2 gap-0.5">
                                    <li><Link href="/profile" class="text-sm">Meu Perfil</Link></li>
                                    <li><Link href="/favoritos" class="text-sm">Favoritos</Link></li>
                                    <li class="border-t border-base-200/60 mt-1 pt-1"><Link href="/profile" class="text-sm">Configurações</Link></li>
                                    <li><button @click="logout" class="text-sm text-red-500">Sair</button></li>
                                </ul>
                            </div>
                        </template>
                        <template v-else>
                            <Link href="/login" class="btn btn-ghost btn-sm text-sm text-base-content/60">Entrar</Link>
                            <Link href="/register" class="btn btn-primary btn-sm text-sm">Cadastrar</Link>
                        </template>

                        <!-- Theme toggle -->
                        <button @click="toggleTheme" class="btn btn-ghost btn-sm btn-circle" :title="isDark ? 'Tema claro' : 'Tema escuro'">
                            <svg v-if="!isDark" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                            </svg>
                            <svg v-else xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v1m0 16v1m9-9h-1M4 12h1m15.364 6.364l-.343-.343M6.343 6.343l-.343-.343m12.728 0l-.343.343M6.343 17.657l-.343.343M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </button>
                    </nav>
                </div>
            </div>

            <!-- Mobile search -->
            <div class="sm:hidden px-4 pb-3">
                <div class="relative">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 absolute left-3 top-1/2 -translate-y-1/2 text-base-content/30" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    <input
                        type="text"
                        :value="searchText"
                        @input="buscar"
                        placeholder="Buscar destinos..."
                        class="input input-sm w-full bg-base-200/70 border-base-200 text-sm pl-9 rounded-full"
                    />
                </div>
            </div>
        </header>

        <main class="py-6 sm:py-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6">
                <slot />
            </div>
        </main>
    </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import { Link, router, usePage } from '@inertiajs/vue3'

const rotaAtiva = computed(() => usePage().url)
const searchText = ref(usePage().props?.filtros?.search || '')
const isDark = ref(false)
const user = computed(() => usePage().props?.auth?.user || null)

const iniciais = computed(() =>
    user.value ? user.value.name.split(' ').map(s => s[0]).join('').toUpperCase().slice(0, 2) : ''
)

function logout() {
    router.post('/logout', {}, { preserveScroll: true })
}

function buscar(e) {
    searchText.value = e.target.value
    router.get('/', { search: e.target.value || '' }, {
        preserveState: true, preserveScroll: true, replace: true,
    })
}

function toggleTheme() {
    isDark.value = !isDark.value
    document.documentElement.setAttribute('data-theme', isDark.value ? 'dark' : 'light')
    localStorage.setItem('theme', isDark.value ? 'dark' : 'light')
}

onMounted(() => {
    const savedTheme = localStorage.getItem('theme')
    if (savedTheme === 'dark') {
        isDark.value = true
        document.documentElement.setAttribute('data-theme', 'dark')
    }
})
</script>
