<template>
    <FrontLayout title="Editar anuncio">

        <div class="container col-12 col-sm-10 col-md-8 col-lg-6 bg-light-50 my-5 py-3">
            <form @submit.prevent="submit" enctype='multipart/form-data'>
                <h3>Edita tu anuncio</h3>
                <hr>
                <div class="form-group mx-2 mb-3">
                    <label for="title" class="form-label fw-bold">Título
                        <span class="text-danger">*</span>
                    </label>
                    <input type="text" class="form-control" placeholder="Busco músico" v-model="form.title" minlength="5" required>
                    <div v-if="errors.title" class="text-danger">{{ errors.title }}</div>
                </div>
                <div class="form-group mx-2 mb-3">
                    <label for="description" class="form-label fw-bold">Descripción
                        <span class="text-danger">*</span>
                    </label>
                    <textarea class="form-control" v-model="form.description" rows="3" minlength="10" required></textarea>
                    <div v-if="errors.description" class="text-danger">{{ errors.description }}</div>
                </div>

                <!-- Tabla de disponibilidad -->
                <!-- <div class="mx-2 mb-3">
                    <div class="dropdown-toggle" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                        Indícanos tu disponibilidad
                    </div>

                    <div class="collapse" id="collapseExample">
                        <table class="table">
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
                                <td><label><input type="checkbox"/></label></td>
                                <td><label><input type="checkbox"/></label></td>
                                <td><label><input type="checkbox"/></label></td>
                            </tr>
                            <tr>
                                <th scope="row">Martes</th>
                                <td><label><input type="checkbox"/></label></td>
                                <td><label><input type="checkbox"/></label></td>
                                <td><label><input type="checkbox"/></label></td>
                            </tr>
                            <tr>
                                <th scope="row">Miercoles</th>
                                <td><label><input type="checkbox"/></label></td>
                                <td><label><input type="checkbox"/></label></td>
                                <td><label><input type="checkbox"/></label></td>
                            </tr>
                            <tr>
                                <th scope="row">Jueves</th>
                                <td><label><input type="checkbox"/></label></td>
                                <td><label><input type="checkbox"/></label></td>
                                <td><label><input type="checkbox"/></label></td>
                            </tr>
                            <tr>
                                <th scope="row">Sábado</th>
                                <td><label><input type="checkbox"/></label></td>
                                <td><label><input type="checkbox"/></label></td>
                                <td><label><input type="checkbox"/></label></td>
                            </tr>
                            <tr>
                                <th scope="row">Domingo</th>
                                <td><label><input type="checkbox"/></label></td>
                                <td><label><input type="checkbox"/></label></td>
                                <td><label><input type="checkbox"/></label></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div> -->
                <!-- Fin tabla de disponibilidad -->

                <div class="form-group mx-2 mb-3">
                    <label for="music_genre" class="form-label fw-bold">Género musical
                        <span class="text-danger">*</span>
                    </label>
                    <vSelect
                        v-model="form.music_genre"
                        :options="genres"
                        placeholder="Elige un género musical..."
                        id="music_genre"
                        class="bg-white">
                        <template v-slot:no-options>Sin coincidencias</template>
                    </vSelect>
                    <div v-if="errors.music_genre" class="text-danger">
                        {{ errors.music_genre }}
                    </div>
                </div>

                <div class="mx-2 mb-3">
                    <label for="file" class="form-label fw-bold">Foto
                        <span customtip="Puedes modificar la foto en 'mis anuncios'" role="button" class="text-muted"><i class="fas fa-info-circle"></i></span>
                    </label>
                    <div v-if="form.image" class="d-flex justify-content-center mb-3" customtip="Puedes modificar la foto en 'mis anuncios'">
                        <img :src="'/storage/'+form.image" class="w-50">
                    </div>
                </div>
                <button class="btn-primary btn" type="submit">Editar anuncio</button>
            </form>
        </div>
    </FrontLayout>
</template>

<script setup>
const props = defineProps({
    anuncios: Object,
    errors: Object,
});

const form = useForm({
    title: props.anuncios.title,
    description: props.anuncios.description,
    music_genre: props.anuncios.music_genre,
    image: props.anuncios.image,
    url: null,
});

function submit() {
    Inertia.post(`/anuncios/${props.anuncios.id}`, {
    _method: 'put',
    title: form.title,
    description: form.description,
    music_genre: form.music_genre,
})
}

</script>
<script>
import {Inertia} from "@inertiajs/inertia";
import { Head, Link } from '@inertiajs/inertia-vue3';
import { useForm } from "@inertiajs/inertia-vue3";
import FrontLayout from "@/Layouts/FrontLayout";
import vSelect from 'vue-select';
import 'vue-select/dist/vue-select.css';
import PhotoInput from "@/Components/PhotoInput";
import MusicGenres from "@/Components/Data/MusicGenres";

export default {
    name: "Edit",
    components: {
        FrontLayout,
        vSelect,
        PhotoInput,
        MusicGenres
    },
    props: {
        anuncios: Object,
        errors: Object,
    },
    data() {
        return {
            genres: MusicGenres.props.genres
        }
    },
}
</script>

<style scoped>

</style>
