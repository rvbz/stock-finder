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
                            <v-select class="tailwind-style" :filterable="false" :options="options" @search="onSearch" @option:deselected="clearStats" v-model="selected">
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
            <div class="max-w-7xl mx-auto space-y-10 lg:grid lg:grid-cols-2 lg:gap-x-8 lg:gap-y-10 lg:space-y-0">
                <div class="relative" v-if="hasCurrentData">
                    <h3 class="mb-5 text-xl">Current stats:</h3>
                    <div class="space-y-10 lg:grid lg:grid-cols-2 lg:gap-x-8 lg:gap-y-5 lg:space-y-0">
                        <div v-if="currentData.price" class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6 bg-indigo-600 text-white border-b border-gray-200 text-center">
                                <p>Price</p>
                                <div class="mt-3 mb-2">
                                    <span class="text-lg">$</span>
                                    <span class="text-4xl">{{ currentData.price }}</span>
                                </div>
                            </div>
                        </div>

                        <div v-if="currentData.low" class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6 border-b border-gray-200 text-center text-cyan-400">
                                <p>Low</p>
                                <div class="mt-3 mb-2">
                                    <span class="text-lg">$</span>
                                    <span class="text-4xl">{{ currentData.low }}</span>
                                </div>
                            </div>
                        </div>

                        <div v-if="currentData.high" class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6 border-b border-gray-200 text-center text-red-400">
                                <p>High</p>
                                <div class="mt-3 mb-2">
                                    <span class="text-lg">$</span>
                                    <span class="text-4xl">{{ currentData.high }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="relative" v-if="statList">
                    <h3 class="mb-5 text-xl">Past stats:</h3>
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="bg-white border-b border-gray-200">
                            
                            <div class="overflow-x-auto relative">
                                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                        <tr>
                                            <th scope="col" class="py-4 px-6">
                                                Price
                                            </th>
                                            <th scope="col" class="py-4 px-6">
                                                Low
                                            </th>
                                            <th scope="col" class="py-4 px-6">
                                                High
                                            </th>
                                            <th scope="col" class="py-4 px-6">
                                                Date
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="stat in statList" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                            <th scope="row" class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                ${{ stat.price }}
                                            </th>
                                            <td class="py-4 px-6">
                                                ${{ stat.low }}
                                            </td>
                                            <td class="py-4 px-6">
                                                ${{ stat.high }}
                                            </td>
                                            <td class="py-4 px-6">
                                                {{ stat.created_at_human }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
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
                selected: null,
                statList: null,
                currentData: {},
                test: 'this is a test'
            }
        },
        watch: {
            selected(newSelected, oldSelected) {
                if (this.statList) {
                    this.clearStats();
                }
            }
        },
        computed: {
            hasCurrentData() {
                return Object.keys(this.currentData).length > 0;
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
                    return;
                }

                const vm = this;

                axios.put(
                    `/api/stock-symbol/${escape(this.selected['1. symbol'])}`
                ).then((response) => {
                    vm.statList = response.data.stats;
                    vm.currentData.price = response.data.current['05. price'];
                    vm.currentData.high = response.data.current['03. high'];
                    vm.currentData.low = response.data.current['04. low'];
                }).catch((error) => {
                    console.log('An error ocurred');
                });
            },
            clearStats() {
                this.statList = null;
                this.currentData = {};
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
