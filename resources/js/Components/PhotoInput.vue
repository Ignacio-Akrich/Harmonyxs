<template>
    <div>
        <div v-if="errorimageclient" class="text-danger">
            {{ errorimageclient }}
        </div>
        <input hidden type="file" accept="image/*" ref="file" @change="change">
        <div v-if="src" class="position-relative d-flex justify-content-center">
            <img :src="src" alt="No se pudo previsualizar" class="w-50">
            <div class="circle position-absolute top-50 start-50 translate-middle"></div>
            <div customtip="Cambiar foto" class="position-absolute top-50 start-50 translate-middle">
                <div type="button" class="iconbutton-light position-absolute top-50 start-50 translate-middle" @click="browse()"><i class="far fa-image"></i></div>
            </div>
        </div>
        <div v-else class="d-flex justify-content-center">
            <div type="button" class="btn btn-secondary text-white" @click="browse()">Subir imagen</div>
        </div>
    </div>

</template>

<script>
export default {
    name: "PhotoInput",
    props: {
        value: File,
        //defaultSrc: String En caso de querer poner una imagen por defecto
    },
    data() {
        return {
            src: null, //this.defaultSrc,
            file: null,
            errorimageclient: null
        }
    },
    methods: {
        browse() {
            this.$refs.file.click();
        },
        change(e) {
            const fileSize = e.target.files[0].size / 1024 / 1024;
            if (fileSize > 2) {
                this.src = null;
                this.errorimageclient = "Debes subir una imagen con tamaño inferior a 2 MB"
            } else {
                this.errorimageclient = null;
                this.$emit('update:modelValue', e.target.files[0]);
                let reader = new FileReader();
                reader.readAsDataURL(e.target.files[0]);
                reader.onload = (e) => {
                    this.src = e.target.result;
                }
            }
        }
    }
}
</script>

<style scoped>
.circle {
    height: 5em;
    width: 5em;
    background-color: rgba(0, 0, 0, 0.7);
    border-radius: 50%;
}

.iconbutton-light {
    font-size: 2.5em;
}

[customtip]:after {
    font-size: 1em;
}
</style>