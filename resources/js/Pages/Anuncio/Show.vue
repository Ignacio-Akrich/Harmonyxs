<template>
    <FrontLayout title="Mostrar anuncio">
        <div class="container portfolio">
            <div class="row">
                <div class="col-md-12">
                    <div v-if="$page.props.flash.success" class="alert alert-success" role="alert">
                        {{ $page.props.flash.success }}
                    </div>
                    <div class="heading">
                        <button  class="btn btn-primary m-1" customtip="Enviar mensaje" data-bs-toggle="modal" data-bs-target="#staticBackdrop">Enviar mensaje</button>
                        <Link  class="btn btn-primary m-1" :href="route('profiles.show',anuncios.user.id)">Ver su perfil</Link>
                            <button type="button" data-container="body"
                                    class="btn btn-primary m-1" @click="copyURL(); hidden();">Copiar el enlace para compartir</button>
                        <input id="paste-box" type="text"/>
                            <small id="copied"></small>
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
                                            Anuncio de <Link :href="route('profiles.show',anuncios.user.id)">{{ anuncios.user.name }}</Link>
                                        </div>
                                        <div>
                                            Se unió el día:<br> {{ moment(anuncios.user.created_at).format('DD/MM/YYYY') }}
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

        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
             aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Contacta con {{anuncios.user.name}}</h5>
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

<script>
import Label from "../../Jetstream/Label";
import FrontLayout from "../../Layouts/FrontLayout";
import { createPopper } from '@popperjs/core';
import moment from 'moment';
import {Inertia} from "@inertiajs/inertia";
import {Link} from "@inertiajs/inertia-vue3";
import { useForm } from "@inertiajs/inertia-vue3";
import PhotoInput from "@/Components/PhotoInput";

export default {
    name: "Show",
    components: {FrontLayout, Label, Link,createPopper},
    props: {
        anuncios: Object,
        errors: Object,
    },
    data() {
        return {
            selectedAds: Object,
            form: {
                title: '',
                message: '',
                name: this.anuncios.user.name,
                email:this.anuncios.user.email,
            }
        }
    },
    methods: {
        showImage() {
            return "/storage/";
        },
        hide(){
            document.getElementById('copied').innerText ="";
        },
        hidden() {
            // document.getElementById('copied').innerText = "";
            document.getElementById('copied').innerHTML = "<svg xmlns=\"http://www.w3.org/2000/svg\" width=\"16\" height=\"16\" fill=\"currentColor\" class=\"bi bi-check2-circle\" viewBox=\"0 0 16 16\">\n" +
                "  <path d=\"M2.5 8a5.5 5.5 0 0 1 8.25-4.764.5.5 0 0 0 .5-.866A6.5 6.5 0 1 0 14.5 8a.5.5 0 0 0-1 0 5.5 5.5 0 1 1-11 0z\"/>\n" +
                "  <path d=\"M15.354 3.354a.5.5 0 0 0-.708-.708L8 9.293 5.354 6.646a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0l7-7z\"/>\n" +
                "</svg>Enlace copiado";
            setTimeout(this.hide, 5000);
        },
        copyURL() {
            let Url = document.getElementById("paste-box");
            Url.value = window.location.href;
            Url.focus();
            Url.select();
            document.execCommand("Copy");
        },
        returnObject(){
            console.log(this.anuncios.user.email);
        },
        async submit() {
            Inertia.post(route('send.name', this.form))
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

#paste-box {
    position:absolute;
    left:-9999px
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

#copied {
    color: green;
    padding: 5px;
}
</style>
