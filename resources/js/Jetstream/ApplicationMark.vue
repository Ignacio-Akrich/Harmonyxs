<template>
    <Link :href="route('home')" class="text-decoration-none">
        <img src="../../img/Harmonyxs_black-cropped.svg" alt="logo Harmonyxs"  class="logo-nav">
    </Link>
</template>
<script>
import { Link } from '@inertiajs/inertia-vue3'

export default {
    components:{
        Link
    }
}
</script>
<style scoped>
.logo-nav{
    width: 125px;
}
</style>
