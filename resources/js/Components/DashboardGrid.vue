<template>
    <div class="row">

        <div class="col small-box">
            <div class="box-title text-center"><h3>Hola <strong> {{$page.props.user.name}},</strong> bienvenido a nuestro Dashboard:</h3></div>
            </div>
        </div>


    <div class="container dashboard-container">

        <div class="row justify-content-around">
            <div class="col box">
                <div class="row justify-content-between align-items-center">
                    <div class="col-5 box-item">
                        <h3>Numero de usuarios</h3>
                    </div>
                    <div class="col-7 box-item">
                        <div class="visits">{{userCount}}</div>
                        <h6>En la web</h6>
                    </div>
                </div>
            </div>

            <div class="col box">
                <div class="row justify-content-between align-items-center">
                    <div class="col-5 box-item">
                        <h3>Total de anuncios</h3>
                    </div>
                    <div class="col-7 box-item">
                        <div class="visits">{{adcount}}</div>
                        <h6>En la web</h6>
                    </div>
                </div>
            </div>
        </div>

        <!------------------------ Row 2 -------------------------->
        <div class="row justify-content-around">

            <!------------------------ Large box -------------------------->

            <div class="col-5 large-box">
                <div class="box-title"><strong>Ultimos anuncios creados</strong></div>
                <div class="row">
                    <div class="col large-box-content">
                        <div class="col large-box-item"  v-for="anuncio in ads" :key="anuncio.id">
                            <div class="row no-gutters">
                                <div class="col-1 align-self-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chat-dots" viewBox="0 0 16 16">
                                        <path d="M5 8a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm3 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2z"/>
                                        <path d="m2.165 15.803.02-.004c1.83-.363 2.948-.842 3.468-1.105A9.06 9.06 0 0 0 8 15c4.418 0 8-3.134 8-7s-3.582-7-8-7-8 3.134-8 7c0 1.76.743 3.37 1.97 4.6a10.437 10.437 0 0 1-.524 2.318l-.003.011a10.722 10.722 0 0 1-.244.637c-.079.186.074.394.273.362a21.673 21.673 0 0 0 .693-.125zm.8-3.108a1 1 0 0 0-.287-.801C1.618 10.83 1 9.468 1 8c0-3.192 3.004-6 7-6s7 2.808 7 6c0 3.193-3.004 6-7 6a8.06 8.06 0 0 1-2.088-.272 1 1 0 0 0-.711.074c-.387.196-1.24.57-2.634.893a10.97 10.97 0 0 0 .398-2z"/>
                                    </svg>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="line-text">{{anuncio.title}} <Link :href="route('anuncios.show', anuncio.id)">Ir al anuncio</Link></div>
                                        <div class="line-description">
                                            {{ moment(anuncio.created_at).format('DD/MM/YYYY [a las] HH:mm') }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-5 large-box">
                <div class="box-title"><strong>Ultimos usuarios creados</strong></div>
                <div class="row">
                    <div class="col large-box-content">
                        <div class="col large-box-item"  v-for="user in users" :key="user.id">
                            <div class="row no-gutters">
                                <div class="col-1 align-self-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chat-dots" viewBox="0 0 16 16">
                                        <path d="M5 8a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm3 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2z"/>
                                        <path d="m2.165 15.803.02-.004c1.83-.363 2.948-.842 3.468-1.105A9.06 9.06 0 0 0 8 15c4.418 0 8-3.134 8-7s-3.582-7-8-7-8 3.134-8 7c0 1.76.743 3.37 1.97 4.6a10.437 10.437 0 0 1-.524 2.318l-.003.011a10.722 10.722 0 0 1-.244.637c-.079.186.074.394.273.362a21.673 21.673 0 0 0 .693-.125zm.8-3.108a1 1 0 0 0-.287-.801C1.618 10.83 1 9.468 1 8c0-3.192 3.004-6 7-6s7 2.808 7 6c0 3.193-3.004 6-7 6a8.06 8.06 0 0 1-2.088-.272 1 1 0 0 0-.711.074c-.387.196-1.24.57-2.634.893a10.97 10.97 0 0 0 .398-2z"/>
                                    </svg>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="line-text">{{user.name}} <span><Link :href="route('profiles.show',user.id)">Ir al perfil</Link></span></div>
                                        <div class="line-description">
                                            {{ moment(user.created_at).format('DD/MM/YYYY [a las] HH:mm') }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            </div>
        </div>

</template>

<script>
import FrontLayout from "../Layouts/FrontLayout";
import Label from "../Jetstream/Label";
import {Link} from "@inertiajs/inertia-vue3";
import {Inertia} from "@inertiajs/inertia";
import moment from "moment";

export default {
    name: "DashboardGrid",
    components: {Label, Link},
    props: {
        userCount: Number,
        adcount: Number,
        ads: Object,
        users: Object
    },
    created: function () {
        this.moment = moment;
    },
}
</script>

<style scoped>
/*body{*/
/*    font-family: Gotham Narrow;*/
/*    font-size: 20px;*/
/*}*/
a{
    color:#434441;

}
.dashboard-container {
    padding:10px;
}

/*boxes*/
.box, .large-box, .large-box-item, .small-box {
    border: 1px solid #43444110;
    background: white;
    border-radius: 5px;
    height: auto;
    margin-bottom: 20px;
    margin-right: 20px;
    box-shadow: 3px 5px #43444115;
}
.box-item{
    /*margin-top:10px;*/
    font-size:55px;
    text-align: center;
}
.box-title{
    padding:15px;
    font-size:18px;
}
.line-text{
    font-size: 15px;
}

.line-description{
    font-size:12px;
    opacity: 0.7;
}

.visits{
    font-size:60px;
    opacity: 0.7;
    margin-bottom: -15px;
}

.quote{
    padding: 5px;
    font-style: italic;
    opacity: 0.8;
}

/*large box*/
.large-box{
    height:400px;
}

.large-box-content{
    height:320px;
    overflow-y: scroll;
}
.large-box-item{
    border: 1px solid #43444120;
    border-radius:10px;
    padding: 5px;
    margin-bottom: 5px;

}

.small-box> .box-title{
    padding:5px;
}


/* custom scrollbar css */

/* width */
.large-box-content::-webkit-scrollbar{
    width: 5px;
}
.large-box-content:hover::-webkit-scrollbar{
    width: 8px;
}

/* Track */
.large-box-content::-webkit-scrollbar-track{
    box-shadow: inset 0 0 2px #43444125;
    border-radius: 10px;
}

/* Handle */
.large-box-content::-webkit-scrollbar-thumb{
    background: #43444170;
    border-radius: 10px;
}

/* Handle on hover */
.large-box-content:hover::-webkit-scrollbar-thumb {
    background: #43444190;
}

/* charts */
div#cc1 {
    width: 100%;
    height: 150px;
}
.all-elements rect{
    fill:transparent;
    font-size:20px;

}
</style>
