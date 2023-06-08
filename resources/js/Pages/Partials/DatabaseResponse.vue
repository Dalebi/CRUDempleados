<script setup lang="ts" >

import { ref, computed } from 'vue'

const props = defineProps(['msg'])


const msgActiveClass = ref("text-2xl font-bold rounded-md p-2 bg-green-200 mb-2 text-neutral-600 ");
const msgInactiveClass = ref("hidden");

const showMsg = ref(false)


const toggleMsg = function toggleMsg({ interval = 5000 }: {interval?: number }) {

    if(props.msg && props.msg.search(/error/i)>=0){
        console.log('Props', props.msg.search(/error/i), msgActiveClass.value);
        msgActiveClass.value = "text-2xl font-bold rounded-md p-2 bg-red-200 mb-2 text-neutral-600 ";
    }else{
        msgActiveClass.value = "text-2xl font-bold rounded-md p-2 bg-green-200 mb-2 text-neutral-600 ";
    }

    showMsg.value = !showMsg.value //Show the message only by 5 seconds by default or the time defined in the inteval var


    setTimeout(() => { //After interval seconds
        showMsg.value = !showMsg.value
        this.$emit('update-msg', '');
    }, interval);
}

defineExpose({
    toggleMsg
});

</script>

<template>
<div v-if="msg"  :class="[showMsg ? msgActiveClass : msgInactiveClass]"  >
    {{ msg }}
</div>
</template>

