<template>
    <div class="relative">
        <div @click="open = !open">
            <slot name="trigger" />
        </div>

        <div v-if="open" class="fixed inset-0 z-40" @click="open = false"></div>

        <Transition
            enter-active-class="transition duration-200 ease-out"
            enter-from-class="translate-y-1 opacity-0"
            enter-to-class="translate-y-0 opacity-100"
            leave-active-class="transition duration-150 ease-in"
            leave-from-class="translate-y-0 opacity-100"
            leave-to-class="translate-y-1 opacity-0"
        >
            <div
                v-if="open"
                class="absolute z-50 mt-2 rounded-md shadow-lg"
                :class="[width === '48' ? 'w-48' : '', alignmentClasses]"
            >
                <div class="rounded-md ring-1 ring-base-200/50 py-1 bg-base-100">
                    <slot name="content" />
                </div>
            </div>
        </Transition>
    </div>
</template>

<script setup>
import { ref, computed } from 'vue'

const props = defineProps({
    align: { type: String, default: 'right' },
    width: { type: String, default: '48' },
})

const open = ref(false)

const alignmentClasses = computed(() => {
    if (props.align === 'left') return 'ltr:left-0 rtl:right-0'
    if (props.align === 'right') return 'ltr:right-0 rtl:left-0'
    return 'ltr:left-0 rtl:right-0'
})
</script>
