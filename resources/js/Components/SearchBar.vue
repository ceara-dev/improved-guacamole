<template>
    <div class="join w-full">
        <div class="relative flex-1">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 absolute left-3 top-1/2 -translate-y-1/2 text-base-content/30" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
            <input
                type="text"
                :value="search"
                @input="$emit('update:search', $event.target.value)"
                placeholder="Buscar destinos..."
                class="input input-bordered join-item w-full bg-base-200/50 border-base-200 text-sm pl-9 rounded-l-full focus:bg-base-100 transition-colors"
            />
        </div>
        <button class="btn btn-primary join-item rounded-r-full">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
        </button>
    </div>
</template>

<script setup>
defineProps({
    search: { type: String, default: '' },
})

defineEmits(['update:search'])
</script>
