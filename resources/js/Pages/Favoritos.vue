<template>
    <MainLayout>
        <div class="flex flex-col mb-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold tracking-tight">Meus Favoritos</h1>
                    <p class="text-sm text-base-content/50 mt-1">Destinos que você salvou para visitar</p>
                </div>
            </div>
        </div>

        <div class="flex gap-0 relative">
            <!-- Overlay -->
            <Transition name="overlay">
                <div
                    v-if="sidebarAberta"
                    @click="sidebarAberta = false"
                    class="fixed inset-0 bg-black/40 backdrop-blur-sm z-40 lg:hidden"
                ></div>
            </Transition>

            <!-- Sidebar -->
            <Transition name="sidebar">
                <aside
                    v-if="sidebarAberta || (windowWidth >= 1024 && sidebarDesktopAberta)"
                    class="bg-base-100 shrink-0 flex flex-col"
                    :class="windowWidth >= 1024
                        ? 'w-64 sticky top-20 self-start rounded-xl border border-base-200 max-h-[calc(100vh-6rem)]'
                        : 'fixed inset-y-0 left-0 z-50 w-80 shadow-2xl'"
                >
                    <!-- Header -->
                    <div class="flex items-center justify-between px-5 py-4 border-b border-base-200/60" :class="windowWidth < 1024 ? 'bg-gradient-to-r from-primary/5 to-transparent' : ''">
                        <Link href="/" class="flex items-center gap-2.5">
                            <span class="text-lg">👁️</span>
                            <span class="text-sm font-bold">OlharViajante</span>
                        </Link>
                        <button
                            @click="sidebarAberta = false; sidebarDesktopAberta = false"
                            class="btn btn-ghost btn-xs btn-square text-base-content/40 hover:text-base-content/70"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <!-- Navigation -->
                    <nav class="px-3 py-3 border-b border-base-200/60">
                        <Link
                            href="/"
                            class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors"
                            :class="rotaAtiva === '/' ? 'bg-primary/10 text-primary' : 'text-base-content/60 hover:text-base-content/80 hover:bg-base-200/50'"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                            Início
                        </Link>
                        <Link
                            href="/"
                            class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors"
                            :class="rotaAtiva === '/explorar' ? 'bg-primary/10 text-primary' : 'text-base-content/60 hover:text-base-content/80 hover:bg-base-200/50'"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                            Explorar
                        </Link>
                        <Link
                            href="/favoritos"
                            class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors"
                            :class="rotaAtiva === '/favoritos' ? 'bg-primary/10 text-primary' : 'text-base-content/60 hover:text-base-content/80 hover:bg-base-200/50'"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                            </svg>
                            Favoritos
                        </Link>
                        <button
                            class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors w-full text-left text-base-content/60 hover:text-base-content/80 hover:bg-base-200/50"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Sobre
                        </button>
                    </nav>

                    <!-- Filters section -->
                    <div class="flex-1 overflow-y-auto px-5 py-4 space-y-5">
                        <div>
                            <span class="text-[11px] font-semibold text-base-content/40 uppercase tracking-wider flex items-center gap-2 mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                                </svg>
                                Filtros
                            </span>

                            <SearchBar :search="filtros.search" @update:search="buscar" />

                            <div class="mt-5">
                                <Filters
                                    :categorias="categorias"
                                    :filtros="filtros"
                                />
                            </div>
                        </div>
                    </div>

                    <!-- Footer -->
                    <div v-if="contagemFiltros > 0" class="border-t border-base-200/60 px-5 py-3">
                        <button
                            @click="limparTudo"
                            class="btn btn-outline btn-xs w-full gap-1.5 text-xs"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            Limpar todos os filtros
                        </button>
                    </div>
                </aside>
            </Transition>

            <!-- Desktop toggle pill -->
            <button
                v-if="windowWidth >= 1024"
                @click="sidebarDesktopAberta = !sidebarDesktopAberta"
                class="shrink-0 flex items-center gap-1 px-1.5 py-6 mt-12 rounded-r-lg border border-l-0 border-base-200 bg-base-100 text-base-content/30 hover:text-base-content/60 hover:bg-base-200/50 transition-all cursor-pointer z-10"
                :class="sidebarDesktopAberta ? '-ml-px' : 'ml-0'"
                :title="sidebarDesktopAberta ? 'Recolher sidebar' : 'Expandir sidebar'"
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-3.5 w-3.5 transition-transform duration-200"
                    :class="sidebarDesktopAberta ? '' : 'rotate-180'"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="3"
                >
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                </svg>
            </button>

            <!-- Main content -->
            <div class="flex-1 min-w-0">
                <div v-if="loading" class="space-y-4">
                    <div class="flex items-center gap-2 text-sm text-base-content/50">
                        <span class="loading loading-spinner loading-xs"></span>
                        Carregando favoritos...
                    </div>
                    <PostGrid>
                        <div v-for="i in 9" :key="i" class="bg-base-100 border border-base-200 rounded-xl overflow-hidden animate-pulse">
                            <div class="aspect-[4/3] bg-base-200"></div>
                            <div class="p-4 space-y-3">
                                <div class="h-4 bg-base-200 rounded w-3/4"></div>
                                <div class="h-3 bg-base-200 rounded w-full"></div>
                                <div class="h-3 bg-base-200 rounded w-1/2"></div>
                                <div class="flex gap-2">
                                    <div class="h-4 bg-base-200 rounded w-20"></div>
                                    <div class="h-4 bg-base-200 rounded w-16"></div>
                                </div>
                            </div>
                        </div>
                    </PostGrid>
                </div>

                <template v-else-if="pontos.data.length === 0">
                    <div class="text-center py-20 max-w-md mx-auto">
                        <div class="text-6xl mb-5 opacity-30">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-base-content/60">Nenhum favorito ainda</h3>
                        <p class="text-sm text-base-content/40 mt-2">Salve seus destinos favoritos para encontrá-los facilmente depois.</p>
                        <Link href="/" class="btn btn-primary btn-sm mt-6">Explorar destinos</Link>
                    </div>
                </template>

                <template v-else>
                    <PostGrid>
                        <div
                            v-for="(ponto, i) in pontos.data"
                            :key="ponto.id"
                            class="animate-stagger"
                            :style="{ animationDelay: `${i * 50}ms` }"
                        >
                            <PostCard :post="ponto" />
                        </div>
                    </PostGrid>
                    <Pagination :links="pontos.links" />
                </template>
            </div>
        </div>
    </MainLayout>
