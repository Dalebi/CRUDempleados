<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

import Header from '../Partials/Header.vue';
import DatabaseResponse from '../Partials/DatabaseResponse.vue';
import { faUser, faFile, faCircleInfo } from '@fortawesome/free-solid-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

import DataTable from 'datatables.net-vue3';
import DataTablesLib from 'datatables.net-bs5';
import { ref } from 'vue'
import { onMounted } from 'vue';


DataTable.use(DataTablesLib);

const props = defineProps({ errors: Object, User: Object, EmployeeList: JSON, databaseResponse: String })


const title = "Empleados :: Inicio";
const route_new = "create";
const MsgComponent = ref();//For Database Response
const msg_response = ref(props.databaseResponse);// this const will be used for replacing the state of databaseResponse wich one cannt be modified from here

console.log('msg_response',msg_response);
const columns =  [
            { data: 'employee_id' },
            { data: 'name' },
            { data: 'first_name' },
            { data: 'last_name' },
            { data: 'position' },
            { data: 'start_at' },
            { data: 'company' },
        ];

const ajax = {
            url: route('employees.all'),
            type: "GET",
            datatype: "Html",
};

const updateDatabaseResponse = function (){
    msg_response.value = '';
}

onMounted(() => {
    MsgComponent.value.toggleMsg(5000);
})
</script>

<template>
    <Head title="Usuario" />

    <AuthenticatedLayout >

         <Header :title="title" :routeNew="route_new"  >
            <template #icon><FontAwesomeIcon :icon='faUser' class="align-middle h-7 w-7  text-gray-500 float-left mr-2 "></FontAwesomeIcon> </template>
        </Header>

        <div class="flex flex-row mt-4  justify-center" :class="msg_response!=''?'block':'hidden'" >
            <div class="basis-1/2 pt-4 sm:pt-6 lg:pt-8">
        <DatabaseResponse :msg=databaseResponse @update-msg="updateDatabaseResponse"
            ref="MsgComponent"></DatabaseResponse>
        </div>
        </div>

        <div v-if="EmployeeList.total>0">
            <div class="flex flex-row mt-2  justify-center">

                <DataTable ref="table" class="display table table-striped justify-right" width="100%"  :ajax="ajax"  :columns="columns">
                <thead >
                    <tr>
                        <th>Id</th>
                        <th>Nombre</th>
                        <th>Apellido Paterno</th>
                        <th>Apellido Materno</th>
                        <th>Puesto</th>
                        <th>Fecha de Ingreso</th>
                        <th>Empresa</th>
                    </tr>
                </thead>
            </DataTable>
            </div>
        </div>
        <div v-else class="flex flex-row mt-2  justify-center">
                <div class="basis-1/2 pt-4 sm:pt-6 lg:pt-8 ">
                    <FontAwesomeIcon :icon='faCircleInfo' class="align-middle h-6 w-6  text-gray-500 float-left mr-2 "></FontAwesomeIcon>   Aun no se han realizado registros
            </div>
        </div>

    </AuthenticatedLayout>
</template>
<style>
@import 'bootstrap';
@import 'datatables.net-bs5';
/*@import 'datatables.net-dt';*/

</style>
