<template>
    <AuthenticatedLayout>
        <div class="max-w-4xl mx-auto">
            <div class="flex items-center gap-4 mb-8">
                <div>
                    <h1 class="text-2xl font-bold tracking-tight">Meu Perfil</h1>
                    <p class="text-sm text-base-content/50 mt-0.5">Gerencie suas informações e favoritos</p>
                </div>
            </div>

            <!-- Profile card + Stats -->
            <div class="bg-white rounded-2xl shadow-xl shadow-blue-100/50 border border-gray-100 p-6 mb-6">
                <div class="flex items-center gap-5">
                    <div class="relative">
                        <div class="w-16 h-16 rounded-full bg-gradient-to-br from-primary to-secondary flex items-center justify-center text-white text-xl font-bold overflow-hidden">
                            <img v-if="avatarUrl" :src="avatarUrl" class="w-full h-full object-cover" />
                            <span v-else>{{ iniciais }}</span>
                        </div>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h2 class="text-lg font-bold truncate">{{ user.name }}</h2>
                        <p v-if="user.bio" class="text-sm text-base-content/60 truncate">{{ user.bio }}</p>
                        <p v-else class="text-sm text-base-content/40 italic">Nenhuma bio definida</p>
                        <div v-if="user.location" class="flex items-center gap-1 text-xs text-base-content/50 mt-0.5">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            {{ user.location }}
                        </div>
                    </div>
                    <div class="text-right text-xs text-base-content/40">
                        <span>Membro desde {{ memberSince }}</span>
                    </div>
                </div>

                <!-- Stats -->
                <div class="grid grid-cols-3 gap-4 mt-6 pt-6 border-t border-gray-100">
                    <div class="text-center">
                        <span class="text-2xl font-bold text-primary">{{ stats.favoritos }}</span>
                        <p class="text-xs text-base-content/50 mt-0.5">Favoritos</p>
                    </div>
                    <div class="text-center">
                        <span class="text-2xl font-bold text-amber-500">{{ formatNumber(stats.curtidas) }}</span>
                        <p class="text-xs text-base-content/50 mt-0.5">Curtidas</p>
                    </div>
                    <div class="text-center">
                        <span class="text-2xl font-bold text-sky-500">{{ formatNumber(stats.visualizacoes) }}</span>
                        <p class="text-xs text-base-content/50 mt-0.5">Visualizações</p>
                    </div>
                </div>
            </div>

            <!-- Tabs -->
            <div class="tabs tabs-bordered mb-6">
                <button
                    v-for="tab in tabs"
                    :key="tab.key"
                    @click="abaAtiva = tab.key"
                    class="tab tab-lg text-sm font-medium"
                    :class="abaAtiva === tab.key ? 'tab-active text-primary' : 'text-base-content/50 hover:text-base-content/70'"
                >
                    {{ tab.label }}
                </button>
            </div>

            <!-- Tab: Favoritos -->
            <div v-if="abaAtiva === 'favoritos'" class="space-y-4">
                <div v-if="favoritos.length === 0" class="text-center py-12">
                    <div class="text-5xl mb-4 opacity-20">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                        </svg>
                    </div>
                    <p class="text-sm text-base-content/40">Nenhum favorito ainda.</p>
                    <Link href="/" class="btn btn-primary btn-sm mt-4">Explorar destinos</Link>
                </div>
                <div v-else class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                    <Link
                        v-for="f in favoritos"
                        :key="f.id"
                        :href="`/pontos-turisticos/${f.id}`"
                        class="group bg-white rounded-xl border border-gray-100 overflow-hidden shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all duration-300"
                    >
                        <div class="aspect-[4/3] bg-base-200 overflow-hidden">
                            <img :src="f.imagem" :alt="f.nome" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" @error="e => e.target.src = `https://picsum.photos/seed/${f.nome}/600/400`" />
                        </div>
                        <div class="p-3">
                            <div class="flex items-center gap-1.5 mb-1">
                                <span class="text-xs">{{ f.categoria_icone }}</span>
                                <span class="text-[10px] text-base-content/40 font-medium">{{ f.categoria }}</span>
                            </div>
                            <p class="text-sm font-semibold line-clamp-1">{{ f.nome }}</p>
                            <p class="text-xs text-base-content/50 mt-1">{{ f.cidade }}, {{ f.estado }}</p>
                        </div>
                    </Link>
                </div>
                <div v-if="favoritos.length > 0 && favoritos.length >= 12" class="text-center pt-4">
                    <Link href="/favoritos" class="btn btn-outline btn-sm">Ver todos os favoritos</Link>
                </div>
            </div>

            <!-- Tab: Configurações -->
            <div v-if="abaAtiva === 'configuracoes'" class="space-y-6">
                <!-- Profile form -->
                <div class="bg-white rounded-2xl shadow-xl shadow-blue-100/50 border border-gray-100 p-8">
                    <form @submit.prevent="salvarPerfil">
                        <h3 class="text-base font-bold mb-4">Informações do perfil</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="form-control">
                                <label class="label py-0 pb-1.5">
                                    <span class="label-text text-xs font-medium">Nome</span>
                                </label>
                                <input v-model="perfil.name" type="text" class="input input-bordered w-full text-sm" :class="{ 'input-error': errors.name }" @input="errors.name = ''" />
                                <p v-if="errors.name" class="text-xs text-red-500 mt-1">{{ errors.name }}</p>
                            </div>
                            <div class="form-control">
                                <label class="label py-0 pb-1.5">
                                    <span class="label-text text-xs font-medium">Email</span>
                                </label>
                                <input :value="user.email" type="email" disabled class="input input-bordered w-full text-sm bg-base-200/50" />
                            </div>
                        </div>
                        <div class="form-control mt-4">
                            <label class="label py-0 pb-1.5">
                                <span class="label-text text-xs font-medium">Bio</span>
                            </label>
                            <textarea v-model="perfil.bio" rows="3" class="textarea textarea-bordered text-sm" :class="{ 'textarea-error': errors.bio }" @input="errors.bio = ''"></textarea>
                            <p v-if="errors.bio" class="text-xs text-red-500 mt-1">{{ errors.bio }}</p>
                        </div>
                        <div class="form-control mt-4">
                            <label class="label py-0 pb-1.5">
                                <span class="label-text text-xs font-medium">Localização</span>
                            </label>
                            <input v-model="perfil.location" type="text" placeholder="Cidade, Estado" class="input input-bordered w-full text-sm" />
                        </div>
                        <div class="flex items-center gap-3 pt-4">
                            <button type="submit" class="btn btn-primary" :disabled="enviandoPerfil">
                                <span v-if="enviandoPerfil" class="loading loading-spinner loading-xs"></span>
                                Salvar perfil
                            </button>
                            <span v-if="msgPerfil" class="text-xs text-green-600 font-medium">{{ msgPerfil }}</span>
                        </div>
                    </form>
                </div>

                <!-- Avatar -->
                <div class="bg-white rounded-2xl shadow-xl shadow-blue-100/50 border border-gray-100 p-8">
                    <h3 class="text-base font-bold mb-4">Foto do perfil</h3>
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 rounded-full bg-gradient-to-br from-primary to-secondary flex items-center justify-center text-white font-bold overflow-hidden shrink-0">
                            <img v-if="avatarUrl" :src="avatarUrl" class="w-full h-full object-cover" />
                        </div>
                        <div class="flex-1">
                            <input type="file" accept="image/*" @change="uploadAvatar" class="file-input file-input-bordered file-input-sm w-full text-sm" />
                        </div>
                    </div>
                </div>

                <!-- Password -->
                <div class="bg-white rounded-2xl shadow-xl shadow-blue-100/50 border border-gray-100 p-8">
                    <form @submit.prevent="salvarSenha">
                        <h3 class="text-base font-bold mb-4">Alterar senha</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            <div class="form-control">
                                <label class="label py-0 pb-1.5">
                                    <span class="label-text text-xs font-medium">Senha atual</span>
                                </label>
                                <input v-model="senha.current_password" type="password" class="input input-bordered w-full text-sm" :class="{ 'input-error': errors.current_password }" @input="errors.current_password = ''" />
                                <p v-if="errors.current_password" class="text-xs text-red-500 mt-1">{{ errors.current_password }}</p>
                            </div>
                            <div class="form-control">
                                <label class="label py-0 pb-1.5">
                                    <span class="label-text text-xs font-medium">Nova senha</span>
                                </label>
                                <input v-model="senha.password" type="password" class="input input-bordered w-full text-sm" :class="{ 'input-error': errors.password }" @input="errors.password = ''" />
                                <p v-if="errors.password" class="text-xs text-red-500 mt-1">{{ errors.password }}</p>
                            </div>
                            <div class="form-control">
                                <label class="label py-0 pb-1.5">
                                    <span class="label-text text-xs font-medium">Confirmar</span>
                                </label>
                                <input v-model="senha.password_confirmation" type="password" class="input input-bordered w-full text-sm" />
                            </div>
                        </div>
                        <div class="flex items-center gap-3 pt-4">
                            <button type="submit" class="btn btn-primary" :disabled="enviandoSenha">
                                <span v-if="enviandoSenha" class="loading loading-spinner loading-xs"></span>
                                Alterar senha
                            </button>
                            <span v-if="msgSenha" class="text-xs text-green-600 font-medium">{{ msgSenha }}</span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import { ref, reactive, computed } from 'vue'
