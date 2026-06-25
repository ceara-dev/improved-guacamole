<template>
    <div class="min-h-screen bg-gradient-to-br from-sky-50 via-white to-purple-50 flex flex-col items-center justify-center px-4 py-12">
        <div class="w-full max-w-sm">
            <div class="text-center mb-8">
                <Link href="/" class="inline-flex items-center gap-2.5">
                    <span class="text-4xl">👁️</span>
                </Link>
                <h1 class="text-2xl font-bold mt-4 tracking-tight">Criar Conta</h1>
                <p class="text-sm text-base-content/50 mt-1">Junte-se ao OlharViajante</p>
            </div>

            <div class="bg-white rounded-2xl shadow-xl shadow-blue-100/50 border border-gray-100 p-8">
                <form @submit.prevent="submit" class="space-y-4">
                    <div class="form-control">
                        <label class="label py-0 pb-1.5">
                            <span class="label-text text-xs font-medium">Nome completo</span>
                        </label>
                        <input
                            v-model="form.name"
                            type="text"
                            placeholder="Seu nome"
                            class="input input-bordered w-full text-sm"
                            :class="{ 'input-error': errors.name }"
                            @input="errors.name = ''"
                        />
                        <p v-if="errors.name" class="text-xs text-red-500 mt-1">{{ errors.name }}</p>
                    </div>

                    <div class="form-control">
                        <label class="label py-0 pb-1.5">
                            <span class="label-text text-xs font-medium">Email</span>
                        </label>
                        <input
                            v-model="form.email"
                            type="email"
                            placeholder="seu@email.com"
                            class="input input-bordered w-full text-sm"
                            :class="{ 'input-error': errors.email }"
                            @input="errors.email = ''"
                        />
                        <p v-if="errors.email" class="text-xs text-red-500 mt-1">{{ errors.email }}</p>
                    </div>

                    <div class="form-control">
                        <label class="label py-0 pb-1.5">
                            <span class="label-text text-xs font-medium">Senha</span>
                        </label>
                        <div class="relative">
                            <input
                                v-model="form.password"
                                :type="showPassword ? 'text' : 'password'"
                                placeholder="Mínimo 8 caracteres"
                                class="input input-bordered w-full text-sm pr-10"
                                :class="{ 'input-error': errors.password }"
                                @input="errors.password = ''"
                            />
                            <button
                                type="button"
                                @click="showPassword = !showPassword"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-base-content/40 hover:text-base-content/70"
                            >
                                <svg v-if="!showPassword" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <svg v-else xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878l-4.243 4.242" />
                                </svg>
                            </button>
                        </div>
                        <div class="mt-2">
                            <PasswordStrength :password="form.password" />
                        </div>
                        <p v-if="errors.password" class="text-xs text-red-500 mt-1">{{ errors.password }}</p>
                    </div>

                    <div class="form-control">
                        <label class="label py-0 pb-1.5">
                            <span class="label-text text-xs font-medium">Confirmar senha</span>
                        </label>
                        <input
                            v-model="form.password_confirmation"
                            type="password"
                            placeholder="Repita a senha"
                            class="input input-bordered w-full text-sm"
                            @input="errors.password_confirmation = ''"
                        />
                    </div>

                    <label class="flex items-start gap-2 cursor-pointer">
                        <input v-model="form.terms" type="checkbox" class="checkbox checkbox-xs checkbox-primary mt-0.5" />
                        <span class="text-xs text-base-content/50 leading-relaxed">
                            Aceito os
                            <a href="#" class="text-primary hover:underline">Termos de Uso</a>
                            e a
                            <a href="#" class="text-primary hover:underline">Política de Privacidade</a>
                        </span>
                    </label>
                    <p v-if="errors.terms" class="text-xs text-red-500">{{ errors.terms }}</p>

                    <button
                        type="submit"
                        class="btn btn-primary w-full"
                        :disabled="enviando"
                    >
                        <span v-if="enviando" class="loading loading-spinner loading-xs"></span>
                        {{ enviando ? 'Criando conta...' : 'Criar conta' }}
                    </button>
                </form>

                <p class="text-center text-xs text-base-content/50 mt-6">
                    Já tem conta?
                    <Link href="/login" class="text-primary font-semibold hover:underline">Fazer login</Link>
                </p>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, reactive } from 'vue'
import { Link, router } from '@inertiajs/vue3'
import PasswordStrength from '../../Components/PasswordStrength.vue'

const form = reactive({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    terms: false,
})

const errors = reactive({ name: '', email: '', password: '', terms: '' })
const showPassword = ref(false)
const enviando = ref(false)

function submit() {
    enviando.value = true
    router.post('/register', form, {
        preserveScroll: true,
        onError: (errs) => {
            Object.assign(errors, errs)
            enviando.value = false
        },
        onFinish: () => { enviando.value = false },
    })
}
</script>
