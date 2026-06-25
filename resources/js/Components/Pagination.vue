<template>
    <div v-if="links.length > 3" class="flex flex-col items-center gap-2 mt-8">
        <div class="join">
            <button
                v-for="(link, i) in links"
                :key="i"
                @click="navigate(link)"
                :disabled="!link.url"
                class="join-item btn btn-sm transition-all"
                :class="{ 'btn-active btn-primary': link.active, 'btn-ghost': !link.active }"
                v-html="link.label"
            />
        </div>
        <div class="text-xs text-base-content/50">
            Página {{ currentPage }} de {{ lastPage }}
        </div>
    </div>
</template>

<script setup>
import { computed } from 'vue'
import { router } from '@inertiajs/vue3'

const props = defineProps({
    links: { type: Array, required: true },
})

const currentPage = computed(() => {
    const activeLink = props.links.find(l => l.active)
    return activeLink ? activeLink.label : 1
})

const lastPage = computed(() => {
    return Math.max(...props.links.map(l => parseInt(l.label) || 0))
})

function navigate(link) {
    if (link.url && !link.active) {
        router.get(link.url, {}, {
            preserveState: true,
            preserveScroll: true,
            replace: true,
        })
    }
}
</script>
