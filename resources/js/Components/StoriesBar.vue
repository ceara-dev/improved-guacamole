<template>
    <div class="relative mb-6">
        <div class="flex items-center justify-between mb-3">
            <h2 class="text-sm font-semibold text-base-content/70">Stories</h2>
            <span class="text-xs text-base-content/40">{{ stories.length }} disponíveis</span>
        </div>

        <div class="flex gap-4 overflow-x-auto scroll-smooth pb-1 scrollbar-hide" ref="scrollRef">
            <div class="flex flex-col items-center gap-1 flex-shrink-0 cursor-pointer opacity-60 hover:opacity-100 transition-opacity">
                <div class="w-16 h-16 rounded-full border-2 border-dashed border-base-content/30 flex items-center justify-center text-xl text-base-content/30 hover:text-base-content/50 hover:border-base-content/50 transition-colors">
                    +
                </div>
                <span class="text-[11px] text-base-content/40 truncate max-w-16 text-center">Adicionar</span>
            </div>

            <div
                v-for="story in stories"
                :key="story.id"
                @click="abrirStory(story)"
                class="flex flex-col items-center gap-1 cursor-pointer flex-shrink-0 group transition-opacity duration-200"
                :class="story.visto ? 'opacity-60 hover:opacity-90' : 'hover:opacity-90'"
            >
                <div class="relative">
                    <div class="w-16 h-16 rounded-full p-[3px] transition-transform duration-300 group-hover:scale-105" :class="story.visto ? 'bg-base-300' : 'bg-gradient-to-tr from-yellow-400 via-pink-500 to-purple-600'">
                        <div class="w-full h-full rounded-full overflow-hidden border-2 border-base-100">
                            <img
                                :src="story.imagem"
                                :alt="story.nome"
                                class="w-full h-full object-cover"
                                @error="onImgError"
                            />
                        </div>
                    </div>
                    <span v-if="story.avaliacao >= 4.5" class="absolute -top-1 -right-1 w-5 h-5 bg-amber-400 rounded-full flex items-center justify-center text-[10px] font-bold shadow">
                        ★
                    </span>
                </div>
                <span class="text-[11px] text-base-content/60 truncate max-w-16 text-center">{{ story.nome_curto }}</span>
            </div>
        </div>

        <button
            v-if="podeScrollarEsquerda"
            @click="scroll(-200)"
            class="absolute left-0 top-1/2 -translate-y-1/2 w-7 h-7 rounded-full bg-base-100/90 shadow border border-base-200 flex items-center justify-center text-sm hover:bg-base-100 transition-all backdrop-blur-sm hidden sm:flex"
        >‹</button>
        <button
            v-if="podeScrollarDireita"
            @click="scroll(200)"
            class="absolute right-0 top-1/2 -translate-y-1/2 w-7 h-7 rounded-full bg-base-100/90 shadow border border-base-200 flex items-center justify-center text-sm hover:bg-base-100 transition-all backdrop-blur-sm hidden sm:flex"
        >›</button>
    </div>
</template>

<script setup>
import { ref, computed } from 'vue'

const props = defineProps({
    stories: { type: Array, required: true },
})

const emit = defineEmits(['open-story'])
const scrollRef = ref(null)
const podeScrollarEsquerda = ref(false)
const podeScrollarDireita = ref(true)

function abrirStory(story) {
    story.visto = true
    emit('open-story', story)
}

function scroll(dist) {
    if (scrollRef.value) {
        scrollRef.value.scrollBy({ left: dist, behavior: 'smooth' })
    }
}

function onImgError(e) {
    e.target.src = `https://ui-avatars.com/api/?name=${encodeURIComponent(e.target.alt)}&background=random&size=128`
}
</script>

<style scoped>
.scrollbar-hide::-webkit-scrollbar { display: none; }
.scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
</style>
