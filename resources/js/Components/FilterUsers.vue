<template>
    <div class="card">
        <div class="card-header">
            Filtra tu búsqueda
        </div>
        <div class="card-body">
            <form @submit.prevent="submit">
                <div class="card-text">
                    <div class="h5 mb-3">Tipo de usuario</div>

                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" value="Artista" id="inlineRadio1" v-model="form.roles">
                        <label class="form-check-label" for="inlineRadio1">Artistas</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" value="Banda" id="inlineRadio2" v-model="form.roles">
                        <label class="form-check-label" for="inlineRadio2">Bandas</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" value="Super Admin" id="inlineRadio3" v-model="form.roles">
                        <label class="form-check-label" for="inlineRadio3">Super Admins</label>
                    </div>

                    <a href="#" class="btn btn-primary mx-3" @click="submit()">Buscar</a>
                </div>
            </form>
        </div>

    </div>
</template>

<script>
import {Inertia} from "@inertiajs/inertia";

export default {
    name: "FilterUsers",
    data() {
        return {
            form: {
                roles: '',
            },
        }
    },
    methods: {
        async submit() {
            Inertia.get(route('usuarios.index', this.form))
        },
    },
}
</script>

<style scoped>

</style>
