<template>
    <div v-if="password" class="flex items-center gap-2 mt-1">
        <div class="flex gap-0.5 flex-1">
            <div
                v-for="i in 4"
                :key="i"
                class="h-1 flex-1 rounded-full transition-all duration-300"
                :class="nivelClasse(i)"
            ></div>
        </div>
        <span class="text-[10px] font-medium" :class="textoClasse">{{ textoNivel }}</span>
    </div>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
    password: { type: String, default: '' },
})

const nivel = computed(() => {
    const p = props.password
    if (!p) return 0
    let score = 0
    if (p.length >= 8) score++
    if (p.length >= 12) score++
    if (/[A-Z]/.test(p)) score++
    if (/[a-z]/.test(p)) score++
    if (/[0-9]/.test(p)) score++
    if (/[^A-Za-z0-9]/.test(p)) score++
    if (score <= 2) return 1
    if (score <= 4) return 2
    if (score <= 5) return 3
    return 4
})

const textoNivel = computed(() => ['', 'Fraca', 'Média', 'Forte', 'Muito forte'][nivel.value])
const textoClasse = computed(() => ['', 'text-red-500', 'text-amber-500', 'text-lime-500', 'text-green-600'][nivel.value])

function nivelClasse(i) {
    if (i <= nivel.value) {
        return ['', 'bg-red-400', 'bg-amber-400', 'bg-lime-400', 'bg-green-500'][nivel.value]
    }
    return 'bg-base-200'
}
</script>
