<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';

// Datos de ejemplo - en una aplicación real vendrían del backend
const stats = ref([
    { name: 'Notas totales', value: '24', change: '+12%', changeType: 'positive' },
    { name: 'Carpetas', value: '8', change: '+3', changeType: 'positive' },
    { name: 'Etiquetas', value: '15', change: '+5', changeType: 'positive' },
    { name: 'Notas esta semana', value: '7', change: '+2', changeType: 'positive' },
]);

const recentNotes = ref([
    { id: 1, title: 'Ideas para el proyecto web', content: 'Diseño responsive, autenticación, base de datos...', folder: 'Proyectos', date: 'Hace 2 horas', color: 'blue' },
    { id: 2, title: 'Lista de compras', content: 'Leche, pan, frutas, verduras...', folder: 'Personal', date: 'Ayer', color: 'green' },
    { id: 3, title: 'Notas de la reunión', content: 'Puntos importantes discutidos en la reunión...', folder: 'Trabajo', date: 'Hace 3 días', color: 'purple' },
    { id: 4, title: 'Receta de pasta', content: 'Ingredientes y pasos para hacer pasta...', folder: 'Cocina', date: 'Hace 1 semana', color: 'orange' },
]);

const quickActions = ref([
    { name: 'Nueva nota', description: 'Crear una nota rápida', icon: 'document-plus', href: '#', color: 'blue' },
    { name: 'Nueva carpeta', description: 'Organizar mejor tus notas', icon: 'folder-plus', href: '#', color: 'green' },
    { name: 'Buscar', description: 'Encontrar notas rápidamente', icon: 'magnifying-glass', href: '#', color: 'purple' },
    { name: 'Importar', description: 'Traer notas de otros lugares', icon: 'arrow-down-tray', href: '#', color: 'orange' },
]);

const getColorClasses = (color) => {
    const colors = {
        blue: 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300',
        green: 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300',
        purple: 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-300',
        orange: 'bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-300',
    };
    return colors[color] || colors.blue;
};

const getIconClasses = (color) => {
    const colors = {
        blue: 'text-blue-600 dark:text-blue-400',
        green: 'text-green-600 dark:text-green-400',
        purple: 'text-purple-600 dark:text-purple-400',
        orange: 'text-orange-600 dark:text-orange-400',
    };
    return colors[color] || colors.blue;
};
</script>

