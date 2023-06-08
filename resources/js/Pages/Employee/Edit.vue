<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { useForm, Head } from '@inertiajs/vue3';
import DatabaseResponse from '../Partials/DatabaseResponse.vue';
import Header from '../Partials/Header.vue';
import Modal from '../Partials/Modal.vue';
import { faUserTie, faCircleInfo } from '@fortawesome/free-solid-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import { ref } from 'vue'


const props = defineProps({     msg: String,
errors: Object, user: Number, model: Object, companies:JSON, positions:JSON, databaseResponse: String, server_error:String })


const title = "Empleado :: Editar";
const modalContent = {
    textContent: 'Guardando Informacion...',
    iconContent: { 'source': FontAwesomeIcon, icon: faCircleInfo },
};

const MsgComponent = ref();
const ModalComponent = ref();

const msg_response = ref(props.databaseResponse);// this const will be used for replacing the state of databaseResponse wich one cannt be modified from here

const form = useForm(
    props.model
);

const capitalizaFirstLetter = function (string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
}

const updateDatabaseResponse = function (){
    msg_response.value = '';
}

const formatDate = function (date) {
    const preFormat = new Date(props.model[date]*1000);
    //preFormat.setMonth(preFormat.getMonth() + 1);

    return preFormat.toISOString().substring(0,10);

}

form.start_at = formatDate('start_at');

function stopSubmit() {
    ModalComponent.value.toggleModal();

    form.put(route('employees.update', props.model.employee_id ), { onSuccess: () => {
        msg_response.value = props.databaseResponse;
        MsgComponent.value.toggleMsg(5000);
        ModalComponent.value.toggleModal();

    },
    onError: () => {
        ModalComponent.value.toggleModal();
        console.log('Error Response DB: ' + props.databaseResponse  + ':' + MsgComponent.value.toggleMsg);
    }
    });
}//function stopSubmit(..

</script>

<template>
    <Head :title="title" />

    <Modal title='Saving...' :content="modalContent" ref="ModalComponent"></Modal>


    <AuthenticatedLayout>

            <Header :title="title">
            <template #icon> <FontAwesomeIcon :icon='faUserTie' class="align-middle h-7 w-7  text-gray-500 float-left mr-2 "></FontAwesomeIcon> </template>
        </Header>


        <div class="flex flex-row mt-4  justify-center" :class="msg_response!=''?'block':'hidden'" >
            <div class="basis-1/2 pt-4 sm:pt-6 lg:pt-8">
        <DatabaseResponse :msg=databaseResponse @update-msg="updateDatabaseResponse"
            ref="MsgComponent"></DatabaseResponse>
        </div>
        </div>

        <div class="flex flex-row mt-2  justify-center">

             <div class="basis-1/2 pt-4 sm:pt-6 lg:pt-8">
                <form  @submit.prevent="stopSubmit" method="POST" enctype="multipart/form-data">
                    <div class="border  border-neutral-400  divide-y divide-slate-200 basis-1/2  p-5  text-lg rounded-md
">
                Nombre <input type="text"  v-model="form.name"
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                >
                <div v-if="errors.name" class="text-red-800">{{ errors.name }}</div>

                Apellido Paterno <input type="text" v-model="form.first_name"
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                >
                <div v-if="errors.name" class="text-red-800">{{ errors.first_name }}</div>

                Apellido Materno <input type="text" v-model="form.last_name"
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                >
                <div v-if="errors.last_name" class="text-red-800">{{ errors.last_name }}</div>

                Fecha de Ingreso  <input type="date" v-model="form.start_at"
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                >
                <div v-if="errors.start_at" class="text-red-800">{{ errors.start_at }}</div>

                Empresa
                <select v-model="form.company_id" class="mt-1 shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                >
                <option selected disabled>Seleccione</option>
                <option v-for="option in companies" :value="option.id">
                    {{ option.name }}
                </option>
                </select>
                <div v-if="errors.company_id" class="text-red-800">{{ errors.company_id }}</div>

                Puesto
                <select v-model="form.position_id" class="mt-1 shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                >
                <option selected disabled>Seleccione</option>
                <option v-for="option in positions" :value="option.id">
                    {{ option.name }}
                </option>
                </select>
                <div v-if="errors.position_id" class="text-red-800">{{ errors.position_id }}</div>

                <div class="">
                    <span class="">
                        <PrimaryButton class="mt-4 mb-1 w-full " ><div class="text-center w-full font-bold text-lg">Actualizar</div></PrimaryButton></span>
                </div>
                </div>

            </form>
            </div>
        </div>

<!--             </template>
    </SideBarMenu>
 -->
    </AuthenticatedLayout>
</template>
