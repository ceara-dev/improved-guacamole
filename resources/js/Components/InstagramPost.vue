<template>
    <div class="bg-base-100 border border-base-200 rounded-xl overflow-hidden group transition-all duration-300 hover:shadow-lg">
        <!-- Header -->
        <div class="flex items-center justify-between px-3 py-2.5">
            <div class="flex items-center gap-2.5 min-w-0">
                <div class="w-8 h-8 rounded-full bg-gradient-to-tr from-yellow-400 via-pink-500 to-purple-600 p-[2px]">
                    <div class="w-full h-full rounded-full overflow-hidden border-2 border-base-100">
                        <img :src="post.imagem" :alt="post.nome" class="w-full h-full object-cover" @error="onAvatarError" />
                    </div>
                </div>
                <div class="min-w-0">
                    <Link :href="`/pontos-turisticos/${post.id}`" class="font-semibold text-xs hover:underline truncate block">{{ post.nome }}</Link>
                    <div class="text-[10px] text-base-content/50 flex items-center gap-1 truncate">
                        <span>{{ post.categoria_icone }}</span>
                        <span class="truncate">{{ post.categoria }} · {{ post.cidade }}</span>
                    </div>
                </div>
            </div>
            <Link :href="`/pontos-turisticos/${post.id}`" class="btn btn-ghost btn-xs btn-circle text-base-content/30 hover:text-base-content/60 opacity-0 group-hover:opacity-100 transition-opacity">
                <span class="text-lg leading-none">⋯</span>
            </Link>
        </div>

        <!-- Image -->
        <div class="relative bg-base-200 overflow-hidden">
            <img :src="post.imagem" :alt="post.nome" class="w-full aspect-square object-cover transition-transform duration-500 group-hover:scale-105" @error="onImageError" @dblclick="curtir" />
            <div v-if="showHeartAnimation" class="absolute inset-0 flex items-center justify-center pointer-events-none z-10">
                <span class="drop-shadow-lg animate-heart-pop">❤️</span>
            </div>
            <div class="absolute inset-0 bg-gradient-to-t from-black/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none"></div>
        </div>

        <!-- Actions bar -->
        <div class="px-3 pt-2.5">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <button @click="toggleCurtir" class="hover:scale-110 transition-transform active:scale-90" :class="curtido ? 'text-red-500' : 'text-base-content/70'">
                        <span class="text-lg leading-none">{{ curtido ? '❤️' : '🤍' }}</span>
                    </button>
                    <button @click="abrirComentarios" class="hover:scale-110 transition-transform active:scale-90 text-base-content/70">
                        <span class="text-lg leading-none">💬</span>
                    </button>
                    <button @click="compartilhar" class="hover:scale-110 transition-transform active:scale-90 text-base-content/70 relative">
                        <span class="text-lg leading-none">🔗</span>
                        <span v-if="showCopied" class="absolute -top-8 left-1/2 -translate-x-1/2 bg-base-content text-base-100 text-[10px] px-2 py-0.5 rounded whitespace-nowrap shadow pointer-events-none animate-fade-up">Link copiado!</span>
                    </button>
                </div>
                <button @click="toggleSalvar" class="hover:scale-110 transition-transform active:scale-90" :class="salvo ? 'text-yellow-500' : 'text-base-content/30'">
                    <span class="text-lg leading-none">{{ salvo ? '⭐' : '☆' }}</span>
                </button>
            </div>
        </div>

        <!-- Likes -->
        <div class="px-3 pt-2">
            <p class="font-semibold text-xs">
                <span class="tabular-nums">{{ post.curtidas + (curtidoAgora ? 1 : 0) }}</span> curtidas
            </p>
        </div>

        <!-- Caption -->
        <div class="px-3 pt-1">
            <p class="text-xs leading-relaxed line-clamp-2">
                <Link :href="`/pontos-turisticos/${post.id}`" class="font-semibold hover:underline">{{ post.nome }}</Link>
                {{ ' ' + (post.descricao_curta || post.descricao || '') }}
            </p>
            <p class="text-[10px] text-base-content/40 mt-1 truncate">
                <span v-for="tag in post.tags?.slice(0, 4)" :key="tag" class="hover:underline cursor-pointer mr-1">#{{ tag }}</span>
            </p>
        </div>

        <!-- Comments preview -->
        <div class="px-3 pt-1">
            <button v-if="post.comentarios_count > 0" @click="abrirComentarios" class="text-[11px] text-base-content/40 hover:text-base-content/60 transition-colors">
                Ver {{ post.comentarios_count }} comentários
            </button>
        </div>

        <!-- Time -->
        <div class="px-3 pb-2 pt-1">
            <p class="text-[9px] uppercase tracking-widest text-base-content/30">{{ tempoRelativo(post.publicado_em) }}</p>
        </div>
    </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import { Link, router } from '@inertiajs/vue3'

const props = defineProps({
    post: { type: Object, required: true },
    compact: { type: Boolean, default: true },
})

const curtido = ref(false)
const curtidoAgora = ref(false)
const salvo = ref(false)
const showHeartAnimation = ref(false)
const showCopied = ref(false)
const emit = defineEmits(['abrir-comentarios', 'comentario-adicionado'])

function toggleCurtir() {
    if (!curtido.value) {
        curtido.value = true
        curtidoAgora.value = true
        router.post(`/pontos-turisticos/${props.post.id}/curtir`, {}, {
            preserveScroll: true, replace: true,
        })
    } else {
        curtido.value = false
        curtidoAgora.value = false
        router.post(`/pontos-turisticos/${props.post.id}/descurtir`, {}, {
            preserveScroll: true, replace: true,
        })
    }
}

function curtir() {
    if (!curtido.value) { toggleCurtir() }
    showHeartAnimation.value = true
    setTimeout(() => { showHeartAnimation.value = false }, 700)
}

function toggleSalvar() { salvo.value = !salvo.value }

function abrirComentarios() { emit('abrir-comentarios', props.post.id) }

function compartilhar() {
    navigator.clipboard?.writeText(window.location.origin + '/pontos-turisticos/' + props.post.id)
    showCopied.value = true
    setTimeout(() => { showCopied.value = false }, 2000)
}

function onImageError(e) { e.target.src = `https://picsum.photos/seed/${props.post.nome}/400/400` }
function onAvatarError(e) { e.target.src = `https://ui-avatars.com/api/?name=${encodeURIComponent(props.post.nome)}&background=random&size=64` }

function tempoRelativo(data) {
    if (!data) return ''
    const diff = Date.now() - new Date(data).getTime()
    const mins = Math.floor(diff / 60000)
    if (mins < 1) return 'agora'
    if (mins < 60) return `há ${mins} min`
    const hrs = Math.floor(mins / 60)
    if (hrs < 24) return `há ${hrs}h`
    const dias = Math.floor(hrs / 24)
    if (dias < 30) return `há ${dias}d`
    return new Date(data).toLocaleDateString('pt-BR')
}
</script>

<style scoped>
@keyframes heart-pop {
    0% { transform: scale(0); opacity: 1; }
    40% { transform: scale(1.3); opacity: 0.9; }
    100% { transform: scale(1); opacity: 0; }
}
.animate-heart-pop { animation: heart-pop 0.7s ease-out forwards; }

@keyframes fade-up {
    0% { opacity: 0; transform: translate(-50%, 4px); }
    100% { opacity: 1; transform: translate(-50%, 0); }
}
.animate-fade-up { animation: fade-up 0.2s ease-out forwards; }
</style>
