<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';

import { useForm, Head } from '@inertiajs/vue3';
import DatabaseResponse from '../Partials/DatabaseResponse.vue';
import Header from '../Partials/Header.vue';
import Modal from '../Partials/Modal.vue';
import { faUserTie, faCircleInfo } from '@fortawesome/free-solid-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import { ref } from 'vue'


const props = defineProps({ errors: Object,  model: Object, databaseResponse: String})


const title = "Empleado :: Detalle " + props.model.name;
const modalContent = {
    textContent: 'Guardando Informacion...',
    iconContent: { 'source': FontAwesomeIcon, icon: faCircleInfo },
};

const MsgComponent = ref();
const ModalComponent = ref();

const msg_response = ref(props.databaseResponse);


const capitalizaFirstLetter = function (string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
}


const deleteRecord = function () {
    if(confirm('Esta a punto de eliminar este registro, desea Continuar?')){
        ModalComponent.value.toggleModal();

        const form = useForm(
            props.model
        );

        form.delete(route('employees.destroy', props.model.employee_id ), { onSuccess: () => {
            },
            onError: () => {
                ModalComponent.value.toggleModal();
                console.log('Error Response DB: ' + props.databaseResponse  + ':' + MsgComponent.value.toggleMsg);
            }
        });
    }
}//const deleteRecord = function (..


const formatDate = function (date) {
    const preFormat = new Date(props.model[date]*1000);
    preFormat.setMonth(preFormat.getMonth() + 1); // Set the month to June

    return preFormat.toISOString().substring(0,10);

}

const updateDatabaseResponse = function (){
    msg_response.value = '';
}


</script>

<template>
    <Head :title="title" />

    <Modal title='Saving...' :content="modalContent" ref="ModalComponent"></Modal>

    <AuthenticatedLayout>

        <Header :title="title">
            <template #icon> <FontAwesomeIcon :icon='faUserTie' class="align-middle h-7 w-7  text-gray-500 float-left mr-2 "></FontAwesomeIcon> </template>
        </Header>

        <div class="flex flex-row mt-4  justify-center" :class="msg_response!=null?'block':'hidden'" >
            <div class="basis-1/2 pt-4 sm:pt-6 lg:pt-8">!!{{ msg_response!='' }}!!
            <DatabaseResponse :msg=databaseResponse @update-msg="updateDatabaseResponse"
            ref="MsgComponent"></DatabaseResponse>
        </div>
        </div>

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
                        <PrimaryButton class="mt-4 mb-1 w-full " @click.stop="" ><div class="text-center w-full font-bold text-lg">Editar</div></PrimaryButton> </a></span>
                </div>
                <div class="">
                    <span class="">
                        <a href="#">
                        <SecondaryButton class="mt-4 mb-1 w-full " @click.stop="deleteRecord()" ><div class="text-center w-full font-bold text-lg">Eliminar</div></SecondaryButton> </a></span>
                </div>

            </div>
        </div>

    </AuthenticatedLayout>
</template>
