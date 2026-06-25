<template>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-5">
        <div v-for="i in 6" :key="i" class="bg-base-100 border border-base-200 rounded-xl overflow-hidden animate-pulse">
            <div class="aspect-[4/3] bg-base-300/50"></div>
            <div class="p-4 space-y-3">
                <div class="h-4 bg-base-300/50 rounded w-3/4"></div>
                <div class="h-3 bg-base-300/50 rounded w-full"></div>
                <div class="h-3 bg-base-300/50 rounded w-1/2"></div>
                <div class="flex gap-2">
                    <div class="h-4 bg-base-300/50 rounded w-16"></div>
                    <div class="h-4 bg-base-300/50 rounded w-12"></div>
                </div>
            </div>
        </div>
    </div>
</template>
