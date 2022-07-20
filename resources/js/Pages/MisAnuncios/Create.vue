<template>
    <FrontLayout title="Publicar anuncio">

        <div class="container col-12 col-sm-10 col-md-8 col-lg-6 bg-light-50 my-5 py-3">
            <div v-if="$page.props.flash.error" class="alert alert-danger" role="alert" style="max-width: 48rem;">
                {{ $page.props.flash.error }}
            </div>
            <form @submit.prevent="submit" enctype='multipart/form-data'>
                <h3>Publica tu anuncio</h3>
                <hr>
                <div class="form-group mx-2 mb-3">
                    <label for="title" class="form-label fw-bold">Título
                        <span class="text-danger">*</span>
                    </label>
                    <input type="text" class="form-control" placeholder="Se busca cantante de rock" v-model="form.title" minlength="5" required>
                    <div v-if="errors.title" class="text-danger">{{ errors.title }}</div>
                </div>
                <div class="form-group mx-2 mb-3">
                    <label for="description" class="form-label fw-bold">Descripción
                        <span class="text-danger">*</span>
                    </label>
                    <textarea class="form-control" v-model="form.description" rows="3" placeholder="Se busca cantante de rock. Nuestras influencias son..." minlength="10" required></textarea>
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
                    <label for="file" class="form-label fw-bold">Sube una foto
                        <span class="text-danger">* </span>
                        <span customtip="Tamaño máximo: 2 MB. Puede ser jpeg, png, jpg, gif o svg" role="button" class="text-muted"><i class="fas fa-info-circle"></i></span>
                    </label>
                    <!-- <PhotoInput v-model="form.image" :default-src="'/images/uploadicon1.png'" /> -->
                    <PhotoInput v-model="form.image" />
                    <div v-if="errors.image" class="text-danger">
                        {{ errors.image }}
                    </div>
                </div>
                <button class="btn-primary btn" type="submit">Crear anuncio</button>

            </form>
        </div>
    </FrontLayout>
</template>

<script>

// import InputError from "@/Jetstream/InputError";
import {Inertia} from "@inertiajs/inertia";
import { Head, Link } from '@inertiajs/inertia-vue3';
import { useForm } from "@inertiajs/inertia-vue3";
import FrontLayout from "@/Layouts/FrontLayout";
import vSelect from 'vue-select';
import 'vue-select/dist/vue-select.css';
import PhotoInput from "@/Components/PhotoInput";
import MusicGenres from "@/Components/Data/MusicGenres";

export default {
    name: "Create",
    components: {
        FrontLayout,
        vSelect,
        PhotoInput,
        MusicGenres
    },
    props: {
        errors: Object,
    },
    data() {
        return {
            genres: MusicGenres.props.genres
        }
    },
    setup() {
        const form = useForm({
            image: null,
            title: "",
            description: "",
            music_genre: null,
            url: null,
        });

        return { form };
    },
    methods: {
        submit() {
            if (this.$refs.photo) {
                this.form.image = this.$refs.photo.files[0];
                console.log(this.form.image)
            }
            Inertia.post(route('misanuncios.store'), this.form)
        },
    }
}
</script>

<style scoped>

</style>
