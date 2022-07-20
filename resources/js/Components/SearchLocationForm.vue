<template>
    <h1 class="font-weight-bold text-white"><strong>Encuentra músicos con experiencia</strong></h1>
    <p class="font-italic mb-5 text-white">
        <strong>Encuentra bandas o músicos afines a tu estilo de música en tu ciudad</strong>
    </p>

    <form @submit.prevent="submit">
        <div class="row d-flex justify-content-center px-0 mx-0">
            <div class="col-auto align-self-baseline mr-0">
                <div class="form-outline form-white mb-4">

                    <label hidden class="form-label"></label>
                    <input type="hidden" v-model="form.lat" name="lat" id="lat">
                    <input type="hidden" v-model="form.lng" name="lng" id="lng">
                    <GMapAutocomplete class="form-control" id="citysearch" @place_changed="setPlace" placeholder="Tu ciudad"/>
                    <input hidden name="distance" v-model="form.distance" id="distance" type="range" min="1" max="100" class="slider" @change="updateTextInput(form.distance)" >
                </div>
            </div>
            <div class="col-auto align-self-baseline ml-0">
                <button type="button" class="btn btn-primary" @click="submit()">Encuentra {{ form.roles }}s</button>
            </div>
        </div>
        <div class="form-check form-check-inline my-2">
            <input class="form-check-input" type="radio" name="rolmusico" id="rolmusico"
                   value="artista" v-model="form.roles">
            <label class="form-check-label text-white" for="inlineRadio1">Busco músico</label>
        </div>
        <div class="form-check form-check-inline my-2">
            <input class="form-check-input" type="radio" name="rolbanda" id="rolbanda"
                   value="banda" v-model="form.roles">
            <label class="form-check-label text-white" for="inlineRadio2">Busco banda</label>
        </div>
    </form>
</template>

<script>
import {Inertia} from "@inertiajs/inertia";
import vSelect from 'vue-select';
import 'vue-select/dist/vue-select.css';

export default {
    name: "SearchLocationForm",
    components: {
        vSelect
    },
    data() {
        return {
            genres: ['Pop', 'Jazz', 'Rap', 'R&B', 'Heavy metal', 'Rock'],
            form: {
                lat: '',
                lng: '',
                distance: 50,
                roles: 'artista',
                music_genre: '',
            },

        }
    },
    methods: {
        setPlace(place) {
            // this.form = place;
            this.form.lat = place.geometry.location.lat();
            this.form.lng = place.geometry.location.lng();
        },
        updateTextInput(val) {
           let number =   document.getElementById('textInput').value= val;
        },
        async submit() {
            Inertia.get(route('anuncios.index', this.form))
        },

    },
}

</script>

<style scoped>
/*#citysearch{*/
/*    width: 280px;*/
/*}*/

#textInput{
    border: none;
    outline: none;
    width: 50px;
    background: transparent;
}

</style>
