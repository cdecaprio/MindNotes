<script setup>
import Checkbox from '@/Components/Checkbox.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    
        <Head title="Iniciar Sesión" />

        <div class="min-h-screen flex items-center justify-center bg-gray-50 dark:bg-gray-900 py-12 px-4 sm:px-6 lg:px-8">
            <div class="max-w-md w-full space-y-8">
                <!-- Header -->
                <div class="text-center">
                    <div class="mx-auto h-16 w-16 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-xl flex items-center justify-center mb-6">
                        <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">Bienvenido a MindNotes</h2>
                    <p class="text-gray-600 dark:text-gray-400">Inicia sesión en tu cuenta</p>
                </div>

                <!-- Status Message -->
                <div v-if="status" class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6 dark:bg-green-900/20 dark:border-green-800">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-green-800 dark:text-green-200">{{ status }}</p>
                        </div>
                    </div>
                </div>

                <!-- Login Form -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 p-8">
                    <form @submit.prevent="submit" class="space-y-6">
                        <!-- Email Field -->
                        <div>
                            <InputLabel for="email" value="Correo electrónico" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2" />
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                                    </svg>
                                </div>
                                <TextInput
                                    id="email"
                                    type="email"
                                    class="pl-10 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:focus:ring-blue-400 dark:focus:border-blue-400 transition duration-150 ease-in-out"
                                    v-model="form.email"
                                    required
                                    autofocus
                                    autocomplete="username"
                                    placeholder="tu@email.com"
                                />
                            </div>
                            <InputError class="mt-2" :message="form.errors.email" />
                        </div>

                        <!-- Password Field -->
                        <div>
                            <InputLabel for="password" value="Contraseña" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2" />
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                    </svg>
                                </div>
                                <TextInput
                                    id="password"
                                    type="password"
                                    class="pl-10 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:focus:ring-blue-400 dark:focus:border-blue-400 transition duration-150 ease-in-out"
                                    v-model="form.password"
                                    required
                                    autocomplete="current-password"
                                    placeholder="••••••••"
                                />
                            </div>
                            <InputError class="mt-2" :message="form.errors.password" />
                        </div>

                        <!-- Remember Me & Forgot Password -->
                        <div class="flex items-center justify-between">
                            <label class="flex items-center">
                                <Checkbox name="remember" v-model:checked="form.remember" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded" />
                                <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">Recordarme</span>
                            </label>

                            <Link
                                v-if="canResetPassword"
                                :href="route('password.request')"
                                class="text-sm font-medium text-blue-600 hover:text-blue-500 dark:text-blue-400 dark:hover:text-blue-300 transition duration-150 ease-in-out"
                            >
                                ¿Olvidaste tu contraseña?
                            </Link>
                        </div>

                        <!-- Submit Button -->
                        <div>
                            <PrimaryButton
                                class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:focus:ring-offset-gray-800 transition duration-150 ease-in-out transform hover:scale-105 hover:shadow-lg hover:shadow-blue-500/25"
                                :class="{ 'opacity-50 cursor-not-allowed': form.processing }"
                                :disabled="form.processing"
                            >
                                <svg v-if="form.processing" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                {{ form.processing ? 'Iniciando sesión...' : 'Iniciar Sesión' }}
                            </PrimaryButton>
                        </div>

                        <!-- Divider -->
                        <div class="relative">
                            <div class="absolute inset-0 flex items-center">
                                <div class="w-full border-t border-gray-300 dark:border-gray-600"></div>
                            </div>
                            <div class="relative flex justify-center text-sm">
                                <span class="px-2 bg-white dark:bg-gray-800 text-gray-500 dark:text-gray-400">¿No tienes una cuenta?</span>
                            </div>
                        </div>

                        <!-- Register Link -->
                        <div class="text-center">
                            <Link
                                :href="route('register')"
                                class="font-medium text-blue-600 hover:text-blue-500 dark:text-blue-400 dark:hover:text-blue-300 transition duration-150 ease-in-out"
                            >
                                Crear una cuenta nueva
                            </Link>
                        </div>
                    </form>
                </div>

                <!-- Footer -->
                <div class="text-center text-sm text-gray-500 dark:text-gray-400">
                    <p>Al continuar, aceptas nuestros términos de servicio y política de privacidad</p>
                </div>
            </div>
        </div>
    
</template>
