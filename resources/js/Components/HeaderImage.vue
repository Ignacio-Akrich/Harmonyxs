<template>
    <!-- Full Page Image Header with Vertically Centered Content -->
    <header class="masthead">
        <div class="container h-100">
            <div class="d-flex flex-column justify-content-center row h-100 align-items-center">
                <div class="col-11 col-sm-10 col-md-9 col-lg-8 text-center header-box py-5 px-2">
                    <SearchLocationForm/>
                </div>
            </div>
        </div>
    </header>
</template>

<script>
import SearchLocationForm from "./SearchLocationForm";
export default {
    name: "HeaderImage",
    components: {SearchLocationForm}
}
</script>

<style scoped>
.masthead {
    height: 100vh;
    min-height: 500px;
    background-image: url('../../img/home/disco.webp');
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
}

.header-box {
    background: rgb(37,42,52);
    background: linear-gradient(0deg, rgba(37,42,52,0.6786064767703957) 57%, rgba(37,42,52,0.68) 57%);
    border-radius: 5px;
}



</style>
