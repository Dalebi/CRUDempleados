<script setup lang="ts" >

import {  faFile } from '@fortawesome/free-solid-svg-icons' //this one no need to be in all pages, so i can do the load here
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome' //I want to avoid this charge twice

const props = defineProps({ title: String, icon: Object})

const newLink = window.location.pathname + '/create';
const isIndexPage = (window.location.pathname.split("/").length-1)==1;

</script>

<template>
<div class="flex flex-row mt-2 justify-center gap-2">
    <div class=" sm:basis-6/12   pt-4 sm:pt-6 lg:pt-8" :class="isIndexPage?'lg:basis-4/12':'lg:basis-6/12'">
        <div class=" text-2xl text-gray-900 font-bold  align-middle text-left">
             <span v-if="!icon">
                <slot name="icon"></slot>
            </span>
            <span v-else>
                <component :is="icon" class=" align-middle h-7 w-7  text-gray-500 float-left mr-2 " />
            </span>

             {{ title }}
        </div>
    </div>

            <div v-if="isIndexPage" class="lg:basis-2/12 sm:basis-full  pt-4 sm:pt-6 lg:pt-8">
                <div  class="   text-xl text-blue-600 font-bold text-left  " >
                <a :href="newLink">
                    <button  class="btn btn-primary w-full h-11 content-center " >
                        <FontAwesomeIcon :icon='faFile' class="content-center h-4 w-4  mr-1 "></FontAwesomeIcon>
                        Nuevo</button>
                </a>
                </div>
            </div>
    </div>

</template>
