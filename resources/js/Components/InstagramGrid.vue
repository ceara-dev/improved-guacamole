<template>
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-1">
        <Link
            v-for="post in posts"
            :key="post.id"
            :href="`/pontos-turisticos/${post.id}`"
            class="group relative aspect-square bg-base-200 overflow-hidden cursor-pointer rounded-md"
        >
            <img
                :src="post.imagem"
                :alt="post.nome"
                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                @error="onImgError"
            />
            <div class="absolute inset-0 bg-black/0 group-hover:bg-black/30 transition-colors duration-300 flex items-center justify-center">
                <div class="opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center gap-4 text-white font-semibold text-xs">
                    <span class="flex items-center gap-1">
                        <span class="drop-shadow-md">❤️</span>
                        <span class="drop-shadow-md">{{ post.curtidas }}</span>
                    </span>
                    <span class="flex items-center gap-1">
                        <span class="drop-shadow-md">💬</span>
                        <span class="drop-shadow-md">{{ post.comentarios_count }}</span>
                    </span>
                </div>
            </div>
            <div class="absolute top-1.5 left-1.5 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                <div class="badge badge-xs bg-base-100/90 backdrop-blur-sm gap-1">
                    <span>{{ post.categoria_icone }}</span>
                    <span class="hidden sm:inline">{{ post.categoria }}</span>
                </div>
            </div>
            <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/60 to-transparent p-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                <p class="text-white text-xs font-semibold truncate">{{ post.nome }}</p>
                <p class="text-white/70 text-[10px] truncate">{{ post.cidade }}, {{ post.estado }}</p>
            </div>
        </Link>
    </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'

defineProps({
    posts: { type: Array, required: true },
})

function onImgError(e) {
    e.target.src = `https://picsum.photos/seed/${e.target.alt}/400/400`
}
</script>
