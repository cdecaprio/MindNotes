<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';
import { router } from '@inertiajs/vue3';

const props = defineProps({
    notes: Array,
});

console.log('notes',props.notes);

const showModal = ref(false);
const isGettingLocation = ref(false);

const newNote = ref({
    title: '',
    content: '',
    
    
    latitude: 0,
    longitude: 0,
});

// Función para obtener la ubicación del usuario
const getUserLocation = () => {
    isGettingLocation.value = true;
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
            (position) => {
                newNote.value.latitude = position.coords.latitude;
                newNote.value.longitude = position.coords.longitude;
                isGettingLocation.value = false;
                console.log('Ubicación obtenida:', position.coords);
            },
            (error) => {
                console.error('Error al obtener ubicación:', error);
                // Valores por defecto si no se puede obtener la ubicación
                newNote.value.latitude = 0;
                newNote.value.longitude = 0;
                isGettingLocation.value = false;
            },
            {
                enableHighAccuracy: true,
                timeout: 10000,
                maximumAge: 300000 // 5 minutos
            }
        );
    } else {
        console.log('Geolocalización no soportada por este navegador');
        isGettingLocation.value = false;
    }
};

// Función para abrir el modal y obtener ubicación
const openModal = () => {
    showModal.value = true;
    getUserLocation();
};

const createNote = () => {
    if (newNote.value.title && newNote.value.content) {
        router.post('/notes', {
            title: newNote.value.title,
            content: newNote.value.content,
            latitude: newNote.value.latitude,
            longitude: newNote.value.longitude,
        }, {
            onSuccess: () => {
                // Cerrar modal y limpiar formulario
                showModal.value = false;
                newNote.value = { title: '', content: '', latitude: 0, longitude: 0 };
            },
        });
    } else {
        alert('Por favor, completa los campos requeridos');
    }
};

// Datos de ejemplo - en una aplicación real vendrían del backend
const stats = ref([
    { name: 'Notas totales', value: '24', change: '+12%', changeType: 'positive' },
    { name: 'Carpetas', value: '8', change: '+3', changeType: 'positive' },
    { name: 'Etiquetas', value: '15', change: '+5', changeType: 'positive' },
    { name: 'Notas esta semana', value: '7', change: '+2', changeType: 'positive' },
]);

const recentNotes = ref(props.notes || []);

const quickActions = ref([
    { name: 'Nueva nota', description: 'Crear una nota rápida', icon: 'document-plus', href: '#', color: 'blue' },

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
                        <div v-for="stat in stats" :key="stat.name"
                            class="relative overflow-hidden rounded-lg bg-white px-4 py-5 shadow dark:bg-gray-800 sm:px-6">
                            <dt>
                                <div class="absolute rounded-md bg-blue-500 p-3">
                                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
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
                                <p :class="[
                                    stat.changeType === 'positive' ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400',
                                    'ml-2 flex items-baseline text-sm font-semibold'
                                ]">
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
                        <div v-for="action in quickActions" :key="action.name" class="flex items-center p-4 bg-white rounded-lg shadow dark:bg-gray-800 hover:shadow-md transition-shadow cursor-pointer" @click="openModal">
                            <div :class="`flex h-10 w-10 items-center justify-center rounded-lg ${getColorClasses(action.color)}`">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path v-if="action.icon === 'document-plus'" stroke-linecap="round"
                                        stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
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
                <div v-if="recentNotes.length === 0" class="p-8 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">No hay notas</h3>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Comienza creando tu primera nota.</p>
                    <div class="mt-6">
                        <button @click="openModal" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            Nueva nota
                        </button>
                    </div>
                </div>
                <ul v-else class="divide-y divide-gray-200 dark:divide-gray-700">
                    <li v-for="note in recentNotes" :key="note.id"
                        class="p-6 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors cursor-pointer">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div
                                    :class="`flex h-8 w-8 items-center justify-center rounded-lg ${getColorClasses(note.color || 'blue')}`">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
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
                                        <span
                                            class="inline-flex items-center rounded-full bg-gray-100 px-2.5 py-0.5 text-xs font-medium text-gray-800 dark:bg-gray-700 dark:text-gray-200">
                                            {{ note.folder || 'Sin carpeta' }}
                                        </span>
                                        <span class="text-xs text-gray-500 dark:text-gray-400">
                                            {{ note.created_at ? new Date(note.created_at).toLocaleDateString('es-ES') : 'Reciente' }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-center space-x-2">
                                <button class="rounded p-1 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </button>
                                <button class="rounded p-1 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Actividad reciente -->
        
       
    </AuthenticatedLayout>

    <!-- Modal para crear nueva nota -->
    <div v-if="showModal" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <!-- Fondo oscuro -->
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click="showModal = false"></div>

            <!-- Centrar modal -->
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <!-- Contenido del modal -->
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full dark:bg-gray-800">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4 dark:bg-gray-800">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-blue-100 sm:mx-0 sm:h-10 sm:w-10 dark:bg-blue-900">
                            <svg class="h-6 w-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white" id="modal-title">
                                Nueva Nota
                            </h3>
                            
                            <!-- Indicador de ubicación -->
                            <div v-if="isGettingLocation" class="mt-2 flex items-center text-sm text-blue-600 dark:text-blue-400">
                                <svg class="animate-spin -ml-1 mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Obteniendo ubicación...
                            </div>
                            <div v-else-if="newNote.latitude !== 0 && newNote.longitude !== 0" class="mt-2 flex items-center text-sm text-green-600 dark:text-green-400">
                                <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                Ubicación obtenida ✓
                            </div>
                            
                            <div class="mt-4">
                                <form @submit.prevent="createNote" class="space-y-4">
                                    <!-- Título -->
                                    <div>
                                        <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                            Título *
                                        </label>
                                        <input
                                            type="text"
                                            id="title"
                                            v-model="newNote.title"
                                            required
                                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white sm:text-sm"
                                            placeholder="Título de la nota"
                                        />
                                    </div>

                                    <!-- Contenido -->
                                    <div>
                                        <label for="content" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                            Contenido *
                                        </label>
                                        <textarea
                                            id="content"
                                            v-model="newNote.content"
                                            required
                                            rows="4"
                                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white sm:text-sm"
                                            placeholder="Escribe el contenido de tu nota..."
                                        ></textarea>
                                    </div>

                                    <!-- Carpeta -->
                                    

                                   
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse dark:bg-gray-700">
                    <button
                        type="button"
                        @click="createNote"
                        class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm"
                    >
                        Crear Nota
                    </button>
                    <button
                        type="button"
                        @click="showModal = false"
                        class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm dark:bg-gray-600 dark:text-gray-200 dark:border-gray-500 dark:hover:bg-gray-500"
                    >
                        Cancelar
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>
