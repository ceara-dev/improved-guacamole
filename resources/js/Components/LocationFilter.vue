<template>
    <div class="mb-3">
        <div v-if="ufAtivo" class="flex items-center gap-2">
            <span class="badge badge-sm badge-soft gap-1 px-3 py-2">
                <span>📍</span>
                Mostrando perto de você — <strong>{{ ufAtivo }}</strong>
                <button @click="limparUf" class="ml-1 hover:text-base-content/80 transition-colors">✕</button>
            </span>
        </div>

        <button
            v-else-if="estado === 'erro'"
            @click="detectar"
            class="btn btn-ghost btn-xs text-xs gap-1 text-base-content/50 hover:text-base-content/70"
        >
            <span>📍</span>
            Não foi possível detectar localização. Tentar novamente?
        </button>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { router } from '@inertiajs/vue3'

const props = defineProps({
    ufAtivo: { type: String, default: '' },
})

const STORAGE_KEY = 'olharviajante_uf'
const estado = ref('idle')

onMounted(() => {
    if (props.ufAtivo) return
    const salvo = localStorage.getItem(STORAGE_KEY)
    if (salvo) {
        aplicarUf(salvo)
        return
    }
    detectar()
})

async function detectar() {
    estado.value = 'loading'
    try {
        const res = await fetch('http://ip-api.com/json/', { signal: AbortSignal.timeout(5000) })
        const data = await res.json()
        if (data.country === 'Brazil' && data.region) {
            localStorage.setItem(STORAGE_KEY, data.region)
            aplicarUf(data.region)
        } else {
            estado.value = 'erro'
        }
    } catch {
        estado.value = 'erro'
    }
}

function aplicarUf(uf) {
    router.get('/', { uf }, {
        preserveState: true, preserveScroll: true, replace: true,
    })
}

function limparUf() {
    localStorage.removeItem(STORAGE_KEY)
    router.get('/', {}, {
        preserveState: true, preserveScroll: true, replace: true,
    })
}
</script>
