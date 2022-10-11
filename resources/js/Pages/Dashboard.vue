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
                            <!-- <input type="text" name="stock-searcher" class="bg-grey-lighter text-grey-darker py-2 font-normal rounded-full text-grey-darkest border border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"> -->
                            <v-select class="tailwind-style" :filterable="false" :options="options" @search="onSearch" v-model="selected">
                                <template v-slot:no-options="{ search, searching }">
                                    <template v-if="searching" class="text-grey-darker text-base">
                                        <p class="text-base">No results found for <em>{{ search }}</em></p>
                                    </template>
                                    <template v-else class="text-grey-darker text-base">
                                        <p class="text-base">Start typing to search a stock.</p>
                                    </template>
                                </template>
                                <template v-slot:option="option">
                                    <div class="text-grey-darker text-base">
                                        {{ option['1. symbol'] }} | {{ option['2. name'] }}
                                    </div>
                                </template>
                                <template v-slot:selected-option="option">
                                    <div class="selected text-grey-darker text-base">
                                        {{ option['1. symbol'] }} | {{ option['2. name'] }}
                                    </div>
                                </template>
                            </v-select>
                        </div>
                        <div class="ml-3 inline-flex">
                            <a href="#" @click.prevent="searchSymbol" class="inline-flex items-center justify-center rounded-full border border-transparent bg-indigo-600 px-5 py-2 text-base font-medium text-white hover:bg-indigo-700">Get price</a>
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

<script>
    import vSelect from "vue-select";
    import "vue-select/dist/vue-select.css";

    export default {
        components : {vSelect},

        data() {
            return {
                options: [],
                selected: null
            }
        },
        methods: {
            onSearch(search, loading) {
                if(search.length) {
                    loading(true);
                    this.search(loading, search, this);
                }
            },
            search: _.debounce((loading, search, vm) => {
                axios.get(
                    `/api/stock-symbol/search/${escape(search)}`
                ).then(res => {
                    vm.options = res.data.bestMatches;
                    loading(false);
                });
            }, 350),
            searchSymbol() {
                if (!this.selected) {
                    // Handle not selected
                }

                console.log(this.selected);
                axios.put(
                    `/api/stock-symbol/${escape(this.selected['1. symbol'])}`
                ).then((response) => {
                    console.log(response);
                }).catch((error) => {
                    console.log('An error ocurred');
                });
            }
        }
    }
</script>

<style>
    .v-select{
        min-width: 250px;
    }

    .tailwind-style .vs__dropdown-toggle {
        border-radius: 9999px;
    }
    .tailwind-style .vs__search {
        padding: 6px 0px 6px 5px;
        margin: 0px;
    }
    .tailwind-style .vs__actions {
        padding: 4px 15px 0px 3px;
    }
</style>
