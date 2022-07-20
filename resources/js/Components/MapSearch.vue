<template>
    <div>
        <div>
            <GMapAutocomplete
                @place_changed='setPlace'
            />
            <button
                @click='addMarker'
            >
                Add
            </button>
        </div>
        <br>
<!--        <input type="hidden" v-model="formulario.lat" name="lat" id="lat">-->
<!--        <input type="hidden" v-model="formulario.lng" name="lng" id="lng">-->
        <gMapMap
            :center='center'
            :zoom='12'
            style='width:100%;  height: 400px;'
        >
            <GMapMarker
                :key="index"
                v-for="(m, index) in markers"
                :position="m.position"
                @click="center=m.position"
            />
        </gMapMap>
    </div>
</template>

<script>
export default {
    name: 'GoogleMap',
    props: {
        props: ['formulario']
    },

    data() {
        return {
            center: { lat: 40.4167, lng: -3.7035 },
            currentPlace: null,
            markers: [],
            places: [],
        }
    },
    mounted() {
        this.geolocate();
    },
    methods: {
        setPlace(place) {
            this.currentPlace = place;
        },
        addMarker() {
            if (this.currentPlace) {
                const marker = {
                    lat: this.currentPlace.geometry.location.lat(),
                    lng: this.currentPlace.geometry.location.lng(),
                };
                this.markers.push({ position: marker });
                this.places.push(this.currentPlace);
                this.center = marker;
                this.currentPlace = null;
            }
        },
        geolocate: function() {
            navigator.geolocation.getCurrentPosition(position => {
                this.center = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude,
                };
            });
        },
    },
};
</script>
