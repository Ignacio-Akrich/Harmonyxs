<template>
    <FrontLayout title="Mostrar Perfil">
        <section class="img-head d-flex flex-column justify-content-end align-items-center bg-white">
                <div class="bg-white">
                <div class="title-username px-2 rounded-top bg-white " >
                    <h1 class="bg-white">{{userperfil.name}}</h1>
                    
                </div>
                </div>
            </section>
            <section class="valoracion mb-4 d-flex flex-column justify-content-end align-items-center">
                <div class="img-profile img-pq img-fluid">
                    <img src="../../../img/perfil/perfil_artista.webp" class="img-pq" v-if="userperfil.profile_photo === null">
                    <img v-else :src="showImage() + userperfil.profile_photo" class="img-pq">
                
                </div>
                <div class="mb-3">
                    <!-- ⭐⭐⭐⭐⭐
                </div>
                <div>
                    <button class="btn btn-success">
                        Enviar mensaje
                    </button> -->
                    <div class="musicgenre text-center pt-3 ">
                        <span class="badge bg-dark fs-6 m-1" v-for="musicgenre in userperfil.music_genre" :key="musicgenre.id">{{musicgenre}}</span>
                    </div>
                    <div class="message text-center">
                        <button  class="btn btn-primary m-1" customtip="Enviar" data-bs-toggle="modal" data-bs-target="#staticBackdrop">Enviar Mensaje</button>
                    </div>
                </div>
            </section>
            <section class="main">
                <div class="container mb-5">
                <div class="row">
                    <div class="col-12 col-md-8">
                        <!-- <div class="aud-art border border-3 my-2">
                            <h4>AUDIOS Y LINKS</h4>
                        </div> -->
                        <div v-if="$page.props.flash.success" class="alert alert-success" role="alert">
                            {{ $page.props.flash.success }}
                        </div>
                        <div class="inf-art border border-3 mb-2 bg-white shadow py-3">
                            <h4 class="ms-5 my-2 ">INFORMACIÓN</h4>
                             <!-- Datos Artista -->
                                <div class="ms-5" v-if="userperfil.instrumento !== null">
                                    <p>Instrumento principal</p>
                                    <p><b>{{userperfil.instrumento}}:</b> {{userperfil.experience}}</p>
                                </div>
                                <hr class="mx-4" v-if="userperfil.instrumento !== null">
                                <p class="ms-5" v-if="userperfil.band_experience !== null"><b>Experiencia con bandas: </b>
                                    <span v-if="userperfil.band_experience == '1'">Si</span> 
                                    <span v-if="userperfil.band_experience == '0'">No</span>
                                </p>
                                <hr class="mx-4" v-if="userperfil.band_experience !== null">
                                <p class="ms-5" v-if="userperfil.age !== null"><b>Edad: </b>{{userperfil.age}}</p>
                                <hr class="mx-4" v-if="userperfil.age !== null">
                                <p class="ms-5" v-if="userperfil.gender !== null && userperfil.gender !== 'none'"><b>Genero: </b>{{userperfil.gender}}</p>
                                <hr class="mx-4" v-if="userperfil.gender !== null && userperfil.gender !== 'none'">
                                <!-- Datos Banda -->
                                <div class="ms-5" v-if="userperfil.member !== null && userperfil.member.length > 0">
                                    <p>INTEGRANTES DE LA BANDA</p>
                                    <div class="ms-5" v-for="integrantes in userperfil.member" :key="integrantes.id">{{ integrantes }}</div>
                                </div>
                                <hr class="mx-4" v-if="userperfil.member !== null && userperfil.member.length > 0">
                                <p class="ms-5" v-if="userperfil.creation_date !== null"><b>Fecha de formacion de la banda: </b>{{ userperfil.creation_date }}</p>
                                <hr class="mx-4" v-if="userperfil.creation_date !== null">
                                <p class="ms-5" v-if="userperfil.concert_experience !== null"><b>Con experiencia en conciertos: </b>
                                    <span v-if="userperfil.concert_experience == '1'">Si</span> 
                                    <span v-if="userperfil.concert_experience == '0'">No</span>
                                </p>
                                <hr class="mx-4" v-if="userperfil.concert_experience !== null">
                            </div>
                            <div class="disp-art border border-3 mb-2 bg-white shadow py-3">   
                            <h4 class="ms-5 my-2">Disponibilidad</h4>
                            <div class="mx-5 my-2">
                            <table class="table mb-3 text-center " v-if="userperfil.availability_table !== null">
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
                                        <td><div v-if="userperfil.availability_table.includes('LM')">✔</div>
                                        </td>
                                        <td><div v-if="userperfil.availability_table.includes('LT')">✔</div>
                                        </td>
                                        <td><div v-if="userperfil.availability_table.includes('LN')">✔</div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Martes</th>
                                        <td><div v-if="userperfil.availability_table.includes('MaM')">✔</div>
                                        </td>
                                        <td><div v-if="userperfil.availability_table.includes('MaT')">✔</div>
                                        </td>
                                        <td><div v-if="userperfil.availability_table.includes('MaN')">✔</div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Miercoles</th>
                                        <td><div v-if="userperfil.availability_table.includes('MiM')">✔</div>
                                        </td>
                                        <td><div v-if="userperfil.availability_table.includes('MiT')">✔</div>
                                        </td>
                                        <td><div v-if="userperfil.availability_table.includes('MiN')">✔</div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Jueves</th>
                                        <td><div v-if="userperfil.availability_table.includes('JM')">✔</div>
                                        </td>
                                        <td><div v-if="userperfil.availability_table.includes('JT')">✔</div>
                                        </td>
                                        <td><div v-if="userperfil.availability_table.includes('JN')">✔</div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Viernes</th>
                                        <td><div v-if="userperfil.availability_table.includes('ViM')">✔</div>
                                        </td>
                                        <td><div v-if="userperfil.availability_table.includes('ViT')">✔</div>
                                        </td>
                                        <td><div v-if="userperfil.availability_table.includes('ViN')">✔</div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Sabado</th>
                                        <td><div v-if="userperfil.availability_table.includes('SaM')">✔</div>
                                        </td>
                                        <td><div v-if="userperfil.availability_table.includes('SaT')">✔</div>
                                        </td>
                                        <td><div v-if="userperfil.availability_table.includes('SaN')">✔</div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Domingo</th>
                                        <td><div v-if="userperfil.availability_table.includes('DoM')">✔</div>
                                        </td>
                                        <td><div v-if="userperfil.availability_table.includes('DoT')">✔</div>
                                        </td>
                                        <td><div v-if="userperfil.availability_table.includes('DoN')">✔</div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <div v-else>Actualmente no hay tabla de disponibilidad</div> 
                            </div>
                              
                            </div>
                            <div class="border border-3 bg-white p-4 shadow" v-if="userperfil.lat !== null">
                                <h4 class="ms-5">UBICACIÓN</h4>
                                <div class="mx-5 mt-3">
                                    <gMapMap :center='center' :zoom='12' style='width:100%;  height: 300px;'>
                                        <GMapMarker :key="index" v-for="(m, index) in markers" :position="m.position"/>
                                    </gMapMap> 
                                </div>
                            </div>
                    </div>
                    <div class="perfil col-12 col-md-4 mt-md-0 mt-3">
                        <div class="border border-3 bg-white py-3 mb-2 shadow">
                            <h2 class="fs-5 mx-2 my-2">Descripción del artista</h2>
                            <p class="user-desc mx-2 my-3">{{userperfil.description}}</p>
                        </div>
                        <div class="border border-3 bg-white py-3 shadow">
                        <div class="d-flex flex-column mx-2 my-2">
                            <h2 class="fs-5 mx-2 my-2 mb-3">Redes sociales</h2>
                            <a class="mx-2" href="https://www.youtube.com/"><i class="fab fa-youtube text-danger"></i> Youtube</a>
                            <a class="mx-2" ><i class="fas fa-paper-plane"></i> {{userperfil.email}}</a>
                            <a class="mx-2" href="https://www.instagram.com/"><i class="fab fa-instagram text-secondary"></i> Instagram</a>
                        </div>      
                        </div>              
                        <!-- <div class="anuncio-perfil border border-3 mt-3">
                            Anuncio
                        </div> -->
                    </div>
                    <!-- <div class="anuncio-perfil border border-3 mt-3">
                        <p>Videos de youtube y fotos</p>
                        <div>
                            CARROUSEL
                        </div>
                    </div> -->
                </div>
                </div>
            </section>
            <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
             aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Contacta con {{ userperfil.name}}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                       <form @submit.prevent="submit">
                           <div class="form-group mb-2">
