<template>
    <MainLayout>
        <div class="max-w-5xl mx-auto px-2 sm:px-4">
            <Link href="/" class="inline-flex items-center gap-1 text-xs text-base-content/40 hover:text-base-content/70 transition-colors mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                </svg>
                Voltar ao feed
            </Link>

            <div class="bg-base-100 border border-base-200 rounded-xl overflow-hidden shadow-sm">
                <div class="flex flex-col md:flex-row">
                    <!-- Image gallery -->
                    <div class="md:w-[55%] bg-base-200 flex items-center justify-center relative group overflow-hidden">
                        <div
                            class="relative w-full h-full select-none"
                            @touchstart.passive="onTouchStart"
                            @touchmove.passive="onTouchMove"
                            @touchend.passive="onTouchEnd"
                        >
                            <img
                                :src="imagemAtual"
                                :alt="ponto.nome"
                                class="w-full aspect-square md:aspect-[4/5] object-cover transition-transform duration-300"
                                :class="{ 'scale-105': swiping }"
                                @error="onImgError"
                            />
                            <div class="absolute inset-0 bg-gradient-to-t from-black/10 to-transparent pointer-events-none"></div>

                            <!-- Nav arrows -->
                            <button
                                v-if="imagens.length > 1"
                                @click="prevImagem"
                                class="absolute left-2 top-1/2 -translate-y-1/2 w-8 h-8 rounded-full bg-white/80 text-base-content/70 flex items-center justify-center text-lg hover:bg-white transition-all shadow opacity-0 group-hover:opacity-100"
                            >‹</button>
                            <button
                                v-if="imagens.length > 1"
                                @click="nextImagem"
                                class="absolute right-2 top-1/2 -translate-y-1/2 w-8 h-8 rounded-full bg-white/80 text-base-content/70 flex items-center justify-center text-lg hover:bg-white transition-all shadow opacity-0 group-hover:opacity-100"
                            >›</button>

                            <!-- Dots -->
                            <div
                                v-if="imagens.length > 1"
                                class="absolute bottom-3 left-1/2 -translate-x-1/2 flex items-center gap-1.5"
                            >
                                <button
                                    v-for="(_, idx) in imagens"
                                    :key="idx"
                                    @click="imagemIndex = idx"
                                    class="w-1.5 h-1.5 rounded-full transition-all"
                                    :class="idx === imagemIndex ? 'bg-white scale-110 w-3' : 'bg-white/50 hover:bg-white/70'"
                                />
                            </div>

                            <!-- Counter badge -->
                            <span
                                v-if="imagens.length > 1"
                                class="absolute top-3 right-3 text-[10px] font-medium bg-black/40 text-white px-2 py-0.5 rounded-full backdrop-blur-sm"
                            >{{ imagemIndex + 1 }}/{{ imagens.length }}</span>
                        </div>
                    </div>

                    <!-- Details sidebar -->
                    <div class="md:w-[45%] flex flex-col">
                        <!-- Header -->
                        <div class="flex items-center justify-between px-4 py-3 border-b border-base-200">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-full bg-gradient-to-tr from-yellow-400 via-pink-500 to-purple-600 p-[2px]">
                                    <div class="w-full h-full rounded-full overflow-hidden border-2 border-base-100">
                                        <img :src="imagemAtual" :alt="ponto.nome" class="w-full h-full object-cover" @error="onImgError"/>
                                    </div>
                                </div>
                                <div>
                                    <p class="font-semibold text-sm">{{ ponto.nome }}</p>
                                    <p class="text-[11px] text-base-content/50 flex items-center gap-1">
                                        <span>{{ ponto.categoria_icone }}</span>
                                        {{ ponto.categoria }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Scrollable content -->
                        <div class="flex-1 overflow-y-auto px-4 py-3 space-y-3" style="max-height: 60vh;">
                            <!-- Caption -->
                            <div class="flex gap-3">
                                <div class="w-8 h-8 rounded-full bg-gradient-to-br from-primary to-secondary flex items-center justify-center text-white text-xs font-bold flex-shrink-0 mt-0.5">
                                    {{ (ponto.nome || '?')[0].toUpperCase() }}
                                </div>
                                <div>
                                    <p class="text-sm leading-relaxed">
                                        <span class="font-semibold">{{ ponto.nome }}</span>
                                        {{ ponto.descricao_curta || ponto.descricao }}
                                    </p>
                                    <p class="text-xs text-sky-600 mt-1 flex flex-wrap gap-1">
                                        <span v-for="tag in ponto.tags?.slice(0, 3)" :key="tag" class="hover:underline cursor-pointer">#{{ tag }}</span>
                                    </p>
                                </div>
                            </div>

                            <!-- Info chips -->
                            <div class="flex flex-wrap items-center gap-2 pt-2 border-t border-base-200">
                                <span class="badge badge-sm badge-ghost gap-1">📍 {{ ponto.cidade }}, {{ ponto.estado }}</span>
                                <span class="badge badge-sm badge-ghost gap-1">⭐ {{ ponto.avaliacao }}</span>
                                <span v-if="ponto.horario_funcionamento" class="badge badge-sm badge-ghost gap-1">🕐 {{ ponto.horario_funcionamento }}</span>
                                <span v-if="ponto.preco_entrada" class="badge badge-sm badge-ghost gap-1">💰 R$ {{ Number(ponto.preco_entrada).toFixed(2) }}</span>
                                <span v-else class="badge badge-sm badge-success gap-1 text-success-content">💰 Gratuito</span>
                            </div>

                            <!-- Tags -->
                            <div v-if="ponto.tags?.length" class="flex flex-wrap gap-1">
                                <span v-for="tag in ponto.tags" :key="tag" class="badge badge-sm badge-ghost text-[10px] hover:bg-base-300 cursor-pointer">#{{ tag }}</span>
                            </div>

                            <!-- Full description -->
                            <div v-if="ponto.descricao" class="text-sm text-base-content/60 leading-relaxed bg-base-200/50 rounded-lg p-3">
                                {{ ponto.descricao }}
                            </div>

                            <!-- Comments -->
                            <div class="pt-2 border-t border-base-200">
                                <p class="font-semibold text-xs mb-3">Comentários ({{ ponto.comentarios_count || 0 }})</p>
                                <div v-if="ponto.comentarios?.length === 0" class="text-xs text-base-content/40 text-center py-4">
                                    Nenhum comentário ainda. Seja o primeiro!
                                </div>
                                <div v-for="comentario in ponto.comentarios" :key="comentario.id" class="flex gap-2 mb-3">
                                    <div class="w-6 h-6 rounded-full bg-gradient-to-br from-primary to-secondary flex items-center justify-center text-white text-[9px] font-bold flex-shrink-0 mt-0.5">
                                        {{ (comentario.nome || '?')[0].toUpperCase() }}
                                    </div>
                                    <div>
                                        <p class="text-sm leading-relaxed">
                                            <span class="font-semibold">{{ comentario.nome }}</span>
                                            {{ comentario.conteudo }}
                                        </p>
                                        <p class="text-[10px] text-base-content/30 mt-0.5">{{ tempoRelativo(comentario.created_at) }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="border-t border-base-200 px-4 py-2.5 flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <button @click="toggleCurtir" class="flex items-center gap-1 text-sm hover:scale-105 transition-transform" :class="curtido ? 'text-red-500' : 'text-base-content/50'">
                                    <span>{{ curtido ? '❤️' : '🤍' }}</span>
                                    <span class="tabular-nums">{{ ponto.curtidas + (curtidoAgora ? 1 : 0) }}</span>
                                </button>
                                <span class="flex items-center gap-1 text-sm text-base-content/50">
                                    <span>👁️</span>
                                    <span class="tabular-nums">{{ ponto.visualizacoes }}</span>
                                </span>
                            </div>
                            <button @click="toggleSalvar" class="text-sm hover:scale-105 transition-transform" :class="salvo ? 'text-yellow-500' : 'text-base-content/30'">
                                {{ salvo ? '⭐ Salvo' : '☆ Salvar' }}
                            </button>
                        </div>

                        <!-- Comment input -->
                        <div class="border-t border-base-200 px-4 py-2.5 flex items-center gap-2">
                            <div class="w-6 h-6 rounded-full bg-primary flex items-center justify-center text-white text-[9px] font-bold flex-shrink-0">
                                {{ (nomeInput || 'V')[0].toUpperCase() }}
                            </div>
                            <input v-model="nomeInput" placeholder="Nome..." class="input input-xs input-ghost w-20 text-xs flex-1 min-w-0" />
                            <input
                                v-model="comentarioInput"
                                placeholder="Adicione um comentário..."
                                class="input input-ghost flex-1 text-xs"
                                @keydown.enter.prevent="enviarComentario"
                            />
                            <button
                                @click="enviarComentario"
                                class="text-xs text-sky-500 font-semibold disabled:text-sky-500/30 whitespace-nowrap"
                                :disabled="!comentarioInput.trim() || !nomeInput.trim()"
                            >Publicar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </MainLayout>
</template>

<script setup>
import { ref, computed } from 'vue'
import { Link, router } from '@inertiajs/vue3'
import MainLayout from '../Layouts/MainLayout.vue'

const props = defineProps({
    ponto: { type: Object, required: true },
})

const curtido = ref(false)
const curtidoAgora = ref(false)
const salvo = ref(false)
const nomeInput = ref('')
const comentarioInput = ref('')

const imagemIndex = ref(0)
const imagens = computed(() => props.ponto.imagens?.length ? props.ponto.imagens : [props.ponto.imagem])
const imagemAtual = computed(() => imagens.value[imagemIndex.value] || props.ponto.imagem)

const swiping = ref(false)
const touchStartX = ref(0)
const touchDeltaX = ref(0)

function prevImagem() {
    imagemIndex.value = imagemIndex.value > 0 ? imagemIndex.value - 1 : imagens.value.length - 1
}

function nextImagem() {
    imagemIndex.value = imagemIndex.value < imagens.value.length - 1 ? imagemIndex.value + 1 : 0
}

function onTouchStart(e) {
    if (imagens.value.length <= 1) return
    touchStartX.value = e.touches[0].clientX
    touchDeltaX.value = 0
    swiping.value = true
}

function onTouchMove(e) {
    if (!swiping.value) return
    touchDeltaX.value = e.touches[0].clientX - touchStartX.value
}

function onTouchEnd() {
    if (!swiping.value) return
    swiping.value = false
    if (touchDeltaX.value < -60) nextImagem()
    else if (touchDeltaX.value > 60) prevImagem()
}

function toggleCurtir() {
    if (!curtido.value) {
        curtido.value = true
        curtidoAgora.value = true
        router.post(`/pontos-turisticos/${props.ponto.id}/curtir`, {}, { preserveScroll: true, replace: true })
    } else {
        curtido.value = false
        curtidoAgora.value = false
        router.post(`/pontos-turisticos/${props.ponto.id}/descurtir`, {}, { preserveScroll: true, replace: true })
    }
}

function toggleSalvar() { salvo.value = !salvo.value }

function enviarComentario() {
    if (!comentarioInput.value.trim() || !nomeInput.value.trim()) return
    router.post(`/pontos-turisticos/${props.ponto.id}/comentar`, {
        nome: nomeInput.value, conteudo: comentarioInput.value,
    }, {
        preserveScroll: true,
        onSuccess: () => { comentarioInput.value = '' },
    })
}

function onImgError(e) { e.target.src = `https://picsum.photos/seed/${props.ponto.nome}/800/800` }

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
