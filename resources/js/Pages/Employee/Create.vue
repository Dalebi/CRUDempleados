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


const title = "Employee :: Create";
const modalContent = {
    textContent: 'Saving Information...',
    iconContent: { 'source': FontAwesomeIcon, icon: faCircleInfo },
};

const MsgComponent = ref();
const ModalComponent = ref();

const form = useForm({
        name: '',
        first_name: '',
        last_name: '',
        start_at: '',
        company_id: '',
        position_id: '',
    });



function stopSubmit() {
       ModalComponent.value.toggleModal();

        form.post(route('employees.store'), { onSuccess: () => {
                MsgComponent.value.toggleMsg(5000);
                ModalComponent.value.toggleModal();

                if(props.databaseResponse.search(/error/i)<0){
                    //Force Reset Form
                    Object.assign(form, {
                        name: '',
                        first_name: '',
                        last_name: '',
                        start_at: '',
                        company_id: '',
                        position_id: '',
                    });
                }
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

    <AuthenticatedLayout>

        <Header :title="title" >
            <template #icon> <FontAwesomeIcon :icon='faUserTie' class="align-middle h-7 w-7  text-gray-500 float-left mr-2 "></FontAwesomeIcon> </template>
        </Header>

        <Modal title='Saving...' :content="modalContent" ref="ModalComponent"></Modal>

        <div class="flex flex-row mt-2  justify-center">
            <div class="basis-1/2 pt-6 sm:pt-4 ">

            <DatabaseResponse :msg=databaseResponse
            ref="MsgComponent"></DatabaseResponse>

            <form @submit.prevent="stopSubmit" method="POST" enctype="multipart/form-data" >

                <div class="border  border-neutral-400  divide-y divide-slate-200 basis-1/2  p-5  text-lg rounded-md
">
                Name <input type="text"  v-model="form.name"
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                >
                <div v-if="errors.name" class="text-red-800">{{ errors.name }}</div>

                First Name <input type="text" v-model="form.first_name"
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                >
                <div v-if="errors.name" class="text-red-800">{{ errors.first_name }}</div>

                Last Name <input type="text" v-model="form.last_name"
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                >
                <div v-if="errors.last_name" class="text-red-800">{{ errors.last_name }}</div>

                Start Date  <input type="date" v-model="form.start_at"
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                >
                <div v-if="errors.start_at" class="text-red-800">{{ errors.start_at }}</div>

                Company
                <select v-model="form.company_id" class="mt-1 shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                >
                <option selected disabled>Choose</option>
                <option v-for="option in companies" :value="option.id">
                    {{ option.name }}
                </option>
                </select>
                <div v-if="errors.company_id" class="text-red-800">{{ errors.company_id }}</div>

                Position
                <select v-model="form.position_id" class="mt-1 shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                >
                <option selected disabled>Choose</option>
                <option v-for="option in positions" :value="option.id">
                    {{ option.name }}
                </option>
                </select>
                <div v-if="errors.position_id" class="text-red-800">{{ errors.position_id }}</div>

                <div class="">
                    <span class="">
                        <PrimaryButton class="mt-4 mb-1 w-full " ><div class="text-center w-full font-bold text-lg">Save</div></PrimaryButton></span>
                </div>
                </div>
            </form>

        </div>
        </div>
    </AuthenticatedLayout>
</template>
