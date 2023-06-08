<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { faUserTie, faBuilding, faCrosshairs } from '@fortawesome/free-solid-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="grid grid-cols-5 gap-3 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <FontAwesomeIcon :icon="faUserTie" class="h-6 w-6  text-gray-500 float-left mr-2" ></FontAwesomeIcon>
                        <a :href="route('employees.index')">Empleados</a></div>
                    <div class="p-6 text-gray-900 cursor-not-allowed">
                        <FontAwesomeIcon :icon="faBuilding" class="h-6 w-6  text-gray-500 float-left mr-2 " ></FontAwesomeIcon>
                        Empresas</div>
                    <div class="p-6 text-gray-900 cursor-not-allowed">
                        <FontAwesomeIcon :icon="faCrosshairs" class="h-6 w-6  text-gray-500 float-left mr-2 " ></FontAwesomeIcon>
                        Puestos</div>
                </div>

                <div class="p-6 text-gray-900">You're logged in!</div>
            </div>
        </div>


    </AuthenticatedLayout>
</template>
