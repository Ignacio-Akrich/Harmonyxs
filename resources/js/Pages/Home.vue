<template>
    <FrontLayout title="Inicio">
        <HeaderImage/>
        <div>
            <!-- <SliderImage/> -->
        </div>
        <div>
            <ArtistaDestacado/>
        </div>
    </FrontLayout>
    
</template>
<script setup>
import { Head, Link } from '@inertiajs/inertia-vue3';
import HeaderImage from "../Components/HeaderImage";
import SliderImage from "../Components/SliderImage";
import ArtistaDestacado from "../Components/ArtistaDestacado";
import FrontLayout from "@/Layouts/FrontLayout";

/* defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
}) */
</script>
<style scoped>
html, body {
    height: 100%;
    margin: 0;
    padding: 0;
}
body {
    display: flex;
    flex-direction: column;
}
/*.masthead {*/
/*    height: 100vh;*/
/*    min-height: 500px;*/
/*    background-image: url('../../img/home/disco.png');*/
/*    background-size: cover;*/
/*    background-position: center;*/
/*    background-repeat: no-repeat;*/
/*}*/
</style>
