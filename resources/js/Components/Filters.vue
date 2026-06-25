<template>
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
        <div class="form-control">
            <label class="label py-1">
                <span class="label-text text-xs font-medium">Categoria</span>
            </label>
            <select
                :value="filtros.categoria"
                @change="atualizar('categoria', $event.target.value)"
                class="select select-bordered select-sm w-full min-w-32 bg-base-100 hover:bg-base-200/50 transition-colors"
            >
                <option value="">Todas</option>
                <option v-for="cat in categorias" :key="cat" :value="cat">{{ cat }}</option>
            </select>
        </div>

        <div class="form-control">
            <label class="label py-1">
                <span class="label-text text-xs font-medium">Estado</span>
            </label>
            <select
                :value="filtros.uf"
                @change="atualizar('uf', $event.target.value)"
                class="select select-bordered select-sm w-full min-w-24 bg-base-100 hover:bg-base-200/50 transition-colors"
            >
                <option value="">Todos</option>
                <option v-for="uf in ufs" :key="uf" :value="uf">{{ uf }}</option>
            </select>
        </div>

        <div class="form-control">
            <label class="label py-1">
                <span class="label-text text-xs font-medium">Cidade</span>
            </label>
            <select
                :value="filtros.cidade"
                @change="atualizar('cidade', $event.target.value)"
                class="select select-bordered select-sm w-full min-w-32 bg-base-100 hover:bg-base-200/50 transition-colors"
            >
                <option value="">Todas</option>
                <option v-for="cid in cidades" :key="cid" :value="cid">{{ cid }}</option>
            </select>
        </div>

        <div class="form-control">
            <label class="label py-1">
                <span class="label-text text-xs font-medium">Ordenar</span>
            </label>
            <select
                :value="filtros.sort"
                @change="atualizar('sort', $event.target.value)"
                class="select select-bordered select-sm w-full min-w-32 bg-base-100 hover:bg-base-200/50 transition-colors"
            >
                <option value="">Mais Recentes</option>
                <option value="antigos">Mais Antigos</option>
                <option value="melhores">Melhor Avaliado</option>
                <option value="visualizados">Mais Visto</option>
            </select>
        </div>

        <button
            v-if="temFiltroAtivo"
            @click="limparFiltros"
            class="btn btn-outline btn-sm col-span-2 sm:col-span-4 mt-1 text-xs"
        >
            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
            Limpar filtros
        </button>
    </div>
</template>

<script setup>
import { computed } from 'vue'
import { router } from '@inertiajs/vue3'

const props = defineProps({
    categorias: { type: Array, required: true },
    cidades: { type: Array, required: true },
    ufs: { type: Array, default: () => [] },
    filtros: {
        type: Object,
        default: () => ({ search: '', categoria: '', cidade: '', sort: '' }),
    },
})

const temFiltroAtivo = computed(() => {
    return props.filtros.categoria || props.filtros.cidade || props.filtros.sort || props.filtros.uf
})

function atualizar(chave, valor) {
    router.get('/', { ...props.filtros, [chave]: valor || '' }, {
        preserveState: true,
        preserveScroll: true,
        replace: true,
    })
}

function limparFiltros() {
    router.get('/', { search: props.filtros.search || '' }, {
        preserveState: true,
        preserveScroll: true,
        replace: true,
    })
}
</script>