<!--                               <label for="exampleFormControlInput1">Email address</label>-->
                               <input name="email" type="text" class="form-control" id="exampleFormControlInput1" v-model="form.email" hidden>
                               <input name="name" type="text" class="form-control" id="exampleFormControlInput4" v-model="form.name" hidden>

                               <label for="exampleFormControlInput2">Asunto</label>
                               <input placeholder="Quiero contactar contigo" name="title" type="text" class="form-control" id="exampleFormControlInput2" v-model="form.title" maxlength="70">
                           </div>
                           <div class="form-group mb-2">
                               <label for="exampleFormControlTextarea1">Mensaje al usuario</label>
                               <textarea name="message" class="form-control" id="exampleFormControlTextarea1" rows="3"  v-model="form.message" required maxlength="350"></textarea>
                           </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary" data-bs-dismiss="modal" @click="submit()">Enviar Mensaje</button>
                    </div>
                       </form>
                    </div>
                </div>
            </div>
        </div>
    </FrontLayout>
</template>
<script setup>
import {Inertia} from "@inertiajs/inertia";
import { Head, Link} from '@inertiajs/inertia-vue3';
import FrontLayout from "@/Layouts/FrontLayout";
</script>
<script>
export default {
    name: "Show",
    props: {
        userperfil: Object,
    },
    data() {
        return {
            center: { lat: parseFloat(this.userperfil.lat), lng: parseFloat(this.userperfil.lng) },
            currentPlace: null,
            markers: [
                { position: { lat: parseFloat(this.userperfil.lat), lng: parseFloat(this.userperfil.lng) } },
            ],
            places: [],
            selectedAds: Object,
            form: {
                title: '',
                message: '',
                name: this.userperfil.name,
                email:this.userperfil.email,
            }
        }
    },
    methods: {
        showImage() {
            return "/storage/";
        },
        async submit() {
            Inertia.post(route('sendprofiles.name', this.form));
        },
    },
}
</script>
<style scoped>
    .title-username{
        background-color: white !important;
        opacity: 1;
    }
</style>