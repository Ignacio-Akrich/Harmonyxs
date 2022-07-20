<template>
  <div class="row justify-content-center my-5">
    <div class="col-md-12">
      <div class="card shadow bg-light">
        <div class="card-body bg-white px-3 py-3 border-bottom rounded-top">
          <div class="mx-3 my-3">
            <div class="mx-auto col-12 col-sm-6 col-md-4 col-lg-3 col-xl-2">
              <jet-application-logo />
            </div>

            <h3 class="h3 my-4">
              ¡Hola, {{ $page.props.user.name }}!
            </h3>

            <div class="text-muted">
              Estás en el panel de administración. Para gestionar a los usuarios de Harmonyxs, pincha en la pestaña "Usuarios registrados".
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import { defineComponent } from 'vue'
  import JetApplicationLogo from '@/Jetstream/ApplicationLogo.vue'

  export default defineComponent({
    components: {
      JetApplicationLogo,
    },
  })
</script>
