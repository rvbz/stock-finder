<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/inertia-vue3';
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>

        <div class="bg-gray-50">
            <div class="text-center text-4xl py-16 px-8">
                <p class="mt-2 font-bold leading-8 tracking-tight text-gray-900 block">Ready to find your next stock?</p>
                <p class="mt-4 lg:mx-auto text-indigo-600 block text-3xl">Search for a stock symbol.</p>

                <div class="mt-8 text-center">
                    <div class="flex-shrink-0">
                        <div class="inline-flex">
                            <input type="text" name="stock-searcher" class="bg-grey-lighter text-grey-darker py-2 font-normal rounded-full text-grey-darkest border border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                        <div class="ml-3 inline-flex">
                            <a href="#" class="inline-flex items-center justify-center rounded-full border border-transparent bg-indigo-600 px-5 py-2 text-base font-medium text-white hover:bg-indigo-700">Get price</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        You're logged in!
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
