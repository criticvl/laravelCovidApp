<template>
    <Head title="Covid LIVE"/>

    <div class="relative flex items-top justify-center min-h-screen sm:items-center sm:pt-0">
        <div v-if="canLogin" class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
            <Link v-if="$page.props.auth.user" :href="route('dashboard')" class="text-sm text-gray-700 underline">
                Dashboard
            </Link>

            <template v-else>
                <Link :href="route('login')" class="text-sm text-gray-700 underline">
                    Log in
                </Link>

                <Link v-if="canRegister" :href="route('register')" class="ml-4 text-sm text-gray-700 underline">
                    Register
                </Link>
            </template>
        </div>

        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 mt-4 select-none">
            <div class="flex rounder shadow">
                <div class="w-1/2 p-6 m-10"> <img class="transition ease-in brightness-100 hover:brightness-105 hover:scale-110" src="/svg/healthcare.svg" alt="healthcare"> </div>
                <div class="w-1/2 p-6 m-10">
                    <h1 style="color: #55A3D6;" class="text-xl">Covid LIVE</h1>
                    <p class="text-neutral-600 mb-8 py-3">
                        Track Covid-19 in your area, and get the latest state and county data on cases, deaths, hospitalizations, tests and vaccinations.
                    </p>
                    <div class="contents">
                        <a href="/login" class="transition ease-in brightness-100 hover:brightness-110 text-neutral-800 rounded shadow hover:shadow-lg px-8 py-2 bg-slate-100 border" style="color:#55A3D6; border-color: #55A3D6;">Log In</a>
                        <span style="color: #55A3D6;">  -  or  -  </span>
                        <a href="/register" class="transition ease-in brightness-100 hover:brightness-110 text-neutral-800 rounded shadow hover:shadow-lg px-8 py-2 text-slate-50 border" style="background-color:#55A3D6; border-color: #55A3D6;">Register</a>
                    </div>

                </div>

            </div>

        </div>
    </div>
</template>


<script>
import { Head, Link } from '@inertiajs/inertia-vue3';

export default {
    components: {
      Head,
      Link,
    },
    props: {
        canLogin: Boolean,
        canRegister: Boolean,
        laravelVersion: String,
        phpVersion: String,
    },
}
</script>
