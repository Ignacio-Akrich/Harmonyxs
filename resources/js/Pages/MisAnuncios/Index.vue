<template>
    <FrontLayout title="Anuncios">
        <div class="container-fluid">
            <div class="row">

                <div class="col-10 col-lg-3 mt-5">
                    <Link v-if="$page.props.user" class="px-4 py-2 mb-2 btn btn-dark"
                          :href="route('misanuncios.create')" as="button">
                        <i class="fas fa-plus-square me-2"></i>Crear nuevo anuncio
                    </Link>
                </div>


                <section v-if="anuncios.length > 0" class="col-12 col-lg-9 anuncios">
                    <h2 class="my-3 py-3">Estos son los anuncios que has creado:</h2>
                    <!-- Card anuncio -->
                    <div v-if="$page.props.flash.success" class="alert alert-success" role="alert">
                        {{ $page.props.flash.success }}
                    </div>

                    <article v-for="anuncio in anuncios" :key="anuncio.id" class="card mb-3 anuncio col-12 col-lg-10 col-xxl-9">
                        <div class="row g-0">
                            <Link :href="route('misanuncios.show', anuncio.id)" class="col-12 col-sm-3 col-xxl-2">
                                <img :src="showImage() + anuncio.image" class="img-fluid rounded-start" alt="/" onerror="this.src='/mstile-150x150.png'; this.onerror=''; "/>
                            </Link>
                            <div class="col-12 col-sm-9 col-xxl-10 d-flex">
                                <div class="card-body d-flex flex-column justify-content-between">
                                    <div class="d-flex justify-content-between">
                                        <h5 class="card-title col-8 col-sm-9 col-md-10 title-link">
                                            <Link :href="route('misanuncios.show', anuncio.id)">
                                                {{ anuncio.title }}
                                            </Link>
                                        </h5>
<!--                                         <i class="far fa-heart ms-3"></i>-->
                                        <!-- Acciones para manipular un anuncio -->
                                        <div v-if="$page.props.user">

                                            <div v-if="$page.props.user.id === anuncio.user_id || $page.props.auth.roles[0] === 'Super Admin'">
                                                <Link class="mx-2" :href="route('misanuncios.edit', anuncio.id)" customtip="Editar">
                                                    <i class="iconbutton-dark fas fa-pen"></i>
                                                </Link>
                                                <a @click="selectedAds=anuncio" class="ms-2" customtip="Eliminar" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                                                    <i class="iconbutton-secondary fas fa-trash"></i>
                                                </a>
                                            </div>
                                        </div>
                                        <!-- Fin acciones para manipular -->
                                    </div>

                                    <p class="card-text text-truncate-custom flex-grow-1">{{ anuncio.description }}</p>
                                    <div class="row">
                                        <div class="col-12 col-sm-9 align-self-center">
                                            <div class="card-text"><small class="text-muted">Publicado el {{ moment(anuncio.created_at).format('DD/MM/YYYY [a las] HH:mm') }} </small></div>
                                        </div>
                                        <div class="col-12 col-sm-3 align-self-center text-center text-sm-end">
                                            <Link :href="route('misanuncios.show', anuncio.id)" class="btn btn-primary fw-bold px-5 px-sm-2 mt-2" customtip="+Info">+ Info</Link>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </article>
                    <!-- Fin card anuncio -->
<!--                    <pagination class="mt-4" :links="anuncios.links"/>-->
                </section>
                <!-- En caso de no haber publicado anuncios -->
                <section v-else class="col-12 col-lg-9 my-5 anuncios">
                    <div class="card mb-3 anuncio">
                        <div class="row g-0">
                            <div class="col-12 col-sm-3 col-xxl-2">
                                <img src="mstile-150x150.png" class="img-fluid rounded-start" alt="/" />
                            </div>

                            <div class="col-12 col-sm-9 col-xxl-10 d-flex">
                                <div class="card-body d-flex flex-column justify-content-between">
                                    <h4 class="card-title">¡Vaya! Todavía no has publicado anuncios</h4>
                                    <Link v-if="$page.props.user" class="card-text" :href="route('misanuncios.create')">
                                        Puedes crear un nuevo anuncio aquí.
                                    </Link>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

            </div>
        </div>
        <!-- Button trigger modal -->

        <!-- Modal -->
        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
             aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Eliminar anuncio</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p v-if="selectedAds">¿Seguro que quieres eliminar el anuncio <strong>
                            {{ selectedAds.title }} </strong>?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal"
                                @click="deleteAds(selectedAds)">Eliminar
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </FrontLayout>
</template>
<script setup>
import {Link} from '@inertiajs/inertia-vue3';
</script>
<script>

import {Inertia} from "@inertiajs/inertia";
import moment from "moment";
// import Pagination from '@/Components/Pagination';
import FrontLayout from "@/Layouts/FrontLayout";
export default {
    name: "Index",
    props: {
        anuncios: Object,
    },
    data() {
        return {
            selectedAds: Object
        }
    },
    components: {
        FrontLayout,
        // Pagination
    },
    methods: {
        showImage() {
            return "/storage/";
        },
        deleteAds: function (selectedAd) {
            Inertia.delete(route("misanuncios.destroy", selectedAd))
        },
    },
    created: function () {
        this.moment = moment;
    },


}
</script>

<style scoped>
.img-fluid {
    width: 100%;
    height: 100%;
    object-fit: cover;
}
</style>
