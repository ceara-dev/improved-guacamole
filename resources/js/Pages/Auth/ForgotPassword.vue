<template>
    <div class="min-h-screen bg-gradient-to-br from-sky-50 via-white to-purple-50 flex flex-col items-center justify-center px-4 py-12">
        <div class="w-full max-w-sm">
            <div class="text-center mb-8">
                <Link href="/" class="inline-flex items-center gap-2.5">
                    <span class="text-4xl">👁️</span>
                </Link>
                <h1 class="text-2xl font-bold mt-4 tracking-tight">Esqueceu a senha?</h1>
                <p class="text-sm text-base-content/50 mt-1">Digite seu email para receber o link de recuperação</p>
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

                    <button
                        type="submit"
                        class="btn btn-primary w-full"
                        :disabled="enviando"
                    >
                        <span v-if="enviando" class="loading loading-spinner loading-xs"></span>
                        {{ enviando ? 'Enviando...' : 'Enviar link de recuperação' }}
                    </button>
                </form>

                <p class="text-center text-xs text-base-content/50 mt-6">
                    <Link href="/login" class="text-primary font-semibold hover:underline">Voltar ao login</Link>
                </p>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, reactive } from 'vue'
import { Link, router } from '@inertiajs/vue3'

const form = reactive({ email: '' })
const errors = reactive({ email: '' })
const enviando = ref(false)

function submit() {
    enviando.value = true
    router.post('/forgot-password', form, {
        preserveScroll: true,
        onError: (errs) => {
            Object.assign(errors, errs)
            enviando.value = false
        },
        onFinish: () => { enviando.value = false },
    })
}
</script>
