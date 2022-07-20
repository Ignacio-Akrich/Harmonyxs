<template>
    <div>
        <NavBar/>
        <Head :title="title" />

        <!-- Page Content -->
        <main>
            <slot></slot>
        </main>
        <Footer/>
    </div>
</template>

<script>
import { Head, Link } from '@inertiajs/inertia-vue3'
import NavBar from "@/Components/NavBar"
import Footer from "@/Components/Footer"

export default {
    props: {
        title: String,
    },

    components: {
        Head,
        Link,
        NavBar,
        Footer
    },

    data() {
        return {
            showingNavigationDropdown: false,
        }
    },

    methods: {
        logout() {
            this.$inertia.post(route('logout'));
        },
    },

    computed: {
        path() {
            return window.location.pathname
        }
    }
}
</script>
