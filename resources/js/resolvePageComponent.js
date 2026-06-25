export default (name) => {
    const pages = import.meta.glob('./Pages/**/*.vue', { eager: true })
    const page = pages[`./Pages/${name}.vue`]
    if (!page) {
        throw new Error(`Page [${name}] not found.`)
    }
    return page
}
