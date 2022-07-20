<template>
  <li :class="classes">
    <Link :href="href" :class="classactive">
      <slot></slot>
    </Link>
  </li>
</template>

<script>
  import { defineComponent } from 'vue'
  import { Link } from '@inertiajs/inertia-vue3'

  export default defineComponent({
    components: {
      Link,
    },
    
    props: ['href', 'active'],

    computed: {
      classes() {
        return this.active
            ? 'nav-item active nav-tab-active text-center px-3'
            : 'nav-item nav-tab-off text-center px-3'
      },
      classactive() {
        return this.active
            ? 'nav-link active'
            : 'nav-link'
      }
    }
  })
</script>
