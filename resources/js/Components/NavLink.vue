<template>
    <Link
        :href="href"
        class="inline-flex items-center border-b-2 px-1 pt-1 text-sm font-medium leading-5 transition duration-150 ease-in-out focus:outline-none"
        :class="active
            ? 'border-primary text-base-content focus:border-primary'
            : 'border-transparent text-base-content/60 hover:border-base-300 hover:text-base-content focus:border-base-300 focus:text-base-content'"
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
