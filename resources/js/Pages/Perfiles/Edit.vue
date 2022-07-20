<template>
    <FrontLayout title="Editar de perfil">
        <section class="img-head d-flex flex-column justify-content-end align-items-center">
            <div class="bg-white">
                <div class="bg-white px-2 rounded-top bg-white">
                    <h1 class="">{{$page.props.user.name}}</h1>
                </div>
            </div>
        </section>
        <form @submit.prevent="submit">
            <!-- Datos Generales -->
            <div class="container">
            <div class="valoracion d-flex justify-content-center">
                <div class="my-3 col-10 col-md-5 ">
                    <JetLabel for="music_genre" value="Generos musicales" />
          <vSelect v-model="form.music_genre" :options="genres" placeholder="Elige tus géneros musicales..." id="music_genre" class="bg-white" multiple>
            <template v-slot:no-options>Sin coincidencias</template>
          </vSelect>
        </div>
        </div>
        </div>
            <div class="container mb-5">
            <div class="row">
                <div class="col-12 col-md-8">
        <div class="border border-3 mb-2 bg-white shadow py-3">
        <!-- Datos Artista -->
        <div v-if="$page.props.auth.roles[0] === 'Artista'">
        <h4 class="ms-5 my-2 ">INFORMACION DEL ARTISTA</h4>
            <div class="mb-3 mx-5">
            <JetLabel for="instrumento" value="Instrumento Principal" />
            <!-- con el instrumento seleccionado -->
            <vSelect id="instrumento" :options="instruments" v-model="form.instrumento"></vSelect>
            </div>
            <div class="mb-3 mx-5">
            <JetLabel for="experience" value="Experiencia" />
            <select id="experience" class="form-select" v-model="form.experience" aria-label="Experiencia">
                <option value="Principiante">Principiante</option>
                <option value="Moderado">Moderado</option>
                <option value="Avanzado">Avanzado</option>
            </select>
            </div>
            <div class="mb-3 mx-5">
            <JetLabel for="band_experience" value="Experiencia en Bandas" />
            <div class="d-flex">
                <div class="form-check ms-2">
                <input class="form-check-input" type="radio" id="oneband" value=1 v-model="form.band_experience" />
                <label class="form-check-label" for="oneband">Si</label>
                </div>
                <div class="form-check ms-2">
                <input class="form-check-input" type="radio" id="Twoband" value=0 v-model="form.band_experience" />
                <label class="form-check-label" for="Twoband">No</label>
                </div>
            </div>
            </div>
            <div class="mb-3 mx-5">
            <JetLabel for="age" value="Edad" />
            <JetInput id="age" type="number" v-model="form.age" />
            </div>
            <div class="mb-3 mx-5">
            <JetLabel for="gender" value="Genero" />
            <div class="d-flex">
                <div class="form-check ms-2">
                <input class="form-check-input" type="radio" id="man" value="hombre" v-model="form.gender" />
                <label class="form-check-label" for="man">Hombre</label>
                </div>
                <div class="form-check ms-2">
                <input class="form-check-input" type="radio" id="woman" value="mujer" v-model="form.gender" />
                <label class="form-check-label" for="woman">Mujer</label>
                </div>
                <div class="form-check ms-2">
                <input class="form-check-input" type="radio" id="none" value="none" v-model="form.gender" />
                <label class="form-check-label" for="none">Prefiero no decirlo</label>
                </div>
            </div>
            </div>
        </div>
        <!-- Datos Banda -->
        <div v-if="$page.props.auth.roles[0] === 'Banda'">
        <h4 class="ms-5 my-2 ">INFORMACION DE LA BANDA</h4>
            <div class="mb-3 mx-5">
              <JetLabel for="member" value="Miembros de la banda" />
              <vSelect v-model="form.member" :options="members" placeholder="Miembros de la banda..." id="member" class="bg-white" multiple>
                <template v-slot:no-options>Sin coincidencias</template>
              </vSelect>
            </div>
            <div class="mb-3 mx-5">
              <JetLabel for="creation_date" value="Fecha formación banda" />
              <JetInput id="creation_date" type="date" v-model="form.creation_date" />
            </div>
            <div class="mb-3 mx-5">
              <JetLabel for="concert_experience" value="Experiencia en Conciertos" />
              <div class="d-flex">
                <div class="form-check ms-2">
                  <input class="form-check-input" type="radio" id="one" value=1 v-model="form.concert_experience" />
                  <label class="form-check-label" for="one">Si</label>
                </div>
                <div class="form-check ms-2">
                  <input class="form-check-input" type="radio" id="Two" value=0 v-model="form.concert_experience" />
                  <label class="form-check-label" for="Two">No</label>
                </div>
              </div>
            </div>
        </div>
        </div>
        <div class="border border-3 mb-2 bg-white shadow py-3">
            <!-- Tabla Disponibilidad -->
            <h4 class="ms-5 my-2">Disponibilidad</h4>
            <div class="mx-5 my-2">
              <table class="table text-center">
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
                    <td><input type="checkbox" value="LM" v-model="form.availability_table" /></td>
                    <td><input type="checkbox" value="LT" v-model="form.availability_table" /></td>
                    <td><input type="checkbox" value="LN" v-model="form.availability_table" /></td>
                  </tr>
                  <tr>
                    <th scope="row">Martes</th>
                    <td><input type="checkbox" value="MaM" v-model="form.availability_table" /></td>
                    <td><input type="checkbox" value="MaT" v-model="form.availability_table" /></td>
                    <td><input type="checkbox" value="MaN" v-model="form.availability_table" /></td>
                  </tr>
                  <tr>
                    <th scope="row">Miercoles</th>
                    <td><input type="checkbox" value="MiM" v-model="form.availability_table" /></td>
                    <td><input type="checkbox" value="MiT" v-model="form.availability_table" /></td>
                    <td><input type="checkbox" value="MiN" v-model="form.availability_table" /></td>
                  </tr>
                  <tr>
                    <th scope="row">Jueves</th>
                    <td><input type="checkbox" value="JM" v-model="form.availability_table" /></td>
                    <td><input type="checkbox" value="JT" v-model="form.availability_table" /></td>
                    <td><input type="checkbox" value="JN" v-model="form.availability_table" /></td>
                  </tr>
                  <tr>
                    <th scope="row">Viernes</th>
                    <td><input type="checkbox" value="ViM" v-model="form.availability_table" /></td>
                    <td><input type="checkbox" value="ViT" v-model="form.availability_table" /></td>
                    <td><input type="checkbox" value="ViN" v-model="form.availability_table" /></td>
                  </tr>
                  <tr>
                    <th scope="row">Sabado</th>
                    <td><input type="checkbox" value="SaM" v-model="form.availability_table" /></td>
                    <td><input type="checkbox" value="SaT" v-model="form.availability_table" /></td>
                    <td><input type="checkbox" value="SaN" v-model="form.availability_table" /></td>
                  </tr>
                  <tr>
                    <th scope="row">Domingo</th>
                    <td><input type="checkbox" value="DoM" v-model="form.availability_table" /></td>
                    <td><input type="checkbox" value="DoT" v-model="form.availability_table" /></td>
                    <td><input type="checkbox" value="DoN" v-model="form.availability_table" /></td>
                  </tr>
                </tbody>
              </table>
            </div>
            </div>
            <!-- <div class="border border-3 bg-white p-4 shadow">
                <h4 class="ms-5">UBICACIÓN</h4>
                <div class="mx-5 mt-3">
                    <div class="mb-3">
          <div>
            <div>
              <jet-input type="hidden" v-model="form.lat" name="lat" id="lat"/>
              <jet-input type="hidden" v-model="form.lng" name="lng" id="lng"/>
                <div class="input-group">
                  <GMapAutocomplete @place_changed='setPlace' class="form-control col-6" aria-describedby="button-addon2" />
                  <button @click='addMarker' type="button" class="btn btn-outline-dark" id="button-addon2">
                    Añadir ubicación
                  </button>
                </div>
            </div>
            <br>
            <gMapMap :center='center' :zoom='12' style='width:100%;  height: 250px;'>
              <GMapMarker :key="index" v-for="(m, index) in markers" :position="m.position" @click="center = m.position" />
            </gMapMap>
          </div>
        </div>
                </div>
        </div> -->
        </div>
        <div class="perfil col-12 col-md-4 mt-md-0 mt-3">
            <div class="border border-3 bg-white py-3 mb-2 shadow">
                
                     <h2 class="fs-5 mx-2 my-2">Descripción</h2>
                     <div class="mx-2 my-3">
                         <textarea class="form-control" id="description" v-model="form.description" rows="5"></textarea>
                     </div>
                   
                       </div>
                   <div class="border border-3 bg-white py-3 shadow">
                   <div class="text-center mx-2 my-2">
                       <JetButton class="mx-2" > Save </JetButton>
                   </div>
                </div>
        </div>
      </div>
      </div>
        </form>
        
  </FrontLayout>


