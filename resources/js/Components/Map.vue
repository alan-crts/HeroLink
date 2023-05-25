<script setup>
import "leaflet/dist/leaflet.css"
import { LMap, LTileLayer, LMarker } from "@vue-leaflet/vue-leaflet"

const props = defineProps({
    zoom: {
        type: Number,
        default: 13
    },
    center: {
        type: Object,
        default: () => {
            return {
                lat: 48.5,
                lng: 2.2
            }
        }
    },
    marker: {
        type: Object,
        default: () => {
            return {
                lat: 48.5,
                lng: 2.2
            }
        }
    }
})

const mapReady = map => {
    map.on('click', addMarker)
}
const emit = defineEmits(['update-latitude', 'update-longitude'])
const addMarker = (e) => {
    const latLng = e.latlng
    emit('update-latitude', latLng.lat)
    emit('update-longitude', latLng.lng)
}

</script>

<template>
        <l-map ref="map" v-model:zoom="props.zoom" v-model:center="props.center" :useGlobalLeaflet="false" @ready="mapReady" style="height: 400px">
            <l-tile-layer url="https://tiles.stadiamaps.com/tiles/alidade_smooth_dark/{z}/{x}/{y}{r}.png"
                          layer-type="base"
                          name="Stadia Maps Basemap"></l-tile-layer>
            <l-marker v-if="props.marker" v-model:lat-lng="props.marker"></l-marker>
        </l-map>
</template>
