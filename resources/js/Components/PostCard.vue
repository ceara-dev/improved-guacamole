<template>
    <div
        class="bg-base-100 border border-base-200 rounded-xl overflow-hidden group/card transition-all duration-300 hover:shadow-xl hover:-translate-y-1 flex flex-col"
    >
        <!-- Image -->
        <div class="relative bg-base-200 overflow-hidden aspect-[4/3]">
            <img
                :src="post.imagem"
                :alt="post.nome"
                class="w-full h-full object-cover transition-transform duration-500 group-hover/card:scale-105"
                @error="onImageError"
            />
            <div class="absolute inset-0 bg-gradient-to-t from-black/10 to-transparent pointer-events-none"></div>
            <!-- Category badge -->
            <div class="absolute top-3 left-3">
                <span class="badge badge-sm bg-white/95 backdrop-blur-sm border-0 gap-1.5 px-2.5 py-2 text-xs font-medium shadow-md">
                    <span class="text-base leading-none">{{ post.categoria_icone }}</span>
                    <span class="hidden sm:inline">{{ post.categoria }}</span>
                </span>
            </div>

            <!-- Multiple images indicator -->
            <Link
                v-if="post.imagens_count > 1"
                :href="`/pontos-turisticos/${post.id}`"
                class="absolute top-3 right-3 flex items-center gap-0.5"
            >
                <span class="w-2 h-2 rounded-full bg-white/90 shadow-sm"></span>
                <span class="w-2 h-2 rounded-full bg-white/50 shadow-sm"></span>
            </Link>

            <!-- Overlay on hover -->
            <div class="absolute inset-0 bg-black/0 group-hover/card:bg-black/20 transition-colors duration-300 flex items-end justify-end p-3 opacity-0 group-hover/card:opacity-100">
                <span class="badge badge-sm badge-primary text-primary-content font-medium">
                    Ver detalhes
                </span>
            </div>
        </div>

        <!-- Content -->
        <div class="p-4 flex flex-col flex-1 gap-2">
            <!-- Title -->
            <Link
                :href="`/pontos-turisticos/${post.id}`"
                class="text-sm font-bold leading-snug hover:text-primary transition-colors line-clamp-2"
            >
                {{ post.nome }}
            </Link>

            <!-- Description -->
            <p class="text-xs text-base-content/60 leading-relaxed line-clamp-2">
                {{ post.descricao_curta || post.descricao || '' }}
            </p>

            <!-- Location -->
            <div class="flex items-center gap-1 text-xs text-base-content/50">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                <span class="truncate">{{ post.cidade }}, {{ post.estado }}</span>
            </div>

            <!-- Rating -->
            <div class="flex items-center gap-1.5">
                <div class="flex items-center text-amber-400 text-sm leading-none">
                    <span v-for="i in 5" :key="i" class="tracking-[-2px]">
                        {{ i <= Math.floor(post.avaliacao) ? '★' : (i - post.avaliacao <= 0.5 ? '½' : '☆') }}
                    </span>
                </div>
                <span class="text-xs font-semibold text-base-content/70">{{ post.avaliacao }}</span>
                <span class="text-xs text-base-content/40">({{ post.curtidas }} avaliações)</span>
            </div>

            <!-- Spacer -->
            <div class="flex-1"></div>

            <!-- Actions -->
            <div class="flex items-center justify-between pt-1 border-t border-base-200/50">
                <div class="flex items-center gap-0.5">
                    <button
                        @click="toggleCurtir"
                        class="btn btn-ghost btn-xs gap-1 text-xs transition-all"
                        :class="curtido ? 'text-red-500 hover:text-red-600' : 'text-base-content/50 hover:text-base-content/70'"
                    >
                        <span class="text-sm leading-none">{{ curtido ? '❤️' : '🤍' }}</span>
                        <span class="tabular-nums font-medium">{{ curtido ? post.curtidas + 1 : post.curtidas }}</span>
                    </button>
                    <button
                        @click="toggleFavorito"
                        class="btn btn-ghost btn-xs btn-square text-xs transition-all"
                        :class="favoritado ? 'text-amber-500 hover:text-amber-600' : 'text-base-content/40 hover:text-amber-400'"
                        :title="favoritado ? 'Remover dos favoritos' : 'Adicionar aos favoritos'"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                            <path v-if="favoritado" d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            <path v-else d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                        </svg>
                    </button>
                </div>

                <div class="flex items-center gap-1">
                    <span class="text-[10px] text-base-content/30">{{ dataFormatada }}</span>
                    <Link
                        :href="`/pontos-turisticos/${post.id}`"
                        class="btn btn-primary btn-xs text-xs"
                    >
                        Ver detalhes
                    </Link>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import { Link, router } from '@inertiajs/vue3'

const props = defineProps({
    post: { type: Object, required: true },
})

const curtido = ref(false)
const favoritado = ref(props.post.favoritado || false)

function toggleCurtir() {
    if (!curtido.value) {
        curtido.value = true
        router.post(`/pontos-turisticos/${props.post.id}/curtir`, {}, {
            preserveScroll: true, replace: true,
        })
    } else {
        curtido.value = false
        router.post(`/pontos-turisticos/${props.post.id}/descurtir`, {}, {
            preserveScroll: true, replace: true,
        })
    }
}

function toggleFavorito() {
    favoritado.value = !favoritado.value
    router.post(`/pontos-turisticos/${props.post.id}/favoritar`, {}, {
        preserveScroll: true, replace: true,
        onError: () => { favoritado.value = !favoritado.value },
    })
}

function onImageError(e) {
    e.target.src = `https://picsum.photos/seed/${props.post.nome}/600/400`
}

const dataFormatada = computed(() => {
    if (!props.post.publicado_em) return ''
    return new Date(props.post.publicado_em).toLocaleDateString('pt-BR', {
        day: '2-digit', month: 'short',
    })
})
</script>
