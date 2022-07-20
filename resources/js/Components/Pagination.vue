<template>
    <div v-if="links.length > 3">
        <ul class="pagination flex-wrap">
            <template v-for="(link, key) in links" :key="key">
            <!-- <div v-if="key === 0 || links[key].active || key === links.length-1"> -->
                <div
                    v-if="link.url === null"
                    class="page-item border bg-white mb-1 px-4 py-2"
                    :class="{'rounded-pill-custom-left': key === 0, 'rounded-pill-custom-right': key === links.length-1}"
                    v-html="link.label"
                />

                <Link
                    v-else
                    class="page-link mb-1 px-4 py-2"
                    :class="{'bg-primary-800': link.active, 'rounded-pill-custom-left': key === 0, 'rounded-pill-custom-right': key === links.length-1}"
                    :href="link.url"
                    v-html="link.label"
                />
            <!-- </div> -->
            </template>
        </ul>
    </div>
</template>

<style scoped>
    .rounded-pill-custom-left {
        border-radius: 1rem 0 0 1rem;
    }
    .rounded-pill-custom-right {
        border-radius: 0 1rem 1rem 0;
    }
</style>
<script>
import { defineComponent } from "vue";
import { Link } from "@inertiajs/inertia-vue3";
export default defineComponent({
    components: {
        Link,
    },
    props: {
        links: Array,
    },
});
</script>