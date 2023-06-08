<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import {  Head } from '@inertiajs/vue3';
import DatabaseResponse from '../Partials/DatabaseResponse.vue';
import Header from '../Partials/Header.vue';
import { faUserTie, faCircleInfo } from '@fortawesome/free-solid-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

const props = defineProps({ errors: Object,  model: Object})

console.log('Employee ID', props.model);

const title = "Employee :: Detail " + props.model.name;

const capitalizaFirstLetter = function (string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
}


const formatDate = function (date) {
    const preFormat = new Date(props.model[date]*1000);
    preFormat.setMonth(preFormat.getMonth() + 1); // Set the month to June

    return preFormat.toISOString().substring(0,10);

}


//console.log("date", formatDate('start_at'));


</script>

<template>
    <Head :title="title" />

    <AuthenticatedLayout>

        <Header :title="title">
            <template #icon> <FontAwesomeIcon :icon='faUserTie' class="align-middle h-7 w-7  text-gray-500 float-left mr-2 "></FontAwesomeIcon> </template>
        </Header>

        <div class="flex flex-row mt-2  justify-center">

             <div class="basis-1/2 pt-4 sm:pt-6 lg:pt-8">
                <div class="border  border-neutral-400  divide-y divide-slate-200 basis-1/2  p-5  text-lg rounded-md
">

                    <div  class=" p-2">
                        <span class="font-bold"> Nombre:</span>
                        <span class="ml-2"> {{ model.name }}</span>
                    </div>
                    <div class=" p-2">
                        <span class="font-bold"> Apellido Paterno:</span>
                        <span class="ml-2"> {{ model.first_name }}</span>
                    </div>
                    <div class=" p-2">
                        <span class="font-bold "> Apellido Materno:</span>
                        <span class="ml-2"> {{ model.last_name }}</span>
                    </div>
                    <div class=" p-2">
                        <span class="font-bold "> Puesto:</span>
                        <span class="ml-2"> {{ model.position }}</span>
                    </div>
                    <div class=" p-2">
                        <span class="font-bold "> Fecha de Ingreso:</span>
                        <span class="ml-2"> {{ formatDate('start_at') }}</span>
                    </div>
                    <div class=" p-2">
                        <span class="font-bold "> Empresa:</span>
                        <span class="ml-2"> {{ model.company }}</span>
                    </div>
                </div>

                <div class="">
                    <span class="">
                        <a :href="route('employees.edit', model.employee_id)">
                        <PrimaryButton class="mt-4 mb-1 w-full " @click.stop="" ><p class="text-center w-full font-bold text-lg">Edit</p></PrimaryButton> </a></span>
                </div>

            </div>
        </div>

    </AuthenticatedLayout>
</template>