import { Link, router, usePage } from '@inertiajs/vue3'
import AuthenticatedLayout from './Layouts/AuthenticatedLayout.vue'

const props = defineProps({
    user: { type: Object, required: true },
    stats: { type: Object, default: () => ({ favoritos: 0, curtidas: 0, visualizacoes: 0 }) },
    favoritos: { type: Array, default: () => [] },
})

const tabs = [
    { key: 'favoritos', label: 'Meus Favoritos' },
    { key: 'configuracoes', label: 'Configurações' },
]
const abaAtiva = ref('favoritos')

const iniciais = computed(() =>
    (props.user.name || '').split(' ').map(s => s[0]).join('').toUpperCase().slice(0, 2)
)

const avatarUrl = computed(() => {
    if (!props.user.avatar) return null
    return props.user.avatar.startsWith('http') ? props.user.avatar : `/storage/${props.user.avatar}`
})

const memberSince = computed(() => {
    if (!props.user.created_at) return ''
    return new Date(props.user.created_at).toLocaleDateString('pt-BR', { month: 'long', year: 'numeric' })
})

const perfil = reactive({
    name: props.user.name || '',
    bio: props.user.bio || '',
    location: props.user.location || '',
})

const senha = reactive({
    current_password: '',
    password: '',
    password_confirmation: '',
})

