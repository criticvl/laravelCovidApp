
<template>
    <Head title="Covid LIVE" />
    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>

        <div class="py-12 select-none">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white shadow sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200 flex">
                        <div class="w-3/5 shadow rounded">

                            <h1 class="mb-4 shadow font-semibold">World Map</h1>
                            <div id="world-map" class="h-72 rounded">
                            </div>

                        </div>
                        <div class="w-2/5 shadow rounded">
                        <h1 class="px-3 mx-3 pt-6 shadow bg-gray-300 rounded-t-lg font-semibold">World</h1>
                        <div class="shadow rounded-b-lg flex text-xs p-3 bg-gray-300 pb-6 mx-3">
                            <div>
                                <p class="w-1/3 text font-semibold">todayCases:</p>
                                <p class="w-1/3 text-sm">{{ tc }}</p>
                            </div>
                            <div class="px-6">
                                <p class="w-1/3 text font-semibold">todayDeaths:</p>
                                <p class="w-1/3 text-sm">{{ td }}</p>
                            </div>
                            <div>
                                <p class="w-1/3 text font-semibold">todayRecovered:</p>
                                <p class="w-1/3 text-sm">{{ tr }}</p>
                            </div>
                        </div>

                            <div class="">
                                <h1 class="px-3 mt-2">Countries: </h1>
                                <div class="flex my-1">
                                    <Select2 class="pl-3 w-full" v-model="selectedCountry"
                                    :settings="{
                                        width: '100%',
                                        settingOption: value,
                                        ajax: {
                                        url: '/api/countries/list',
                                        dataType: 'json',
                                    } }"
                                    @select="addCountry($event)" />
                                    <a class="px-5 right-0 rounded bg-sky-500 hover:bg-sky-400 shadow hover:shadow-lg ml-4 text-sm font-semibold pt-1" href="javascript:void(0)" @click="buttonAddCountry">Add</a>
                                </div>
                                <div class="w-full px-3">
                                    <div v-for="country in searchedCountries" :key="country.id" class="rounded bg-gray-300">

                                        {{ getCovidCountryInfo(country.name) }}

                                        <div class="px-1 m-6 font-semibold border-b-2 relative pt-2">
                                            {{ country.name }}
                                            <span class="absolute right-0 scale-75">
                                                <a style="cursor: pointer;" @click="removeCountry(country.id)">
                                                    <img src="https://img.icons8.com/material-two-tone/24/000000/delete-forever.png"/>
                                                </a>
                                            </span>
                                        </div>
                                        <div class="w-full shadow rounded flex text-xs p-3">
                                            <div>
                                                <p class="w-1/3 text font-semibold">todayCases:</p>
                                                <p class="w-1/3 text-sm">{{ tcc }}</p>
                                            </div>
                                            <div class="px-6">
                                                <p class="w-1/3 text font-semibold">todayDeaths:</p>
                                                <p class="w-1/3 text-sm">{{ tdc }}</p>
                                            </div>
                                            <div>
                                                <p class="w-1/3 text font-semibold">todayRecovered:</p>
                                                <p class="w-1/3 text-sm">{{ trc }}</p>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>

<script>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue'
import { Head } from '@inertiajs/inertia-vue3';
import Select2 from 'vue3-select2-component';
import axios from 'axios';

export default {
    components: {
        BreezeAuthenticatedLayout,
        Head,
        Select2,
    },
    data() {
        return {
            selectedCountry: '',
            searchedCountries: [],
            map: '',
        }
    },
    methods: {
        getSearchedCountries(){
            axios.get('/api/countries/searched').then((request) => {
                this.searchedCountries = request.data
            })
        },
        buttonAddCountry(){
            if(this.selectedCountry !== ''){
                axios.post('/api/add-country', {
                    id: this.selectedCountry
                }).then(()=>this.getSearchedCountries());
            }else{
                console.log('country-error')
            }
        },
        removeCountry(id){
            axios.delete('/api/delete-country/'+id).then(()=>{
            }).then(()=>this.getSearchedCountries());
        },
        selectCountryonMap(){
            //TODO
            this.map.updateChoropleth();
        },
        loadMap(){
            setTimeout(()=>{
                this.map = new Datamap({
                element: document.getElementById("world-map"),
                projection: 'mercator',
                fills: {
                    defaultFill: "#55A3D6",
                    colored: "#D65555"
                },
                data: {

                }
                });
                this.selectCountryonMap();
            }, 2000);
        },
        getCovidWWInfo(){
            axios.get('https://disease.sh/v3/covid-19/all').then((request) => {
                this.covidWW = request.data
                this.tc = this.covidWW.todayCases
                this.td = this.covidWW.todayDeaths
                this.tr = this.covidWW.todayRecovered
            })
        },

        getCovidCountryInfo(Country){
            axios.get('https://disease.sh/v3/covid-19/countries/'+Country).then((request) => {
                this.covidWW = request.data
                this.tcc = this.covidWW.todayCases
                this.tdc = this.covidWW.todayDeaths
                this.trc = this.covidWW.todayRecovered
            })
        }

    },
    created(){
        this.getSearchedCountries();
        this.loadMap();
        this.getCovidWWInfo();
    }
}
</script>