</template>

<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue'
import { Link, router, usePage } from '@inertiajs/vue3'
import MainLayout from './Layouts/MainLayout.vue'
import PostCard from '../Components/PostCard.vue'
import PostGrid from '../Components/PostGrid.vue'
import Filters from '../Components/Filters.vue'
import Pagination from '../Components/Pagination.vue'
import SearchBar from '../Components/SearchBar.vue'

const props = defineProps({
    pontos: { type: Object, required: true },
    categorias: { type: Array, default: () => [] },
    filtros: {
        type: Object,
        default: () => ({ search: '', categoria: '', sort: '' }),
    },
})

const rotaAtiva = computed(() => usePage().url)
const loading = computed(() =>
    usePage().progress?.percentage !== null && usePage().progress?.percentage < 100
)

const windowWidth = ref(typeof window !== 'undefined' ? window.innerWidth : 1024)
const sidebarAberta = ref(false)
const sidebarDesktopAberta = ref(true)

const contagemFiltros = computed(() => {
    let count = 0
    if (props.filtros.search) count++
    if (props.filtros.categoria) count++
    if (props.filtros.cidade) count++
    if (props.filtros.sort) count++
    if (props.filtros.uf) count++
    return count
})

function onResize() {
    windowWidth.value = window.innerWidth
}

onMounted(() => window.addEventListener('resize', onResize))
onUnmounted(() => window.removeEventListener('resize', onResize))

function buscar(value) {
    router.get('/favoritos', { search: value || '' }, {
        preserveState: true, preserveScroll: true, replace: true,
    })
}

function limparTudo() {
    router.get('/favoritos', {}, {
        preserveState: true, preserveScroll: true, replace: true,
    })
    sidebarAberta.value = false
}
</script>

<style scoped>
@keyframes stagger-fade {
    from { opacity: 0; transform: translateY(16px); }
    to { opacity: 1; transform: translateY(0); }
}
.animate-stagger {
    animation: stagger-fade 0.4s ease-out both;
}

.overlay-enter-active,
.overlay-leave-active {
    transition: opacity 0.25s ease;
}
.overlay-enter-from,
.overlay-leave-to {
    opacity: 0;
}

.sidebar-enter-active {
    transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1);
}
.sidebar-leave-active {
    transition: transform 0.2s ease-in;
}
.sidebar-enter-from,
.sidebar-leave-to {
    transform: translateX(-100%);
}
</style>
