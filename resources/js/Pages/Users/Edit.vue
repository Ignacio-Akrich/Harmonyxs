<template>
    <app-layout title="Editar usuario">
        <template #header>
            <h2 class="h4 font-weight-bold">
                Editar usuario
            </h2>
        </template>
        <div class="container-fluid">
            <main>
                
                <form @submit.prevent="submit">
                    <div>
                        <label for="name">Nombre</label>
                        <input
                            id="name"
                            type="text"
                            v-model="form.name"
                            class="form-control"
                        />
                        <div v-if="errors.name" class="text-danger">{{ errors.name }}</div>
                    </div>
                    <div class="mt-4">
                        <label for="roles">Descripción</label>
                        <textarea id="roles" 
                            type="text" 
                            class="form-control" 
                            v-model="form.description" 
                            aria-label="Cambiar la descripción">
                        </textarea>
                        <div v-if="errors.description" class="text-danger">{{ errors.description }}</div>
                    </div>
                    <div class="mt-4">
                        <label for="roles">Cambiar de rol</label>
                        <select id="roles" class="form-select" v-model="form.roles" aria-label="Cambiar de rol">
                            <option value="Artista">Artista</option>
                            <option value="Banda">Banda</option>
                            <option value="Super Admin">Super Admin</option>
                        </select>
                        <div v-if="errors.roles" class="text-danger">{{ errors.roles }}</div>
                    </div>
                    <!-- <div class="mt-4">
                        <label for="instrumento">Instrumento</label>
                        <input
                            id="instrumento"
                            type="text"
                            v-model="form.instrumento"
                            class="form-control"
                        />
                        <div v-if="errors.instrumento" class="text-danger">{{ errors.instrumento }}</div>
                    </div> -->
                    
                    <!-- submit -->
                    <div class="flex items-center mt-4">
                        <button class="btn btn-primary">
                            Guardar
                        </button>
                    </div>
                </form>

            </main>

        </div>
    </app-layout>
</template>

<script setup>
const props = defineProps({
    usuarios: Object,
    errors: Object
});
const form = useForm({
    name: props.usuarios.name,
    description: props.usuarios.description,
    // instrumento: props.usuarios.instrumento,
    roles: props.usuarios.roles.name,
});
function submit() {
    Inertia.post(`/administracion/usuarios/${props.usuarios.id}`, {
    _method: 'put',
    name: form.name,
    description: form.description,
    // instrumento: form.instrumento,
    roles: form.roles,
})
}

</script>

<script>
import { Link, useForm } from '@inertiajs/inertia-vue3';
import AppLayout from "@/Layouts/AppLayout.vue";
import { Inertia } from '@inertiajs/inertia';
export default {
    props: {
        usuarios: Object,
        errors: Object
    },
    setup() {
        const form = useForm({
            name: null,
            description: null,
            roles: null
        });
        function submit() {
            Inertia.post(`/usuarios/${props.usuarios.id}`, {
            _method: 'put',
            name: form.name,
            description: form.description,
            roles: form.roles,
        })}

        return { form, submit };
    },
    /* data() {
        
    }, */
    components: {
        AppLayout,
        Link
    },
    methods: {
        
    },
}
</script>