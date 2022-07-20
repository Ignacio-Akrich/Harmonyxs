<template>
    <app-layout title="Administración de usuarios">
        <template #header>
            <h2 class="h4 font-weight-bold">
                Administración de usuarios, roles y permisos
            </h2>
        </template>
        <div class="container-fluid">
            Busca usuarios por su nombre:
            <input type="search" aria-label="Buscar" placeholder="Nombre de artista o banda" v-model="params.search" class="form-control">
            <FilterUsers/>
            <!-- Tabla usuarios -->
            <table id="listausuarios" class="table bg-primary-50 table-striped table-hover table-bordered my-3 align-middle">
                <thead class="text-bold">
                    <th class="py-2 col-1 col-sm-1 sortable" @click="sort('id')">
                        <span>ID
                            <span v-if="params.field === 'id' && params.direction === 'asc'">&#8593;</span>
                            <span v-if="params.field === 'id' && params.direction === 'desc'">&#8595;</span>
                        </span>
                    </th>
                    <th class="py-2 col-2 col-sm-2 sortable" @click="sort('name')">
                        <span>Nombre
                            <span v-if="params.field === 'name' && params.direction === 'asc'">&#8593;</span>
                            <span v-if="params.field === 'name' && params.direction === 'desc'">&#8595;</span>
                        </span>
                    </th>
                    <th class="py-2 col-5 col-sm-3 sortable" @click="sort('email')">
                        <span>Email
                            <span v-if="params.field === 'email' && params.direction === 'asc'">&#8593;</span>
                            <span v-if="params.field === 'email' && params.direction === 'desc'">&#8595;</span>
                        </span>
                    </th>
                    <th class="py-2 col-2 col-sm-2">
                        <span>Roles
                            <span v-if="params.field === 'roles' && params.direction === 'asc'">&#8593;</span>
                            <span v-if="params.field === 'roles' && params.direction === 'desc'">&#8595;</span>
                        </span>
                    </th>
                    <th class="py-2 col-2 d-none d-sm-table-cell sortable" @click="sort('created_at')">
                        <span>Fecha de registro
                            <span v-if="params.field === 'created_at' && params.direction === 'asc'">&#8593;</span>
                            <span v-if="params.field === 'created_at' && params.direction === 'desc'">&#8595;</span>
                        </span>
                    </th>
                    <th class="py-2 col-2 col-sm-2"><span class="">Acciones</span></th>
                </thead>
                <tbody>
                    <tr v-for="usuario in users.data" :key="usuario.id">
                        <!-- Usuario -->
                        <td class="py-2">{{ usuario.id }}</td>
                        <td class="py-2 text-break">{{ usuario.name }}</td>
                        <td class="py-2 text-break">{{ usuario.email }}</td>
                        <td class="py-2">
                            <div v-for="rol in usuario.roles" :key="rol.id">{{ rol.name }}</div>
                        </td>
                        <td class="py-2 d-none d-sm-table-cell">{{ moment(usuario.created_at).format('DD/MM/YYYY [a las] HH:mm') }}</td>
                        <td class="py-2">
                            <Link class="btn btn-warning" :href="route('usuarios.edit', usuario.id)" as="button" customtip="Editar">
                                <i class="fas fa-user-edit"></i>
                            </Link>
                            <button type="button" @click="selectedUser=usuario" class="btn btn-danger mx-2"  customtip="Eliminar" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                        <!-- Fin usuario -->
                    </tr>
                </tbody>
            </table>
            <!-- Fin tabla usuarios -->
            <pagination class="mt-4" :links="users.links" />

            <!-- Modal -->
            <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="staticBackdropLabel">Eliminar usuario</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p v-if="selectedUser">¿Seguro que quieres eliminar el usuario <strong> {{selectedUser.name}} </strong>?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Cerrar</button>
                            <button type="button" class="btn btn-secondary text-white" data-bs-dismiss="modal" @click="deleteUser(selectedUser)">Eliminar</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </app-layout>
</template>

<script>
import {Inertia} from "@inertiajs/inertia";
import { Link } from '@inertiajs/inertia-vue3';
import Pagination from '@/Components/Pagination';
import AppLayout from "@/Layouts/AppLayout.vue";
import FilterUsers from '@/Components/FilterUsers.vue';
import { pickBy } from 'lodash';
import { throttle } from 'lodash';

export default {
    props: {
        users: Object,
        filters: Object,
    },
    data() {
        return {
            selectedUser: Object,
            params: {
                search: this.filters.search,
                field: this.filters.field,
                direction: this.filters.direction,
                roles: this.filters.roles
            }
        }
    },
    components: {
		Pagination,
        AppLayout,
        Link,
        FilterUsers,
    },
    methods: {
        deleteUser: function (selectedUser) {
            Inertia.delete(route("usuarios.destroy", selectedUser))
        },
        sort(field) {
            this.params.field = field;
            this.params.direction = this.params.direction === 'asc' ? 'desc' : 'asc';
        }
    },
    created: function () {
        this.moment = moment;
    },
    // Watch se encarga de actualizar la url a tiempo real para hacer las queries por título a los usuarios.
    // Limitamos a una petición cada 1000 ms con throttle para no cargar en exceso al servidor
    watch: {
        params: {
            handler: throttle(function() {  
                let params = pickBy(this.params); // Si el campo de búsqueda está vacío, se limpia de la url
                this.$inertia.get(this.route("usuarios.index"), params, {replace: true, preserveState: true});
            }, 1000),
        
            deep: true,
        }
    }
}
</script>
