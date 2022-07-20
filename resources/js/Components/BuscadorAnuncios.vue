<template>
    <!-- Buscador de anuncios -->
    <div class="accordion" id="accordionFilter">
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingOne">
                <button class="accordion-button shadow-none border" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                    Filtra tu búsqueda
                </button>
            </h2>
            <!-- Contenido acordeón -->
            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionFilter">
                <div class="accordion-body p-3">
                    <form @submit.prevent="submit">
                        <!-- Filtro geolocalización -->
                        <div class="col-12 my-1">
                            <label hidden class="form-label"></label>
                            <input type="hidden" v-model="form.lat" name="lat" id="lat">
                            <input type="hidden" v-model="form.lng" name="lng" id="lng">
                            <label></label>
                            <label class="form-label fw-bold">Busca tu ciudad</label>
                            <GMapAutocomplete class="form-control my-1" id="citysearch" @place_changed="setPlace" placeholder="Tu ciudad"/>
                            <label class="form-label my-2">Distancia</label>
                            <input name="distance" v-model="form.distance" id="distance" type="range" min="1" max="100" class="slider mx-2" ><span>{{ form.distance }} km</span>
                        </div>
                        <!-- Fin filtro geolocalización -->
                        <!-- Filtro género musical -->
                        <div class="col-12 my-2">
                            <label for="music_genre" class="form-label fw-bold">Género musical</label>
                            <vSelect
                                v-model="form.music_genre"
                                :options="genres"
                                placeholder="Elige un género musical..."
                                id="music_genre"
                                name="music_genre"
                                class="bg-white">
                                <template v-slot:no-options>Sin coincidencias</template>
                            </vSelect>
                        </div>
                        <!-- Fin filtro género musical -->
                        <!-- Filtro roles -->
                        <div class="row col-12 my-3">
                            <div class="col-6">
                                <input class="form-check-input me-1" type="radio" value="Artista" id="inlineRadio1" v-model="form.roles">
                                <label class="form-check-label" for="inlineRadio1">Busco músico</label>
                            </div>
                            <div class="col-6">
                                <input class="form-check-input me-1" type="radio" value="Banda" id="inlineRadio2" v-model="form.roles">
                                <label class="form-check-label" for="inlineRadio2">Busco banda</label>
                            </div>
                        </div>
                        <!-- Fin filtro roles -->
                        <a href="#" class="btn btn-dark my-2 mx-2 shadow-none" @click="resetFilters()">Reiniciar filtros</a>
                        <a href="#" class="btn btn-primary my-2 mx-2 shadow-none" @click="submit()">Buscar</a>
                    </form>
                </div>
            </div>
            <!-- Fin contenido acordeón -->
        </div>
    </div>
    <!-- Fin buscador de anuncios -->
</template>

<script>
import { Link } from "@inertiajs/inertia-vue3";
import SearchLocationForm from "./SearchLocationForm";
import vSelect from 'vue-select';
import 'vue-select/dist/vue-select.css';
import {Inertia} from "@inertiajs/inertia";
import MusicGenres from "@/Components/Data/MusicGenres";

export default {
    name: "BuscadorAnuncios",
    components: {
        SearchLocationForm,
        Link,
        vSelect,
    },
    data() {
        return {
            genres: MusicGenres.props.genres,
            form: {
                lat: '',
                lng: '',
                distance: 50,
                roles: '',
                music_genre: null,
            },
        }
    },
    methods: {
        setPlace(place) {
            // this.form = place;
            this.form.lat = place.geometry.location.lat();
            this.form.lng = place.geometry.location.lng();
        },
        
        async submit() {
            Inertia.get(route('anuncios.index', this.form))
        },
        resetFilters() {
            this.form.distance = 50;
            this.form.roles = '';
            this.form.music_genre = null;
        }
    },
}
</script>

<style scoped>
#textInput{
    border: none;
    outline: none;
    width: 50px;
    background: transparent;
}
</style>
