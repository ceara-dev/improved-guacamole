<template>
    <div class="min-h-screen bg-gradient-to-br from-sky-50 via-white to-purple-50 flex flex-col items-center justify-center px-4 py-12">
        <div class="w-full max-w-sm">
            <div class="text-center mb-8">
                <Link href="/" class="inline-flex items-center gap-2.5">
                    <span class="text-4xl">👁️</span>
                </Link>
                <h1 class="text-2xl font-bold mt-4 tracking-tight">OlharViajante</h1>
                <p class="text-sm text-base-content/50 mt-1">Entre para continuar explorando</p>
            </div>

            <div class="bg-white rounded-2xl shadow-xl shadow-blue-100/50 border border-gray-100 p-8">
                <form @submit.prevent="submit" class="space-y-5">
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
                                placeholder="••••••••"
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
                        <p v-if="errors.password" class="text-xs text-red-500 mt-1">{{ errors.password }}</p>
                    </div>

                    <div class="flex items-center justify-between text-xs">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input v-model="form.remember" type="checkbox" class="checkbox checkbox-xs checkbox-primary" />
                            <span class="text-base-content/60">Lembrar-me</span>
                        </label>
                        <Link href="/forgot-password" class="text-primary hover:underline font-medium">Esqueceu a senha?</Link>
                    </div>

                    <button
                        type="submit"
                        class="btn btn-primary w-full"
                        :disabled="enviando"
                    >
                        <span v-if="enviando" class="loading loading-spinner loading-xs"></span>
                        {{ enviando ? 'Entrando...' : 'Entrar' }}
                    </button>
                </form>

                <div class="relative my-6">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-200"></div>
                    </div>
                    <div class="relative flex justify-center text-xs">
                        <span class="bg-white px-3 text-base-content/40">ou</span>
                    </div>
                </div>

                <p class="text-center text-xs text-base-content/50">
                    Não tem conta?
                    <Link href="/register" class="text-primary font-semibold hover:underline">Criar conta</Link>
                </p>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, reactive } from 'vue'
import { Link, router } from '@inertiajs/vue3'

const form = reactive({
    email: '',
    password: '',
    remember: false,
})

const errors = reactive({ email: '', password: '' })
const showPassword = ref(false)
const enviando = ref(false)

function submit() {
    enviando.value = true
    router.post('/login', form, {
        preserveScroll: true,
        onError: (errs) => {
            Object.assign(errors, errs)
            enviando.value = false
        },
        onFinish: () => { enviando.value = false },
    })
}
</script>
