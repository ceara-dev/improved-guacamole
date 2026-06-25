<template>
    <Link
        :href="href"
        class="flex w-full items-center border-l-4 py-2 pe-4 ps-3 text-sm font-medium transition duration-150 ease-in-out focus:outline-none"
        :class="active
            ? 'border-primary bg-primary/10 text-primary'
            : 'border-transparent text-base-content/60 hover:border-base-300 hover:bg-base-200 hover:text-base-content focus:border-base-300 focus:bg-base-200 focus:text-base-content'"
    >
        <slot />
    </Link>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'

defineProps({
    href: { type: String, required: true },
    active: { type: Boolean, default: false },
})
</script>