</template>

<script setup>
import vSelect from 'vue-select'
</script>

<script>
import JetButton from '@/Jetstream/Button.vue'
import JetFormSection from '@/Jetstream/FormSection.vue'
import JetInput from '@/Jetstream/Input.vue'
import JetInputError from '@/Jetstream/InputError.vue'
import JetLabel from '@/Jetstream/Label.vue'
import JetActionMessage from '@/Jetstream/ActionMessage.vue'
import JetSecondaryButton from '@/Jetstream/SecondaryButton.vue'
import MapSearch from '@/Components/MapSearch'
import 'vue-select/dist/vue-select.css'
import MusicGenres from "@/Components/Data/MusicGenres"
import Instrumentos from "@/Components/Data/Instrumentos"
import MiembrosBanda from "@/Components/Data/MiembrosBanda" 
import { defineComponent } from 'vue'
// import AppLayout from '@/Layouts/AppLayout.vue'
import FrontLayout from "@/Layouts/FrontLayout";

export default defineComponent({
  components: {
    FrontLayout,
  },

  props: {
      user: Object,
  },
  data() {
    return {
      form: this.$inertia.form({
        _method: 'PUT',
        /* lat: parseFloat(this.user.lat),
        lng: parseFloat(this.user.lng),
        center: { lat: parseFloat(this.user.lat), lng: parseFloat(this.user.lng) },
        currentPlace: null,
        markers: [
            {position: { lat: parseFloat(this.user.lat), lng: parseFloat(this.user.lng) }},
        ],
        places: [], */
        instrumento: this.user.instrumento,
        music_genre: this.user.music_genre,
        experience: this.user.experience,
        band_experience: this.user.band_experience,
        age: this.user.age,
        member: this.user.member,
        creation_date: this.user.creation_date,
        concert_experience: this.user.concert_experience,
        availability_table: this.user.availability_table,
        description: this.user.description,
      }),
      genres: MusicGenres.props.genres,
      instruments: Instrumentos.props.instruments,
      members: MiembrosBanda.props.members,
    }
  },

  methods: {
    submit() {
      this.form.post(route('profiles.update',this.user.id), {
        preserveScroll: true,
      });
    },
   /*  setPlace(place) {
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
            this.markers.push({ position: marker });
            this.places.push(this.currentPlace);
            this.center = marker;
            this.currentPlace = null;
        }
    }, */
  },
})
</script>

