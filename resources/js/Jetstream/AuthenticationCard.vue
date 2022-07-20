<template>
  <div class="container-fluid auth">
    <div class="row justify-content-center align-items-center vh-100">
      <div class="col-sm-12 col-md-12 col-lg-9" >
        <div>
          <slot name="logo" />
        </div>

        <div class="card mb-3" style="height:42rem;">
          <div class="row row-auth">
            <div class="col-lg-6 d-none d-lg-flex">
              <img src="../../img/login/login_img.webp" class="card-img-top card-auth rounded" alt="img" style="height:42rem;">
            </div>
            <div class="col-md-7 col-lg-6 col-10 d-flex align-items-center align-content-between">
              <div class="card-body">
                <slot />
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

