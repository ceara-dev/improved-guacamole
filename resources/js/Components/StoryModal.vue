<template>
    <dialog ref="modalRef" class="modal" @click.self="fechar">
        <div v-if="story" class="modal-box max-w-lg p-0 overflow-hidden rounded-2xl">
            <div class="relative">
                <img :src="story.imagem" :alt="story.nome" class="w-full h-80 object-cover" @error="onImgError" />
                <div class="absolute inset-0 bg-gradient-to-b from-black/40 to-transparent"></div>
                <div class="absolute top-4 left-4 flex items-center gap-2.5">
                    <div class="w-10 h-10 rounded-full overflow-hidden border-2 border-white">
                        <img :src="story.imagem" :alt="story.nome" class="w-full h-full object-cover" @error="onImgError" />
                    </div>
                    <div>
                        <p class="text-white font-semibold text-sm">{{ story.nome }}</p>
                        <p class="text-white/80 text-xs flex items-center gap-1">
                            <span>{{ story.categoria_icone }}</span>
                            {{ story.categoria }}
                        </p>
                    </div>
                </div>
                <button @click="fechar" class="absolute top-4 right-4 text-white hover:text-white/70 transition-colors text-xl w-8 h-8 flex items-center justify-center rounded-full bg-black/20 backdrop-blur-sm">✕</button>
            </div>
            <div class="p-5 space-y-3">
                <div class="flex items-center gap-2">
                    <div class="flex items-center text-amber-400 text-sm">
                        <span v-for="i in 5" :key="i" class="tracking-[-2px]">
                            {{ i <= Math.floor(story.avaliacao) ? '★' : '☆' }}
                        </span>
                    </div>
                    <span class="text-xs text-base-content/50">{{ story.avaliacao }} • {{ story.curtidas }} curtidas</span>
                </div>
                <p class="text-sm text-base-content/70">{{ story.descricao_curta || story.descricao }}</p>
                <div class="flex items-center gap-2 text-sm text-base-content/50">
                    <span>📍</span>
                    <span>{{ story.cidade }}, {{ story.estado }}</span>
                </div>
                <Link :href="`/pontos-turisticos/${story.id}`" class="btn btn-primary btn-sm w-full mt-2">
                    Ver detalhes completos
                </Link>
            </div>
        </div>
        <form method="dialog" class="modal-backdrop">
            <button>close</button>
        </form>
    </dialog>
</template>

<script setup>
import { ref, watch, onMounted } from 'vue'
import { Link } from '@inertiajs/vue3'

const props = defineProps({
    story: { type: Object, default: null },
    open: { type: Boolean, default: false },
})

const emit = defineEmits(['close'])
const modalRef = ref(null)

watch(() => props.open, (val) => {
    if (val && modalRef.value) {
        modalRef.value.showModal()
    }
})

function fechar() {
    modalRef.value?.close()
    emit('close')
}

function onImgError(e) {
    e.target.src = `https://picsum.photos/seed/${e.target.alt}/800/600`
}
</script>
