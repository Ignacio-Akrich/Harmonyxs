<template>
    <FrontLayout title="Mi perfil">
        <section class="img-head d-flex flex-column justify-content-end align-items-center">
            <div class="bg-white">
                <div class="bg-white px-2 rounded-top bg-white">
                    <h1 class="">{{$page.props.user.name}}</h1>
                </div>
            </div>
        </section>
        <section class="valoracion d-flex flex-column justify-content-end align-items-center">
            <div class="img-profile img-pq img-fluid">
                <img src="../../../img/perfil/perfil_artista.webp" class="img-pq" v-if="$page.props.user.profile_photo === null">
                <img v-else :src="showImage() + $page.props.user.profile_photo" class="img-pq">
                <button type="button" class="iconbutton-dark position-absolute img-pq" data-bs-toggle="modal" data-bs-target="#staticBackdrop1">
                    <i class="far fa-image"></i>
                </button>
                </div>
                <div class="mb-3">
                    <!-- ⭐⭐⭐⭐⭐
                </div>
                <div>
                    <button class="btn btn-success">
                        Enviar mensaje
                    </button> -->
                    <div class="musicgenre text-center pt-3 ">
                        <span class="badge bg-dark fs-6 m-1" v-for="musicgenre in $page.props.user.music_genre" :key="musicgenre.id">{{musicgenre}}</span>
                    </div>
                </div>
            </section>
            <section clas="main">
                <div class="container mb-5">
                <div class="row">
                    <div class="col-12 col-md-8">
                        <!-- <div class="aud-art border border-3 my-2">
                            <h4>AUDIOS Y LINKS</h4>
                        </div> -->
                        <div class="inf-art border border-3 mb-2 bg-white shadow py-3">
                            <div class="d-flex justify-content-between">
                                <h4 class="ms-5 my-2 ">INFORMACION DE LA BANDA</h4>
                                <Link :href="route('profiles.edit',$page.props.user.id)" class=" iconbutton-dark mx-2">
                                    <i class="fas fa-user-edit"></i>
                                </Link> 
                            </div>
                            <!-- Datos Banda -->
                            <div class="ms-5" v-if="$page.props.user.member !== null && $page.props.user.member.length > 0">
                            <p>INTEGRANTES DE LA BANDA</p>
                            <div v-for="integrantes in $page.props.user.member" :key="integrantes.id">{{ integrantes }}</div>
                            </div>
                            <hr class="mx-4" v-if="$page.props.user.member !== null && $page.props.user.member.length > 0">
                            <p class="ms-5" v-if="$page.props.user.creation_date !== null"><b>Fecha de formacion de la banda: </b>{{ $page.props.user.creation_date }}</p>
                            <hr class="mx-4" v-if="$page.props.user.creation_date !== null">
                            <p class="ms-5" v-if="$page.props.user.concert_experience !== null">
                                <b>Con experiencia en conciertos: </b>
                                <span v-if="$page.props.user.concert_experience == '1'">Si</span> 
                                <span v-if="$page.props.user.concert_experience == '0'">No</span>
                            </p>
                            <hr class="mx-4" v-if="$page.props.user.concert_experience !== null">
                        </div>
                        <div class="disp-art border border-3 mb-2 bg-white shadow py-3">
                            <div class="d-flex justify-content-between">
                                <h4 class="ms-5 my-2">Disponibilidad</h4>
                                <Link :href="route('profiles.edit',$page.props.user.id)" class=" iconbutton-dark mx-2">
                                    <i class="fas fa-user-edit"></i>
                                </Link> 
                            </div>
                            <div class="mx-5 my-2">
                            <table class="table mb-3 text-center" v-if="$page.props.user.availability_table !== null">
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
                                        <td><div v-if="$page.props.user.availability_table.includes('LM')">✔</div>
                                        </td>
                                        <td><div v-if="$page.props.user.availability_table.includes('LT')">✔</div>
                                        </td>
                                        <td><div v-if="$page.props.user.availability_table.includes('LN')">✔</div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Martes</th>
                                        <td><div v-if="$page.props.user.availability_table.includes('MaM')">✔</div>
                                        </td>
                                        <td><div v-if="$page.props.user.availability_table.includes('MaT')">✔</div>
                                        </td>
                                        <td><div v-if="$page.props.user.availability_table.includes('MaN')">✔</div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Miercoles</th>
                                        <td><div v-if="$page.props.user.availability_table.includes('MiM')">✔</div>
                                        </td>
                                        <td><div v-if="$page.props.user.availability_table.includes('MiT')">✔</div>
                                        </td>
                                        <td><div v-if="$page.props.user.availability_table.includes('MiN')">✔</div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Jueves</th>
                                        <td><div v-if="$page.props.user.availability_table.includes('JM')">✔</div>
                                        </td>
                                        <td><div v-if="$page.props.user.availability_table.includes('JT')">✔</div>
                                        </td>
                                        <td><div v-if="$page.props.user.availability_table.includes('JN')">✔</div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Viernes</th>
                                        <td><div v-if="$page.props.user.availability_table.includes('ViM')">✔</div>
                                        </td>
                                        <td><div v-if="$page.props.user.availability_table.includes('ViT')">✔</div>
                                        </td>
                                        <td><div v-if="$page.props.user.availability_table.includes('ViN')">✔</div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Sabado</th>
                                        <td><div v-if="$page.props.user.availability_table.includes('SaM')">✔</div>
                                        </td>
                                        <td><div v-if="$page.props.user.availability_table.includes('SaT')">✔</div>
                                        </td>
                                        <td><div v-if="$page.props.user.availability_table.includes('SaN')">✔</div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Domingo</th>
                                        <td><div v-if="$page.props.user.availability_table.includes('DoM')">✔</div>
                                        </td>
                                        <td><div v-if="$page.props.user.availability_table.includes('DoT')">✔</div>
                                        </td>
                                        <td><div v-if="$page.props.user.availability_table.includes('DoN')">✔</div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <div v-else>Actualmente no hay tabla de disponibilidad</div> 
                            </div>

                            </div>
                            <div class="border border-3 bg-white p-4 shadow" v-if="$page.props.user.lat !== null">
                                <h4 class="ms-5">UBICACIÓN</h4>
                                <gMapMap :center='center' :zoom='12' style='width:100%;  height: 300px;'>
                                    <GMapMarker :key="index" v-for="(m, index) in markers" :position="m.position"/>
                                </gMapMap> 
                            </div>
                            <!-- Mis anuncios -->
                            <div class="anun-art border border-3 bg-white p-4 shadow">
                                <h4 class="ms-4">MIS ANUNCIOS</h4> 
                                <article v-for="anuncio in $page.props.anuncios" :key="anuncio.id" class="card mb-3 ms-4 anuncio shadow">
                                <div class="row g-0">
                                    <div class="col-sm-3">
                                        <img :src="showImage() + anuncio.image" class="img-fluid rounded-start" alt="/" onerror="this.src='/mstile-150x150.png'; this.onerror=''; "/>
                                    </div>
                                    <div class="col-sm-9 d-flex">
                                        <div class="card-body d-flex flex-column justify-content-between">
                                            <div class="d-flex justify-content-between">
                                                <h5 class="card-title">{{ anuncio.title }}</h5>
                                                <!-- Acciones para manipular un anuncio -->
                                                <div>                                    
                                                    <div>
                                                        <Link class="iconbutton-dark mx-2" :href="route('anuncios.edit', anuncio.id)" customtip="Editar">
                                                            <i class="fas fa-pen"></i>
                                                        </Link>
                                                        <a @click="selectedAds=anuncio" class="iconbutton-secondary mx-2" customtip="Eliminar" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                                                            <i class="fas fa-trash"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                                <!-- Fin acciones para manipular -->
                                            </div>
                                            <p class="card-text text-truncate-custom flex-grow-1">{{anuncio.description }}</p>
                                            <div class="row">
                                                <div class="col-8 align-self-center">
                                                    <div class="card-text">
                                                        <small class="text-muted">Publicado el {{ moment(anuncio.created_at).format('DD/MM/YYYY [a las] HH:mm') }}</small>
                                                    </div>
                                                </div>
                                                <div class="col-4 align-self-center d-flex justify-content-end">
                                                    <Link :href="route('anuncios.show', anuncio.id)" class="btn btn-primary" customtip="Ver detalles">+ Info</Link>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </article>
                            <div class="d-flex justify-content-center">
                                <Link v-if="$page.props.user" class="px-4 py-2 mb-2 btn btn-dark" :href="route('anuncios.create')" as="button">
                                    Crear nuevo anuncio
                                </Link>
                            </div>
                        </div>
                        <!-- Fin de mis anuncios -->
                    </div>
                    <div class="perfil col-12 col-md-4 mt-md-0 mt-3">
                        <div class="border border-3 bg-white py-3 mb-2 shadow">
                            <div class="d-flex justify-content-between">
                                <h2 class="fs-5 mx-2 my-2">Descripción del artista</h2>
                                <Link :href="route('profiles.edit',$page.props.user.id)" class=" iconbutton-dark mx-2">
                                    <i class="fas fa-user-edit"></i>
                                </Link>   
                            </div>
                            <p class="user-desc mx-2 my-3">{{$page.props.user.description}}</p>
                        </div>
                        <div class="border border-3 bg-white py-3 shadow">
                        <div class="d-flex flex-column mx-2 my-2">
                            <h2 class="fs-5 mx-2 my-2 mb-3">Redes sociales</h2>
                            <a class="mx-2" href="https://www.youtube.com/"><i class="fab fa-youtube text-danger"></i> Youtube</a>
                            <a class="mx-2" ><i class="fas fa-paper-plane"></i> {{$page.props.user.email}}</a>
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
        <!-- Modal Img Profile -->
        <div class="modal fade" id="staticBackdrop1" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
             aria-labelledby="staticBackdrop1Label" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdrop1Label">Cambiar Imagen Perfil</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form @submit.prevent="submit" enctype='multipart/form-data'>
                            <PhotoInput v-model="form.profile_photo" />
                            
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
        <!-- Modal Eliminar -->
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
import {Inertia} from "@inertiajs/inertia";
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';
import MapSearch from "../../Components/MapSearch";
import FrontLayout from "@/Layouts/FrontLayout";
import moment from 'moment';
import PhotoInput from "@/Components/PhotoInput";
const form = useForm({
    profile_photo: null,
});
</script>
<script>
 export default {
    name: "Artist",
    props: {
        bandas: Object,
        anuncios: Object,
    },
    data() {
        return {
            center: { lat: parseFloat(this.$page.props.user.lat), lng: parseFloat(this.$page.props.user.lng) },
            currentPlace: null,
            markers: [
                {position: { lat: parseFloat(this.$page.props.user.lat), lng: parseFloat(this.$page.props.user.lng) }},
            ],
            places: [],
            selectedAds: Object,
        }
    },
    methods: {
        showImage() {
            return "/storage/";
        },
        deleteAds: function (selectedAd) {
            Inertia.delete(route("anuncios.destroy", selectedAd))
        },
        submitImg() {
            Inertia.post(route('profiles.store'), this.form)
        },
    },
    created: function () {
        this.moment = moment;
    },
    
   

 }
</script>