<template>
    <Head title="Dashboard - MindNotes" />

    <AuthenticatedLayout>
        <!-- <template #header>
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold leading-tight text-gray-900 dark:text-white">
                        Dashboard
                    </h2>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                        Bienvenido de vuelta. Aquí tienes un resumen de tus notas.
                    </p>
                </div>
                <button class="rounded-lg bg-gradient-to-r from-blue-600 to-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-lg transition-all hover:shadow-xl hover:shadow-blue-500/25">
                    Nueva nota
                </button>
            </div>
        </template> -->

        <div class="py-6">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 ">
                <!-- Estadísticas -->
                <div class="mb-8">
                    <h3 class="text-lg font-medium text-gray-900  mb-4">Resumen</h3>
                    <dl class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
                        <div
                            v-for="stat in stats"
                            :key="stat.name"
                            class="relative overflow-hidden rounded-lg bg-white px-4 py-5 shadow dark:bg-gray-800 sm:px-6"
                        >
                            <dt>
                                <div class="absolute rounded-md bg-blue-500 p-3">
                                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                </div>
                                <p class="ml-16 truncate text-sm font-medium text-gray-500 dark:text-gray-400">
                                    {{ stat.name }}
                                </p>
                            </dt>
                            <dd class="ml-16 flex items-baseline">
                                <p class="text-2xl font-semibold text-gray-900 dark:text-white">
                                    {{ stat.value }}
                                </p>
                                <p
                                    :class="[
                                        stat.changeType === 'positive' ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400',
                                        'ml-2 flex items-baseline text-sm font-semibold'
                                    ]"
                                >
                                    {{ stat.change }}
                                </p>
                            </dd>
                        </div>
                    </dl>
                </div>

                <!-- Acciones rápidas -->
                <div class="mb-8">
                    <h3 class="text-lg font-medium text-gray-900  mb-4">Acciones rápidas</h3>
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
                        <div
                            v-for="action in quickActions"
                            :key="action.name"
                            class="group relative rounded-lg bg-white p-6 shadow-sm transition-all hover:shadow-md dark:bg-gray-800 cursor-pointer"
                        >
                            <div class="flex items-center">
                                <div :class="`flex h-10 w-10 items-center justify-center rounded-lg ${getColorClasses(action.color)}`">
                                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path v-if="action.icon === 'document-plus'" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        <path v-else-if="action.icon === 'folder-plus'" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-5l-2-2H5a2 2 0 00-2 2z" />
                                        <path v-else-if="action.icon === 'magnifying-glass'" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                        <path v-else-if="action.icon === 'arrow-down-tray'" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <h4 class="text-sm font-medium text-gray-900 dark:text-white">
                                        {{ action.name }}
                                    </h4>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">
                                        {{ action.description }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Notas recientes -->
                <div class="mb-8">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-medium text-gray-900">Notas recientes</h3>
                        <a href="#" class="text-sm font-medium text-blue-600 hover:text-blue-500 dark:text-blue-400">
                            Ver todas →
                        </a>
                    </div>
                    <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                        <ul class="divide-y divide-gray-200 dark:divide-gray-700">
                            <li
                                v-for="note in recentNotes"
                                :key="note.id"
                                class="p-6 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors cursor-pointer"
                            >
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <div :class="`flex h-8 w-8 items-center justify-center rounded-lg ${getColorClasses(note.color)}`">
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                        </div>
                                        <div class="ml-4">
                                            <h4 class="text-sm font-medium text-gray-900 dark:text-white">
                                                {{ note.title }}
                                            </h4>
                                            <p class="text-sm text-gray-500 dark:text-gray-400 line-clamp-2">
                                                {{ note.content }}
                                            </p>
                                            <div class="mt-2 flex items-center space-x-4">
                                                <span class="inline-flex items-center rounded-full bg-gray-100 px-2.5 py-0.5 text-xs font-medium text-gray-800 dark:bg-gray-700 dark:text-gray-200">
                                                    {{ note.folder }}
                                                </span>
                                                <span class="text-xs text-gray-500 dark:text-gray-400">
                                                    {{ note.date }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <button class="rounded p-1 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </button>
                                        <button class="rounded p-1 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Actividad reciente -->
                <div>
                    <h3 class="text-lg font-medium text-gray-900  mb-4">Actividad reciente</h3>
                    <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                        <div class="p-6">
                            <div class="flow-root">
                                <ul class="-mb-8">
                                    <li>
                                        <div class="relative pb-8">
                                            <span class="absolute left-4 top-4 -ml-px h-full w-0.5 bg-gray-200 dark:bg-gray-700" aria-hidden="true"></span>
                                            <div class="relative flex space-x-3">
                                                <div>
                                                    <span class="h-8 w-8 rounded-full bg-blue-500 flex items-center justify-center ring-8 ring-white dark:ring-gray-800">
                                                        <svg class="h-4 w-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                                        </svg>
                                                    </span>
                                                </div>
                                                <div class="flex min-w-0 flex-1 justify-between space-x-4 pt-1.5">
                                                    <div>
                                                        <p class="text-sm text-gray-500 dark:text-gray-400">
                                                            Creaste una nueva nota
                                                            <span class="font-medium text-gray-900 dark:text-white">"Ideas para el proyecto web"</span>
                                                        </p>
                                                    </div>
                                                    <div class="whitespace-nowrap text-right text-sm text-gray-500 dark:text-gray-400">
                                                        <time>Hace 2 horas</time>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="relative pb-8">
                                            <span class="absolute left-4 top-4 -ml-px h-full w-0.5 bg-gray-200 dark:bg-gray-700" aria-hidden="true"></span>
                                            <div class="relative flex space-x-3">
                                                <div>
                                                    <span class="h-8 w-8 rounded-full bg-green-500 flex items-center justify-center ring-8 ring-white dark:ring-gray-800">
                                                        <svg class="h-4 w-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-5l-2-2H5a2 2 0 00-2 2z" />
                                                        </svg>
                                                    </span>
                                                </div>
                                                <div class="flex min-w-0 flex-1 justify-between space-x-4 pt-1.5">
                                                    <div>
                                                        <p class="text-sm text-gray-500 dark:text-gray-400">
                                                            Creaste una nueva carpeta
                                                            <span class="font-medium text-gray-900 dark:text-white">"Proyectos"</span>
                                                        </p>
                                                    </div>
                                                    <div class="whitespace-nowrap text-right text-sm text-gray-500 dark:text-gray-400">
                                                        <time>Ayer</time>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="relative">
                                            <div class="relative flex space-x-3">
                                                <div>
                                                    <span class="h-8 w-8 rounded-full bg-purple-500 flex items-center justify-center ring-8 ring-white dark:ring-gray-800">
                                                        <svg class="h-4 w-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10" />
                                                        </svg>
                                                    </span>
                                                </div>
                                                <div class="flex min-w-0 flex-1 justify-between space-x-4 pt-1.5">
                                                    <div>
                                                        <p class="text-sm text-gray-500 dark:text-gray-400">
                                                            Importaste
                                                            <span class="font-medium text-gray-900 dark:text-white">5 notas</span>
                                                            desde Evernote
                                                        </p>
                                                    </div>
                                                    <div class="whitespace-nowrap text-right text-sm text-gray-500 dark:text-gray-400">
                                                        <time>Hace 3 días</time>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
