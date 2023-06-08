<script setup type="ts">
import 'bootstrap/dist/css/bootstrap.css';
import {ref} from 'vue';
import 'bootstrap/dist/js/bootstrap.js'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';


const props = defineProps({
    title:{
        type:String,
        default: 'Modal Title'
    },
    content:{
        type:Object,
        default: { textContent: 'Waiting Content..'}
    }
});

//console.log(props.title);
const modal = ref(null);

const active = ref(false);

function modalToggle() {
    const body = document.querySelector("body");
    console.log('Active', active.value, body);
    active.value = !active.value;
    active.value ? body.classList.add("modal-open") : body.classList.remove("modal-open");
}


const toggleModal = function toggleMsg() { //{ interval = 5000 }: {interval?: number }

    const body = document.querySelector("body");
    console.log('Active', active.value, body);
    active.value = !active.value;
    active.value ? body.classList.add("modal-open") : body.classList.remove("modal-open");

}

defineExpose({
    toggleModal
});

</script>
<template>
  <!-- Modal -->
<div>
    <div  ref="modal" class="modal fade" :class="{ show: active, 'd-block': active }" tabindex="-1" role="dialog">

        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ title }}</h5>
                    <button
                        type="button" class="close"
                        data-dismiss="modal" aria-label="Close"
                        @click="modalToggle">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body grid  place-items-center">
                    <div v-if="content.iconContent" class=" ">
                        <FontAwesomeIcon  :icon='content.iconContent.icon' class="align-middle h-20 w-20  text-gray-500 "></FontAwesomeIcon>
                    </div>
                    <p class="mt-4">{{ content.textContent }}</p>
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>
    <div v-if="active" class="modal-backdrop fade show"></div>
</div>

</template>

