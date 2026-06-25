<template>
    <div class="relative mb-4">
        <div class="flex items-center justify-between mb-3">
            <h2 class="text-sm font-semibold text-base-content/70">Destinos em alta</h2>
            <div class="flex items-center gap-1">
                <div class="hidden sm:flex items-center gap-1 text-xs text-base-content/40">
                    <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span>
                    Atualizado agora
                </div>
            </div>
        </div>

        <div
            ref="scrollRef"
            class="flex gap-4 overflow-x-auto scroll-smooth pb-2 scrollbar-hide"
            @scroll="verificarScroll"
        >
            <div
                v-for="destino in destinos"
                :key="destino.id"
                class="flex flex-col items-center gap-1.5 cursor-pointer flex-shrink-0 group transition-all"
                :class="destinosVistos.has(destino.id) ? 'opacity-60' : 'hover:opacity-90'"
            >
                <Link :href="`/pontos-turisticos/${destino.id}`" @click="marcarVisto(destino.id)" class="flex flex-col items-center gap-1.5">
                    <div class="relative">
                        <div
                            class="w-16 h-16 sm:w-20 sm:h-20 rounded-full p-[3px] transition-transform duration-300 group-hover:scale-105"
                            :class="destinosVistos.has(destino.id) ? 'bg-base-300' : 'bg-gradient-to-tr from-yellow-400 via-pink-500 to-purple-600'"
                        >
                            <div class="w-full h-full rounded-full overflow-hidden border-2 border-base-100">
                                <img
                                    :src="destino.imagem"
                                    :alt="destino.nome"
                                    class="w-full h-full object-cover"
                                    @error="onImgError"
                                />
                            </div>
                        </div>
                        <span class="absolute -bottom-0.5 -right-0.5 text-xs drop-shadow-lg">
                            {{ destino.categoria_icone }}
                        </span>
                        <div v-if="destino.avaliacao >= 4.5" class="absolute -top-0.5 -left-0.5 w-5 h-5 bg-amber-400 rounded-full flex items-center justify-center text-[10px] font-bold">
                            ★
                        </div>
                    </div>
                    <span class="text-[11px] text-base-content/60 truncate max-w-16 sm:max-w-20 text-center font-medium">
                        {{ destino.nome.length > 14 ? destino.nome.substring(0, 12) + '…' : destino.nome }}
                    </span>
                </Link>
            </div>
        </div>

        <button
            v-if="podeScrollarEsquerda"
            @click="scroll(-300)"
            class="absolute left-0 top-1/2 -translate-y-1/2 -translate-x-2 w-8 h-8 rounded-full bg-base-100/90 shadow border border-base-200 flex items-center justify-center text-lg hover:bg-base-100 transition-all backdrop-blur-sm hidden sm:flex"
        >‹</button>
        <button
            v-if="podeScrollarDireita"
            @click="scroll(300)"
            class="absolute right-0 top-1/2 -translate-y-1/2 translate-x-2 w-8 h-8 rounded-full bg-base-100/90 shadow border border-base-200 flex items-center justify-center text-lg hover:bg-base-100 transition-all backdrop-blur-sm hidden sm:flex"
        >›</button>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { Link } from '@inertiajs/vue3'

const props = defineProps({
    destinos: { type: Array, required: true },
})

const STORAGE_KEY = 'olharviajante_destinos_vistos'
const scrollRef = ref(null)
const podeScrollarEsquerda = ref(false)
const podeScrollarDireita = ref(true)

const destinosVistos = ref(new Set())

onMounted(() => {
    try {
        const saved = JSON.parse(localStorage.getItem(STORAGE_KEY) || '[]')
        destinosVistos.value = new Set(saved)
    } catch {}
})

function marcarVisto(id) {
    destinosVistos.value.add(id)
    try {
        localStorage.setItem(STORAGE_KEY, JSON.stringify([...destinosVistos.value]))
    } catch {}
}

function scroll(dist) {
    if (scrollRef.value) {
        scrollRef.value.scrollBy({ left: dist, behavior: 'smooth' })
    }
}

function verificarScroll() {
    const el = scrollRef.value
    if (!el) return
    podeScrollarEsquerda.value = el.scrollLeft > 4
    podeScrollarDireita.value = el.scrollLeft < el.scrollWidth - el.clientWidth - 4
}

function onImgError(e) {
    e.target.src = `https://picsum.photos/seed/${e.target.alt}/200/200`
}
</script>

<style scoped>
.scrollbar-hide::-webkit-scrollbar { display: none; }
.scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
</style>
