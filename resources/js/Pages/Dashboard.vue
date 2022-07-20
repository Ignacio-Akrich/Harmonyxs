<template>
  <app-layout title="Dashboard">
    <template #header>
      <h2 class="h4 font-weight-bold">
        Dashboard
      </h2>

    </template>
<DashboardGrid :adcount="form.retornarAnuncios"
               :user-count="form.retornarUsuarios"
               :ads="form.retornarlistaAnuncios"
               :users="form.retornarlistaUsuario"
/>


  </app-layout>
</template>

<script>
import { defineComponent } from "vue"
import AppLayout from "@/Layouts/AppLayout.vue"
import Welcome from "@/Jetstream/Welcome.vue"
import MapSearch from "../Components/MapSearch";
import DashboardGrid from "../Components/DashboardGrid";
export default defineComponent({
    props: {
        userCount: Number,
        adcount: Number,
        ads: Object,
        users: Object
    },
    data(){
        return{
            form:{
                retornarAnuncios: this.adcount,
                retornarUsuarios: this.userCount,
                retornarlistaUsuario: this.users,
                retornarlistaAnuncios: this.ads,

            },
        }
    },
  components: {
      DashboardGrid,
    AppLayout,
    Welcome,
      MapSearch
  }
});
</script>
