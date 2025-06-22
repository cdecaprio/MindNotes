<script setup>
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    laravelVersion: {
        type: String,
        required: true,
    },
    phpVersion: {
        type: String,
        required: true,
    },
});

function handleImageError() {
    document.getElementById('screenshot-container')?.classList.add('!hidden');
    document.getElementById('docs-card')?.classList.add('!row-span-1');
    document.getElementById('docs-card-content')?.classList.add('!flex-row');
    document.getElementById('background')?.classList.add('!hidden');
}
</script>

<template>
    <Head title="MindNotes - Organiza tus ideas" />
    
    <div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-100 dark:from-slate-900 dark:via-slate-800 dark:to-slate-900">
        <!-- Header -->
        <header class="relative z-10">
            <nav class="mx-auto flex max-w-7xl items-center justify-between p-6 lg:px-8">
                <div class="flex items-center">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-r from-blue-600 to-indigo-600">
                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <span class="ml-3 text-xl font-bold text-gray-900 dark:text-white">MindNotes</span>
                </div>
                
                <div class="flex items-center space-x-4">
                    <Link
                        v-if="canLogin"
                        :href="route('login')"
                        class="rounded-lg px-4 py-2 text-sm font-medium text-gray-700 transition-colors hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-800"
                    >
                        Iniciar sesión
                    </Link>
                    <Link
                        v-if="canRegister"
                        :href="route('register')"
                        class="rounded-lg bg-gradient-to-r from-blue-600 to-indigo-600 px-4 py-2 text-sm font-medium text-white transition-all hover:shadow-lg hover:shadow-blue-500/25"
                    >
                        Registrarse
                    </Link>
                </div>
            </nav>
        </header>

        <!-- Hero Section -->
        <main class="relative mx-auto max-w-7xl px-6 py-24 sm:py-32 lg:px-8">
            <div class="mx-auto max-w-2xl text-center">
                <h1 class="text-4xl font-bold tracking-tight text-gray-900 sm:text-6xl dark:text-white">
                    Organiza tus ideas con
                    <span class="bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">
                        MindNotes
                    </span>
                </h1>
                <p class="mt-6 text-lg leading-8 text-gray-600 dark:text-gray-300">
                    Una aplicación elegante y simple para capturar, organizar y desarrollar tus pensamientos. 
                    Convierte tus ideas en realidad con herramientas intuitivas y un diseño moderno.
                </p>
                <div class="mt-10 flex items-center justify-center gap-x-6">
                    <Link
                        v-if="canRegister"
                        :href="route('register')"
                        class="rounded-lg bg-gradient-to-r from-blue-600 to-indigo-600 px-6 py-3 text-base font-semibold text-white shadow-lg transition-all hover:shadow-xl hover:shadow-blue-500/25"
                    >
                        Comenzar gratis
                    </Link>
                    <a href="#features" class="text-base font-semibold leading-6 text-gray-900 dark:text-white">
                        Conoce más <span aria-hidden="true">→</span>
                    </a>
                </div>
            </div>
        </main>

        <!-- Features Section -->
        <section id="features" class="py-24 sm:py-32">
            <div class="mx-auto max-w-7xl px-6 lg:px-8">
                <div class="mx-auto max-w-2xl text-center">
                    <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl dark:text-white">
                        Todo lo que necesitas para organizar tus ideas
                    </h2>
                    <p class="mt-6 text-lg leading-8 text-gray-600 dark:text-gray-300">
                        Características diseñadas para hacer que la organización de tus pensamientos sea simple y efectiva.
                    </p>
                </div>
                
                <div class="mx-auto mt-16 max-w-2xl sm:mt-20 lg:mt-24 lg:max-w-none">
                    <dl class="grid max-w-xl grid-cols-1 gap-x-8 gap-y-16 lg:max-w-none lg:grid-cols-3">
                        <div class="flex flex-col">
                            <dt class="flex items-center gap-x-3 text-base font-semibold leading-7 text-gray-900 dark:text-white">
                                <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-blue-600">
                                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </div>
                                Notas rápidas
                            </dt>
                            <dd class="mt-4 flex flex-auto flex-col text-base leading-7 text-gray-600 dark:text-gray-300">
                                <p class="flex-auto">
                                    Captura tus ideas al instante con nuestro editor intuitivo. 
                                    Organiza tus notas con etiquetas y categorías para encontrarlas fácilmente.
                                </p>
                            </dd>
                        </div>
                        
                        <div class="flex flex-col">
                            <dt class="flex items-center gap-x-3 text-base font-semibold leading-7 text-gray-900 dark:text-white">
                                <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-indigo-600">
                                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                    </svg>
                                </div>
                                Organización inteligente
                            </dt>
                            <dd class="mt-4 flex flex-auto flex-col text-base leading-7 text-gray-600 dark:text-gray-300">
                                <p class="flex-auto">
                                    Sistema de carpetas y etiquetas para mantener tus ideas organizadas. 
                                    Búsqueda avanzada para encontrar exactamente lo que necesitas.
                                </p>
                            </dd>
                        </div>
                        
                        <div class="flex flex-col">
                            <dt class="flex items-center gap-x-3 text-base font-semibold leading-7 text-gray-900 dark:text-white">
                                <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-purple-600">
                                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                    </svg>
                                </div>
                                Seguro y privado
                            </dt>
                            <dd class="mt-4 flex flex-auto flex-col text-base leading-7 text-gray-600 dark:text-gray-300">
                                <p class="flex-auto">
                                    Tus ideas están seguras con nosotros. 
                                    Acceso protegido con contraseña y sincronización en la nube para acceder desde cualquier lugar.
                                </p>
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="py-24 sm:py-32">
            <div class="mx-auto max-w-7xl px-6 lg:px-8">
                <div class="mx-auto max-w-2xl text-center">
                    <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl dark:text-white">
                        ¿Listo para organizar tus ideas?
                    </h2>
                    <p class="mx-auto mt-6 max-w-xl text-lg leading-8 text-gray-600 dark:text-gray-300">
                        Únete a miles de usuarios que ya están organizando sus pensamientos con MindNotes.
                    </p>
                    <div class="mt-10 flex items-center justify-center gap-x-6">
                        <Link
                            v-if="canRegister"
                            :href="route('register')"
                            class="rounded-lg bg-gradient-to-r from-blue-600 to-indigo-600 px-6 py-3 text-base font-semibold text-white shadow-lg transition-all hover:shadow-xl hover:shadow-blue-500/25"
                        >
                            Crear cuenta gratis
                        </Link>
                        <Link
                            v-if="canLogin"
                            :href="route('login')"
                            class="text-base font-semibold leading-6 text-gray-900 dark:text-white"
                        >
                            Ya tengo cuenta <span aria-hidden="true">→</span>
                        </Link>
                    </div>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="border-t border-gray-200 dark:border-gray-800">
            <div class="mx-auto max-w-7xl px-6 py-12 md:flex md:items-center md:justify-between lg:px-8">
                <div class="flex justify-center space-x-6 md:order-2">
                    <p class="text-center text-xs leading-5 text-gray-500 dark:text-gray-400">
                        &copy; 2024 MindNotes. Desarrollado con Laravel v{{ laravelVersion }} y Vue.js.
                    </p>
                </div>
                <div class="mt-8 md:order-1 md:mt-0">
                    <p class="text-center text-xs leading-5 text-gray-500 dark:text-gray-400">
                        Una aplicación para organizar tus ideas de manera simple y elegante.
                    </p>
                </div>
            </div>
        </footer>
    </div>
</template>
