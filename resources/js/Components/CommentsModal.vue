<template>
    <dialog ref="modalRef" class="modal" @click.self="fechar">
        <div class="modal-box max-w-lg p-0 rounded-2xl overflow-hidden">
            <div class="sticky top-0 bg-base-100 border-b border-base-200 px-4 py-3 flex items-center justify-between z-10">
                <h3 class="font-semibold text-sm">Comentários</h3>
                <button @click="fechar" class="btn btn-ghost btn-xs btn-circle text-base-content/40 hover:text-base-content transition-colors">✕</button>
            </div>

            <div class="px-4 py-3 space-y-4 max-h-80 overflow-y-auto">
                <div v-if="carregando" class="flex items-center justify-center py-8">
                    <span class="loading loading-spinner loading-sm text-primary"></span>
                </div>

                <div v-else-if="comentarios.length === 0" class="text-center py-8 text-base-content/40 text-sm">
                    Nenhum comentário ainda. Seja o primeiro!
                </div>

                <div v-for="comentario in comentarios" :key="comentario.id" class="flex gap-3">
                    <div class="w-8 h-8 rounded-full bg-gradient-to-br from-primary to-secondary flex items-center justify-center text-white text-xs font-bold flex-shrink-0">
                        {{ (comentario.nome || '?')[0].toUpperCase() }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm">
                            <span class="font-semibold">{{ comentario.nome }}</span>
                            <span class="ml-1">{{ comentario.conteudo }}</span>
                        </p>
                        <p class="text-[11px] text-base-content/30 mt-0.5">{{ tempoRelativo(comentario.created_at) }}</p>
                    </div>
                </div>
            </div>

            <div class="border-t border-base-200 px-4 py-3">
                <form @submit.prevent="enviarComentario" class="flex items-center gap-2">
                    <div class="w-7 h-7 rounded-full bg-primary flex items-center justify-center text-white text-[10px] font-bold flex-shrink-0">
                        {{ (nomeSalvo || 'V')[0].toUpperCase() }}
                    </div>
                    <input v-model="nomeSalvo" placeholder="Nome..." class="input input-xs input-ghost text-xs flex-1 min-w-0" required />
                    <input v-model="novoConteudo" placeholder="Comentário..." class="input input-ghost text-xs flex-1 min-w-0" @keydown.enter.prevent="enviarComentario" />
                    <button type="submit" class="text-xs text-sky-500 font-semibold disabled:text-sky-500/30 whitespace-nowrap" :disabled="enviando || !novoConteudo.trim() || !nomeSalvo.trim()">
                        {{ enviando ? 'Enviando...' : 'Publicar' }}
                    </button>
                </form>
            </div>
        </div>
        <form method="dialog" class="modal-backdrop">
            <button>close</button>
        </form>
    </dialog>
</template>

<script setup>
import { ref, watch } from 'vue'
import { router } from '@inertiajs/vue3'

const props = defineProps({
    pontoId: { type: [Number, String], default: null },
    open: { type: Boolean, default: false },
})

const emit = defineEmits(['close', 'comentario-adicionado'])
const modalRef = ref(null)
const comentarios = ref([])
const nomeSalvo = ref('')
const novoConteudo = ref('')
const carregando = ref(false)
const enviando = ref(false)

watch(() => props.open, async (val) => {
    if (val && props.pontoId) {
        modalRef.value?.showModal()
        await carregarComentarios()
    }
})

async function carregarComentarios() {
    carregando.value = true
    try {
        const res = await fetch(`/pontos-turisticos/${props.pontoId}/comentarios`)
        const data = await res.json()
        comentarios.value = data.comentarios
    } catch { }
    finally { carregando.value = false }
}

async function enviarComentario() {
    if (!novoConteudo.value.trim() || !nomeSalvo.value.trim()) return
    enviando.value = true
    router.post(`/pontos-turisticos/${props.pontoId}/comentar`, {
        nome: nomeSalvo.value, conteudo: novoConteudo.value,
    }, {
        preserveScroll: true,
        onSuccess: () => {
            novoConteudo.value = ''
            carregarComentarios()
            emit('comentario-adicionado')
        },
        onFinish: () => { enviando.value = false },
    })
}

function fechar() {
    modalRef.value?.close()
    emit('close')
}

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
