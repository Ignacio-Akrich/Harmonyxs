<template>

    <nav class="navbar-expand-md navbar-light bg-white shadow sticky-top">
        <div class="container">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <a class="navbar-brand" :href="route('home')">
                    <img src="../../img/Harmonyxs_black-cropped.svg" width="125" alt="Harmonyxs">
                </a>
                <div class="navbar-nav mx-5 col-md-4 justify-content-center" >
<!--                    :active="route().current('home')"-->
                    <NavLink :href="route('home')" :active="route().current('home')">Inicio</NavLink>
<!--                    :active="route().current('anuncios')"-->
                    <NavLink :href="route('anuncios.index')" :active="route().current('anuncios.*')">Anuncios</NavLink>
<!--                    :active="route().current('anuncios')+ '?&roles='+roles[0]"-->
                    <div class="dropdown show text-center">
                        <a class="nav-link dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                           Buscar por
                        </a>

                        <div class="dropdown-menu dropdown-menu" aria-labelledby="dropdownMenuLink">
                            <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <Link :href="route('anuncios.index')+roles[0]" class="dropdown-item">
                                    <i class="col-2 me-2 fas fa-music"></i>
                                    <span class="col-10">Músicos</span>
                                </Link>
                            </li>
                            <li class="list-group-item">
                                <Link :href="route('anuncios.index')+roles[1]" class="dropdown-item">
                                    <i class="col-2 me-2 fas fa-guitar"></i>
                                    <span class="col-10">Bandas</span>
                                </Link>
                            </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="navbar-nav ms-auto align-self-center">
                    <div v-if="$page.props.user" class="dropdown text-center">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDarkDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            {{ $page.props.user.name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu" aria-labelledby="navbarDarkDropdownMenuLink">
                            <li><h6 class="dropdown-header">Usuario {{ $page.props.auth.roles[0] }}</h6></li>
                            <li>
                                <Link v-if="$page.props.auth.roles[0] === 'Super Admin'" :href="route('dashboard')" class="dropdown-item px-4">
                                    <i class="col-2 me-2 far fa-chart-bar"></i>
                                    <span class="col-10">Dashboard</span>
                                </Link>
                                <Link v-else-if="$page.props.auth.roles[0] === 'Artista'" :href="route('artist')" class="dropdown-item px-4">
                                    <i class="col-2 me-2 far fa-address-card"></i>
                                    <span class="col-10">Mi Perfil</span>
                                </Link>
                                <Link v-else-if="$page.props.auth.roles[0] === 'Banda'" :href="route('band')" class="dropdown-item px-4">
                                    <i class="col-2 me-2 far fa-address-card"></i>
                                    <span class="col-10">Mi Perfil</span>
                                </Link>
                            </li>
                            <li>
                                <Link :href="route('misanuncios.index')" class="dropdown-item px-4">
                                    <i class="col-2 me-2 fas fa-folder-open"></i>
                                    <span class="col-10">Mis anuncios</span>
                                </Link>
                            </li>
                            <li>
                                <Link :href="route('profile.show')" class="dropdown-item px-4">
                                    <i class="col-2 me-2 fas fa-user-cog"></i>
                                    <span class="col-10">Configuración</span>
                                </Link>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <!-- Autenticación (cierre de sesión) -->
                            <li>
                                <form @submit.prevent="logout">
                                    <jet-dropdown-link as="button">
                                        <i class="col-2 me-2 fas fa-key text-warning"></i>
                                        <span class="col-10">Cerrar sesión</span>
                                    </jet-dropdown-link>
                                </form>
                            </li>
                        </ul>
                    </div>

                    <template v-else>
                        <Link :href="route('login')" class="nav-item nav-link">
                            Login
                        </Link>

                        <Link :href="route('register')" class="nav-item nav-link">
                            Regístrate
                        </Link>
                    </template>

                </div>
            </div>
        </div>
    </nav>

</template>
<script setup>

import {Head, Link} from '@inertiajs/inertia-vue3';
import AppLayout from "../Layouts/AppLayout";
import NavLink from "@/Components/NavLink";
import JetDropdownLink from '@/Jetstream/DropdownLink.vue';

</script>
<script>
export default {
    name: "NavBar",
    components: {
        Link,
        NavLink,
    },
    methods: {
        logout() {
            this.$inertia.post(route('logout'));
        },

    },
    props: {
        filters: Object,
    },
    data() {
        return {
            roles: ['?&roles=artista', '?&roles=banda'],
        }
    },
}

</script>

<style scoped>
.navbar-collapse {
    flex-basis: 100%;
    flex-grow: 1;
    align-items: end;
}

</style>