const errors = reactive({ name: '', bio: '', current_password: '', password: '' })
const enviandoPerfil = ref(false)
const enviandoSenha = ref(false)
const msgPerfil = ref('')
const msgSenha = ref('')

function salvarPerfil() {
    enviandoPerfil.value = true
    msgPerfil.value = ''

    router.patch('/profile', {
        name: perfil.name,
        bio: perfil.bio,
        location: perfil.location,
    }, {
        preserveScroll: true,
        onError: (errs) => {
            Object.assign(errors, errs)
            enviandoPerfil.value = false
        },
        onSuccess: () => {
            msgPerfil.value = 'Perfil atualizado!'
            enviandoPerfil.value = false
            setTimeout(() => { msgPerfil.value = '' }, 3000)
        },
        onFinish: () => { enviandoPerfil.value = false },
    })
}

function salvarSenha() {
    enviandoSenha.value = true
    msgSenha.value = ''

    router.post('/profile/password', {
        current_password: senha.current_password,
        password: senha.password,
        password_confirmation: senha.password_confirmation,
    }, {
        preserveScroll: true,
        onError: (errs) => {
            Object.assign(errors, errs)
            enviandoSenha.value = false
        },
        onSuccess: () => {
            msgSenha.value = 'Senha alterada!'
            senha.current_password = ''
            senha.password = ''
            senha.password_confirmation = ''
            enviandoSenha.value = false
            setTimeout(() => { msgSenha.value = '' }, 3000)
        },
        onFinish: () => { enviandoSenha.value = false },
    })
}

function uploadAvatar(e) {
    const file = e.target.files[0]
    if (!file) return
    const formData = new FormData()
    formData.append('avatar', file)
    router.post('/profile/avatar', formData, {
        preserveScroll: true,
        onError: (errs) => { Object.assign(errors, errs) },
    })
}

function formatNumber(n) {
    if (n >= 1000) return (n / 1000).toFixed(1) + 'k'
    return n
}
</script>
