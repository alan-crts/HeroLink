<script setup>
const emits = defineEmits(['update-latitude', 'update-longitude'])
const getLocation = () => {
    window.navigator.geolocation
        .getCurrentPosition(
            (position) => {
                emits('update-latitude', position.coords.latitude);
                emits('update-longitude', position.coords.longitude);
            },
            (error) => {
                console.log(error);
            },
            {
                enableHighAccuracy: true,
                timeout: 5000,
                maximumAge: 0,
            }
        )
}
</script>


<template>
    <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" @click="getLocation" type="button">Get Location</button>
</template>
