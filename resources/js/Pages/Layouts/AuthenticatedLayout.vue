<template>
    <div class="min-h-screen bg-base-200">
        <nav class="border-b border-base-200 bg-base-100">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex h-16 justify-between">
                    <div class="flex">
                        <div class="flex shrink-0 items-center">
                            <Link href="/" class="flex items-center gap-2">
                                <span class="text-2xl">👁️</span>
                                <span class="text-lg font-bold tracking-tight hidden sm:inline">OlharViajante</span>
                            </Link>
                        </div>

                        <div class="hidden space-x-6 sm:-my-px sm:ms-10 sm:flex">
                            <NavLink href="/" :active="rotaAtiva === '/'">
                                Início
                            </NavLink>
                            <NavLink href="/favoritos" :active="rotaAtiva.startsWith('/favoritos')">
                                Favoritos
                            </NavLink>
                            <NavLink href="/profile" :active="rotaAtiva.startsWith('/profile')">
                                Perfil
                            </NavLink>
                        </div>
                    </div>

                    <div class="hidden sm:ms-6 sm:flex sm:items-center">
                        <button @click="toggleTheme" class="btn btn-ghost btn-sm btn-circle mr-2" :title="isDark ? 'Tema claro' : 'Tema escuro'">
                            <svg v-if="!isDark" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                            </svg>
                            <svg v-else xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v1m0 16v1m9-9h-1M4 12h1m15.364 6.364l-.343-.343M6.343 6.343l-.343-.343m12.728 0l-.343.343M6.343 17.657l-.343.343M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </button>

                        <div class="relative ms-3">
                            <Dropdown align="right" width="48">
                                <template #trigger>
                                    <span class="inline-flex rounded-md">
                                        <button type="button" class="inline-flex items-center rounded-md border border-transparent bg-base-100 px-3 py-2 text-sm font-medium leading-4 text-base-content/60 transition duration-150 ease-in-out hover:text-base-content focus:outline-none">
                                            <div class="w-6 h-6 rounded-full bg-gradient-to-br from-primary to-secondary flex items-center justify-center text-white text-xs font-bold overflow-hidden mr-2">
                                                <img v-if="user.avatar" :src="`/storage/${user.avatar}`" class="w-full h-full object-cover" />
                                                <span v-else>{{ iniciais }}</span>
                                            </div>
                                            {{ user.name }}
                                            <svg class="-me-0.5 ms-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </span>
                                </template>

                                <template #content>
                                    <DropdownLink href="/profile">
                                        Perfil
                                    </DropdownLink>
                                    <DropdownLink href="/favoritos">
                                        Favoritos
                                    </DropdownLink>
                                    <DropdownLink href="/logout" as="button" method="post">
                                        Sair
                                    </DropdownLink>
                                </template>
                            </Dropdown>
                        </div>
                    </div>

                    <div class="-me-2 flex items-center sm:hidden">
                        <button @click="mostrarNav = !mostrarNav" class="inline-flex items-center justify-center rounded-md p-2 text-base-content/60 transition duration-150 ease-in-out hover:bg-base-200 hover:text-base-content focus:bg-base-200 focus:text-base-content focus:outline-none">
                            <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                <path :class="{ hidden: mostrarNav, 'inline-flex': !mostrarNav }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                <path :class="{ hidden: !mostrarNav, 'inline-flex': mostrarNav }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <div :class="{ block: mostrarNav, hidden: !mostrarNav }" class="sm:hidden">
                <div class="space-y-1 pb-3 pt-2">
                    <ResponsiveNavLink href="/" :active="rotaAtiva === '/'">
                        Início
                    </ResponsiveNavLink>
                    <ResponsiveNavLink href="/favoritos" :active="rotaAtiva.startsWith('/favoritos')">
                        Favoritos
                    </ResponsiveNavLink>
                    <ResponsiveNavLink href="/profile" :active="rotaAtiva.startsWith('/profile')">
                        Perfil
                    </ResponsiveNavLink>
                </div>

                <div class="border-t border-base-200 pb-1 pt-4">
                    <div class="px-4">
                        <div class="text-base font-medium text-base-content">{{ user.name }}</div>
                        <div class="text-sm font-medium text-base-content/60">{{ user.email }}</div>
                    </div>
                    <div class="mt-3 space-y-1">
                        <ResponsiveNavLink href="/profile">Perfil</ResponsiveNavLink>
                        <ResponsiveNavLink href="/logout" method="post" as="button">Sair</ResponsiveNavLink>
                    </div>
                </div>
            </div>
        </nav>

        <header v-if="$slots.header" class="bg-base-100 border-b border-base-200">
            <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
                <slot name="header" />
            </div>
        </header>

        <main class="py-6 sm:py-8">
            <slot />
        </main>
    </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import { Link, router, usePage } from '@inertiajs/vue3'
import Dropdown from '@/Components/Dropdown.vue'
import DropdownLink from '@/Components/DropdownLink.vue'
import NavLink from '@/Components/NavLink.vue'
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue'

const user = computed(() => usePage().props?.auth?.user || null)
const rotaAtiva = computed(() => usePage().url)
const mostrarNav = ref(false)
const isDark = ref(false)

const iniciais = computed(() =>
    user.value ? user.value.name.split(' ').map(s => s[0]).join('').toUpperCase().slice(0, 2) : ''
)

function toggleTheme() {
    isDark.value = !isDark.value
    document.documentElement.setAttribute('data-theme', isDark.value ? 'dark' : 'light')
    localStorage.setItem('theme', isDark.value ? 'dark' : 'light')
}

function logout() {
    router.post('/logout', {}, { preserveScroll: true })
}

onMounted(() => {
    const savedTheme = localStorage.getItem('theme')
    if (savedTheme === 'dark') {
        isDark.value = true
        document.documentElement.setAttribute('data-theme', 'dark')
    }
})
</script>
