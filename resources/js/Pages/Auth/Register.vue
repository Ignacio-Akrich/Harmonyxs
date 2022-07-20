<script setup>
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';
import JetAuthenticationCard from '@/Jetstream/AuthenticationCard.vue';
import JetAuthenticationCardLogo from '@/Jetstream/AuthenticationCardLogo.vue';
import JetButton from '@/Jetstream/Button.vue';
import JetInput from '@/Jetstream/Input.vue';
import JetInputError from '@/Jetstream/InputError.vue';
import JetCheckbox from '@/Jetstream/Checkbox.vue';
import JetLabel from '@/Jetstream/Label.vue';
import JetValidationErrors from '@/Jetstream/ValidationErrors.vue';
import MapSearch from "../../Components/MapSearch";
import { Inertia } from "@inertiajs/inertia";
import { defineComponent } from 'vue';
import Multiselect from '@vueform/multiselect';
import { ref } from "vue";
import vSelect from 'vue-select';
import 'vue-select/dist/vue-select.css';
import MusicGenres from "@/Components/Data/MusicGenres";
import Instrumentos from "@/Components/Data/Instrumentos";
import MiembrosBanda from "@/Components/Data/MiembrosBanda";
const regState = ref('state1');
const roles = ref();
const form = useForm({
    email: "",
    password: "",
    password_confirmation: "",
    roles: "",
    name: "",
    address: "",
    instrumento: "",
    music_genre: [],
    experience: "",
    band_experience: "",
    member: [],
    address_rehearsal_room: "",
    creation_date: "",
    concert_experience: "",
    availability_table: [],
    age: "",
    gender: "",
    description: "",
    terms: false,
    lat: '',
    lng: ''
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};

const props = defineProps({
    errors: Object
});


</script>

<template>

    <Head title="Register" />

    <JetAuthenticationCard>
        <!-- Logo -->
        <div class="logo">
            <Link :href="route('home')">
            <JetAuthenticationCardLogo />
            </Link>
        </div>

        <form @submit.prevent="submit">
            <transition name="slide-fade">
                <!-- ----------- Primera Pagina ------------------------------------------------------------------------ -->
                <div v-if="regState === 'state1'">
                    <h1 class="text-center">Registro</h1>
                    <div class="my-3">
                        <JetLabel for="email" value="Email*" />
                        <JetInput id="email" type="email" v-model="form.email" required autocomplete="username"
                            @blur="validateEmail()" clear-button ref="input" />
                        <div v-if="errors.email" class="text-danger">
                            {{ errors.email }}
                        </div>
                        <div class="text-danger">
                            {{ errorEmail }}
                        </div>
                    </div>
                    <div class="my-3">
                        <JetLabel for="password" value="Contraseña*" />
                        <JetInput id="password" type="password" v-model="form.password" title="Longitud mínima de 8 caracteres required" autocomplete="new-password" @blur="validatePassword()" />
                        <div v-if="errors.password" class="text-danger">
                            {{ errors.password }}
                        </div>
                        <div class="text-danger">
                            {{ errorPassword }}
                        </div>
                    </div>

                    <div class="my-3">
                        <JetLabel for="password_confirmation" value="Confirma la contraseña*" />
                        <JetInput id="password_confirmation" type="password" v-model="form.password_confirmation"
                            required autocomplete="new-password" @blur="validatePasswordConf()" />
                        <div v-if="errors.password_confirmation" class="text-danger">
                            {{ errors.password_confirmation }}
                        </div>
                        <div class="text-danger">
                            {{ errorPasswordConf }}
                        </div>
                    </div>
                    <div class="my-3">
                        <JetLabel for="roles" value="¿Eres un artista o una banda?*" />
                        <select id="roles" class="form-select" v-model="form.roles"
                            aria-label="¿Eres un artista o una banda?">
                            <option value="Artista">Artista</option>
                            <option value="Banda">Banda</option>
                        </select>
                        <div v-if="errors.roles" class="text-danger">
                            {{ errors.roles }}
                        </div>
                    </div>
                    <div class="my-3 text-center mb-5">
                        <button type="button" class="btn btn-primary" v-on:click="validatePageOne()">siguiente</button>
                    </div>
                </div>
                <!-- ----------- Segunda Pagina ------------------------------------------------------------------------ -->
                <div v-else-if="regState === 'state2'">
                    <div class="my-3" v-if="form.roles === 'Artista'">
                        <JetLabel for="name" value="Nombre Artista*" />
                        <JetInput id="name" type="text" v-model="form.name" required autocomplete="name" />
                        <div v-if="errors.name" class="text-danger">
                            {{ errors.name }}
                        </div>
                    </div>
                    <div class="my-3" v-else-if="form.roles === 'Banda'">
                        <JetLabel for="name" value="Nombre Banda*" />
                        <JetInput id="name" type="text" v-model="form.name" required autocomplete="name" />
                        <div v-if="errors.name" class="text-danger">
                            {{ errors.name }}
                        </div>
                    </div>

                    <div class="my-3">
                        <JetLabel for="roles"
                            value="¿Es tu ubicación, en caso contrario añade tu dirección aquí?" />

                        <!--TODO -->
                        <div>
                            <div>
                                <input type="hidden" v-model="form.lat" name="lat" id="lat">
                                <input type="hidden" v-model="form.lng" name="lng" id="lng">
                                <div class="input-group">
                                    <GMapAutocomplete @place_changed='setPlace' class="form-control col-6"
                                        aria-describedby="button-addon2" />
                                    <button @click='addMarker' type="button" class="btn btn-outline-dark"
                                        id="button-addon2">
                                        Añadir ubicación
                                    </button>
                                </div>
                            </div>
                            <br>

                            <gMapMap :center='center' :zoom='12' style='width:100%;  height: 250px;'>
                                <GMapMarker :key="index" v-for="(m, index) in markers" :position="m.position"
                                    @click="center = m.position" />
                            </gMapMap>
                        </div>
                        <!--END OF MAP -->
                        <div v-if="errors.lat && errors.lng" class="text-danger">
                            {{ errors.lat }} {{ errors.lng }}
                        </div>
                    </div>
                    <div class="my-3 text-center mb-5">
                        <button type="button" class="btn btn-secondary me-2"
                            @click="regState = 'state1'">volver</button>
                        <button type="button" class="btn btn-primary" v-on:click="validatePageTwo()">siguiente</button>
                    </div>
                </div>
                <!-- ----------- Tercera Pagina Artista ------------------------------------------------------------------------ -->
                <div v-else-if="regState === 'state3' && form.roles === 'Artista'">
                    <div class="my-3">
                        <JetLabel for="instrumento" value="Instrumento Principal" />
                        <vSelect id="instrumento" :options="instruments" v-model="form.instrumento"
                            placeholder="Instrumento principal" >
                        </vSelect>
                    </div>
                    <div class="my-3">
                        <JetLabel for="music_genre" value="Generos musicales" />
                        <vSelect v-model="form.music_genre" :options="genres" placeholder="Elige tus géneros musicales..."
                            id="music_genre" class="bg-white" multiple>
                            <template v-slot:no-options>Sin coincidencias</template>
                        </vSelect>
                    </div>
                    <div class="my-3">
                        <JetLabel for="experience" value="Experiencia" />
                        <select id="experience" class="form-select" v-model="form.experience" aria-label="Experiencia">
                            <option value="Principiante">Principiante</option>
                            <option value="Moderado">Moderado</option>
                            <option value="Avanzado">Avanzado</option>
                        </select>
                    </div>
                    <div class="my-3">
                        <JetLabel for="band_experience" value="Experiencia en Bandas" />
                        <div class="form-check">
                            <input class="form-check-input" type="radio" id="oneband" value=1
                                v-model="form.band_experience" />
                            <label class="form-check-label" for="oneband">Si</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" id="Twoband" value=0
                                v-model="form.band_experience" />
                            <label class="form-check-label" for="Twoband">No</label>
                        </div>
                    </div>
                    <div class="my-3 text-center mb-5">
                        <button type="button" class="btn btn-secondary me-2"
                            @click="regState = 'state2'">volver</button>
                        <button type="button" class="btn btn-primary" @click="regState = 'state4'">siguiente</button>
                    </div>
                </div>
                <!-- ----------- Tercera Pagina Banda ------------------------------------------------------------------------ -->
                <div v-else-if="regState === 'state3' && form.roles === 'Banda'">
                    <div class="my-3">
                        <JetLabel for="member" value="Miembros de la banda" />
                        <vSelect v-model="form.member" :options="members" placeholder="Miembros de la banda..."
                            id="member" class="bg-white" multiple>
                            <template v-slot:no-options>Sin coincidencias</template>
                        </vSelect>
                    </div>
                    <div class="my-3">
                        <JetLabel for="music_genre" value="Generos musicales" />
                        <vSelect v-model="form.music_genre" :options="genres" placeholder="Elige los géneros musicales de tu banda ..."
                            id="music_genre" class="bg-white" multiple>
                            <template v-slot:no-options>Sin coincidencias</template>
                        </vSelect>
                    </div>
                    <div class="my-3">
                        <JetLabel for="creation_date" value="Fecha formación banda" />
                        <JetInput id="creation_date" type="date" v-model="form.creation_date" />
                    </div>
                    <div class="my-3">
                        <JetLabel for="concert_experience" value="Experiencia en Conciertos" />
                        <div class="form-check">
                            <input class="form-check-input" type="radio" id="one" value=1
                                v-model="form.concert_experience" />
                            <label class="form-check-label" for="one">Si</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" id="Two" value=0
                                v-model="form.concert_experience" />
                            <label class="form-check-label" for="Two">No</label>
                        </div>
                    </div>
                    <div class="my-3 text-center mb-5">
                        <button type="button" class="btn btn-secondary me-2"
                            @click="regState = 'state2'">volver</button>
                        <button type="button" class="btn btn-primary" @click="regState = 'state4'">siguiente</button>
                    </div>
                </div>
                <!-- ----------- Cuarta Pagina ------------------------------------------------------------------------ -->
                <div v-else-if="regState === 'state4'">
                    <div class="my-3">
                        <JetLabel for="availability_table" value="Disponibilidad" />
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Mañana</th>
                                    <th scope="col">Tarde</th>
                                    <th scope="col">Noche</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th scope="row">Lunes</th>
                                    <td><input type="checkbox" value="LM" v-model="form.availability_table" />
                                    </td>
                                    <td><input type="checkbox" value="LT" v-model="form.availability_table" />
                                    </td>
                                    <td><input type="checkbox" value="LN" v-model="form.availability_table" />
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">Martes</th>
                                    <td><input type="checkbox" value="MaM" v-model="form.availability_table" />
                                    </td>
                                    <td><input type="checkbox" value="MaT" v-model="form.availability_table" />
                                    </td>
                                    <td><input type="checkbox" value="MaN" v-model="form.availability_table" />
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">Miercoles</th>
                                    <td><input type="checkbox" value="MiM" v-model="form.availability_table" />
                                    </td>
                                    <td><input type="checkbox" value="MiT" v-model="form.availability_table" />
                                    </td>
                                    <td><input type="checkbox" value="MiN" v-model="form.availability_table" />
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">Jueves</th>
                                    <td><input type="checkbox" value="JM" v-model="form.availability_table" />
                                    </td>
                                    <td><input type="checkbox" value="JT" v-model="form.availability_table" />
                                    </td>
                                    <td><input type="checkbox" value="JN" v-model="form.availability_table" />
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">Viernes</th>
                                    <td><input type="checkbox" value="ViM" v-model="form.availability_table" />
                                    </td>
                                    <td><input type="checkbox" value="ViT" v-model="form.availability_table" />
                                    </td>
                                    <td><input type="checkbox" value="ViN" v-model="form.availability_table" />
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">Sabado</th>
                                    <td><input type="checkbox" value="SaM" v-model="form.availability_table" />
                                    </td>
                                    <td><input type="checkbox" value="SaT" v-model="form.availability_table" />
                                    </td>
                                    <td><input type="checkbox" value="SaN" v-model="form.availability_table" />
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">Domingo</th>
                                    <td><input type="checkbox" value="DoM" v-model="form.availability_table" />
                                    </td>
                                    <td><input type="checkbox" value="DoT" v-model="form.availability_table" />
                                    </td>
                                    <td><input type="checkbox" value="DoN" v-model="form.availability_table" />
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="my-3 text-center mb-5">
                        <button type="button" class="btn btn-secondary me-2"
                            @click="regState = 'state3'">volver</button>
                        <button type="button" class="btn btn-primary" @click="regState = 'state5'">siguiente</button>
                    </div>
                </div>
                <!-- ----------- Quinta Pagina ------------------------------------------------------------------------ -->
                <div v-else-if="regState === 'state5'">
                    <div class="my-3" v-if="form.roles === 'Artista'">
                        <JetLabel for="age" value="Edad" />
                        <JetInput id="age" type="number" v-model="form.age" />
                        <div v-if="errors.age" class="text-danger">
                            {{ errors.age }}
                        </div>
                    </div>
                    <div class="my-3" v-if="form.roles === 'Artista'">
                        <JetLabel for="gender" value="Genero" />
                        <div class="form-check">
                            <input class="form-check-input" type="radio" id="man" value="hombre"
                                v-model="form.gender" />
                            <label class="form-check-label" for="man">Hombre</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" id="woman" value="mujer"
                                v-model="form.gender" />
                            <label class="form-check-label" for="woman">Mujer</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" id="none" value="none" v-model="form.gender" />
                            <label class="form-check-label" for="none">Prefiero no decirlo</label>
                        </div>
                    </div>
                    <div class="my-3">
                        <JetLabel for="description" value="Descripcion" />
                        <textarea class="form-control" id="description" v-model="form.description" rows="5" title="Breve descripción sobre ti"></textarea>
                        <div v-if="errors.description" class="text-danger">
                            {{ errors.description }}
                        </div>
                    </div>
                    <div class="my-3 text-center mb-5">
                        <button type="button" class="btn btn-secondary" @click="regState = 'state4'">volver</button>
                    </div>
                </div>
            </transition>

            <div v-if="$page.props.jetstream.hasTermsAndPrivacyPolicyFeature" class="mt-2">
                <JetLabel for="terms">
                    <div class="flex items-center">
                        <JetCheckbox id="terms" v-model:checked="form.terms" name="terms" />
                        <div class="ms-2">
                            Estoy de acuerdo con los
                            <a target="_blank" :href="route('terms.show')"
                                class="underline text-sm text-gray-600 hover:text-gray-900">Terms of Service</a>
                            and
                            <a target="_blank" :href="route('policy.show')"
                                class="underline text-sm text-gray-600 hover:text-gray-900">Privacy Policy</a>
                        </div>
                    </div>
                </JetLabel>
            </div>
            <div class="d-flex align-items-center justify-content-end mt-2">
                <Link :href="route('login')" class="text-decoration-underline">
                ¿Ya tienes una cuenta?
                </Link>

                <JetButton class="mx-2" v-if="regState !== 'state1' && this.form.lat !== '' && this.form.lng !== ''"> Regístrate </JetButton>
            </div>
        </form>
    </JetAuthenticationCard>
    <!-- <JetValidationErrors class="mb-4" /> -->
</template>

<script>
export default {
    data() {
        return {
            center: { lat: 40.4167, lng: -3.7035 },
            currentPlace: null,
            markers: [],
            places: [],
            errorEmail: '',
            errorPassword: '',
            errorPasswordConfirmation: '',
            genres: MusicGenres.props.genres,
            instruments: Instrumentos.props.instruments,
            members: MiembrosBanda.props.members,
        }
    },
    mounted() {
        this.geolocate();
    },
    props: {
        errors: Object,
    },
    methods: {
        validateEmail() {
            if (this.form.email.indexOf("@") == -1) {
                this.errorEmail = 'El email debe tener una @';
            } else if (this.form.email.indexOf(".") == -1) {
                this.errorEmail = 'El email debe tener un punto';
            } else {
                this.errorEmail = '';
            }
        },
        validatePassword() {
            if (this.form.password.length < 8) {
                this.errorPassword = 'La contraseña debe tener al menos 8 caracteres';
            } else {
                this.errorPassword = '';
            }
        },
        validatePasswordConf() {
            if (this.form.password_confirmation !== this.form.password) {
                this.errorPasswordConf = 'Las contraseñas no coinciden';
            } else {
                this.errorPasswordConf = '';
            }
        },
        validatePageOne() {
            if (this.form.email !== '' && this.errorEmail === '' && this.errorPassword === '' && this.errorPasswordConf === '' && this.form.roles !== '') {
                this.regState = 'state2';
            }
        },
        validatePageTwo() {
            if (this.form.name !== '' && this.form.lat !== '' && this.form.lng !== '') {
                this.regState = 'state3';
            }
        },
        



        checkInputValidation: function (val) {
            if (val.length > 0) this.$refs.input.reset()
        },
        setPlace(place) {
            this.currentPlace = place;
            this.form.lat = place.geometry.location.lat();
            this.form.lng = place.geometry.location.lng();
        },
        addMarker() {
            if (this.currentPlace) {

                const marker = {
                    lat: this.currentPlace.geometry.location.lat(),
                    lng: this.currentPlace.geometry.location.lng(),
                };

                this.markers = [{ position: marker }];
                this.places = this.currentPlace;
                this.center = marker;
                this.currentPlace = null;
            }
        },
        geolocate: function () {
            navigator.geolocation.getCurrentPosition(position => {
                this.center = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude,
                };
                // this.markers = [{position: this.center }];
            });
        },

    }
};
</script>

