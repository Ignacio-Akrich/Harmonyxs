<template>
    <FrontLayout title="Mostrar anuncio">
        <div v-if="$page.props.flash.message" class="alert alert-success" role="alert" style="max-width: 48rem;">
            {{ $page.props.flash.message }}
        </div>
        <div class="container portfolio">
            <div class="row">
                <div class="col-md-12">
                    <div class="heading">
                        <Link class="btn btn-dark m-1" :href="route('misanuncios.edit', anuncios.id)" customtip="Editar">
                            Editar
                        </Link>
                        <a @click="selectedAds=anuncios" class="btn btn-secondary text-white m-1" customtip="Eliminar" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                            Eliminar
                        </a>
                    </div>
                </div>
            </div>
            <div class="bio-info">
                <div class="row">
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="shadow bio-image position-relative d-flex justify-content-center mb-4">
                                    <img :src="showImage() + anuncios.image" class="img-fluid rounded-3" alt="" onerror="this.src='/mstile-150x150.png'; this.onerror='';" />
                                    <div class="circle position-absolute top-100 start-100 translate-middle"></div>
                                    <div v-if="$page.props.user">
                                        <div v-if="$page.props.user.id === anuncios.user_id || $page.props.auth.roles[0] === 'Super Admin'">
                                            <div customtip="Cambiar foto" type="button" class="iconbutton-light position-absolute top-100 start-100 translate-middle" data-bs-toggle="modal" data-bs-target="#staticBackdrop1">
                                                <i class="far fa-image"></i>
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>
                                <div class="mx-2 mb-3">
                                    <div class="dropdown-toggle" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                                       Días disponibles
                                    </div>

                                    <div class="collapse" id="collapseExample">
                                        <table class="table" v-if="anuncios.user.availability_table !== null">
                                            <thead>
                                            <tr>
                                                <th scope="col">Todo el dia</th>
                                                <th scope="col">Mañana</th>
                                                <th scope="col">Tarde</th>
                                                <th scope="col">Noche</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <th scope="row">Lunes</th>
                                                <td><div v-if="anuncios.user.availability_table.includes('LM')">✔</div></td>
                                                <td><div v-if="anuncios.user.availability_table.includes('LT')">✔</div></td>
                                                <td><div v-if="anuncios.user.availability_table.includes('LN')">✔</div></td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Martes</th>
                                                <td><div v-if="anuncios.user.availability_table.includes('MaM')">✔</div></td>
                                                <td><div v-if="anuncios.user.availability_table.includes('MaT')">✔</div></td>
                                                <td><div v-if="anuncios.user.availability_table.includes('MaN')">✔</div></td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Miercoles</th>
                                                <td><div v-if="anuncios.user.availability_table.includes('MiM')">✔</div></td>
                                                <td><div v-if="anuncios.user.availability_table.includes('MiT')">✔</div></td>
                                                <td><div v-if="anuncios.user.availability_table.includes('MiN')">✔</div></td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Jueves</th>
                                                <td><div v-if="anuncios.user.availability_table.includes('JM')">✔</div></td>
                                                <td><div v-if="anuncios.user.availability_table.includes('JT')">✔</div></td>
                                                <td><div v-if="anuncios.user.availability_table.includes('JN')">✔</div></td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Viernes</th>
                                                <td><div v-if="anuncios.user.availability_table.includes('ViM')">✔</div></td>
                                                <td><div v-if="anuncios.user.availability_table.includes('ViT')">✔</div></td>
                                                <td><div v-if="anuncios.user.availability_table.includes('ViN')">✔</div></td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Sábado</th>
                                                <td><div v-if="anuncios.user.availability_table.includes('SaM')">✔</div></td>
                                                <td><div v-if="anuncios.user.availability_table.includes('SaT')">✔</div></td>
                                                <td><div v-if="anuncios.user.availability_table.includes('SaN')">✔</div></td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Domingo</th>
                                                <td><div v-if="anuncios.user.availability_table.includes('DoM')">✔</div></td>
                                                <td><div v-if="anuncios.user.availability_table.includes('DoT')">✔</div></td>
                                                <td><div v-if="anuncios.user.availability_table.includes('DoN')">✔</div></td>
                                            </tr>
                                            </tbody>
                                        </table>
                                        <div v-if="anuncios.user.availability_table == null"> No hay tabla de disponibilidad</div>
                                    </div>
                                </div>

                                <div class="card shadow-sm">
                                    <div class="card-title font-weight-bold">
                                        <div>
                                            Actividad de <br> {{ anuncios.user.name }} <br> {{ anuncios.user.email }}
                                        </div>
                                        <div>
                                            Se unió el día: {{ moment(anuncios.user.created_at).format('DD/MM/YYYY') }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="bio-content">
                            <h3>{{ anuncios.title }}</h3><span class="badge bg-secondary">{{ anuncios.music_genre }}</span>
                            <hr>
                            <p>{{ anuncios.description }}</p>
                            <hr>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="staticBackdrop1" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="staticBackdrop1Label" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdrop1Label">Cambiar imagen de anuncio</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form @submit.prevent="submit" enctype='multipart/form-data'>
                            <PhotoInput v-model="form.image" />
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal"
                            @click="submitImg()">Cambiar
                        </button>
                    </div>
                </div>
            </div>
        </div>

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
const props = defineProps({
    anuncios: Object,
    errors: Object,
});

const form = useForm({
    image: props.anuncios.image,
    url: null,
});

function submitImg() {
    Inertia.post(`/misanuncios/show/${props.anuncios.id}`, {
    _method: 'put',
    image: form.image,
})
}
</script>
<script>
import moment from "moment";
import FrontLayout from "../../Layouts/FrontLayout";
import Label from "../../Jetstream/Label";
import {Link} from '@inertiajs/inertia-vue3';
import {Inertia} from "@inertiajs/inertia";
import { useForm } from "@inertiajs/inertia-vue3";
import PhotoInput from "@/Components/PhotoInput";

export default {
    name: "Show",
    props: {
        anuncios: Object
    },
    components: {FrontLayout, Label, Link},
    data() {
        return {
            selectedAds: Object
        }
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
.circle {
    height: 2.6em;
    width: 2.6em;
    background-color: rgba(0, 0, 0, 0.7);
    border-radius: 50%;
}

.portfolio {
    padding:6%;
    text-align:center;
}

.heading {
    background: #fff;
    padding: 1%;
    text-align: left;
    box-shadow: 0px 0px 4px 0px #545b62;
}

.heading img {
    width: 10%;
}

.bio-info {
    padding: 5%;
    background:#fff;
    box-shadow: 0px 0px 4px 0px #b0b3b7;
}

.bio-image {
    text-align:center;
}

.bio-content {
    text-align:left;
}
</style>
