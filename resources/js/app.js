import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/vue3'
import resolvePageComponent from './resolvePageComponent'

createInertiaApp({
    progress: {
        color: '#3B82F6',
        showSpinner: false,
    },
    resolve: (name) => resolvePageComponent(name),
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .mount(el)
    },
})
