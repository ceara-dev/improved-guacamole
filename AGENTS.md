# OlharViajante - UI/UX Development Guide

## Build Commands
- `npm run dev` - Start Vite dev server
- `npm run build` - Build production assets

## Tech Stack
- Laravel 10+ with Inertia.js
- Vue 3 + Composition API
- Tailwind CSS v4
- DaisyUI v5
- @inertiajs/vue3

## Key Files
- `resources/js/Pages/Home.vue` - Main page with filters, carousel, and post grid
- `resources/js/Pages/PontosTuristicos/Show.vue` - Detail page for each destination
- `resources/js/Pages/Layouts/MainLayout.vue` - Main layout with header
- `resources/js/Components/*.vue` - Reusable components

## UI Improvements Made
1. MainLayout: Added dark/light theme toggle, mobile search bar
2. Home.vue: Integrated StoriesBar, added StoryModal for story previews
3. Show.vue: Improved layout styling, better responsive design
4. Filters.vue: Grid layout for better organization, centered clear button
5. DestinosCarrossel: Added "Destinos em alta" header, rating badges
6. StoriesBar: Added star badges for highly-rated destinations
7. PostCard: Enhanced image overlay on hover, improved rating display
8. InstagramPost/InstagramGrid: Better styling and animations
9. Pagination: Added page info display
10. CommentsModal/StoryModal: Improved styling and usability