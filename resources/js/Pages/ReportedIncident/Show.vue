<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import Map from '@/components/Map.vue';

defineProps({
    incident: {
        type: Object
    },
    users: {
        type: Array
    }
});
</script>

<template>
    <Head title="Incident Details" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Incident Details</h2>
        </template>

        <div class="py-12 flex flex-col sm:justify-center items-center">
            <div class="w-full sm:max-w-xl mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
                <div class="mb-4">
                    <Map :center="{lat: incident.latitude, lng: incident.longitude}" :zoom="20" :marker="{lat: incident.latitude, lng: incident.longitude}" ref="map" />
                </div>
                <div class="mb-4">
                    <p class="text-lg font-semibold">Incident Details</p>
                    <p class="text-gray-600">City: {{ incident.city }}</p>
                    <p class="text-gray-600">Latitude: {{ incident.latitude }}</p>
                    <p class="text-gray-600">Longitude: {{ incident.longitude }}</p>
                    <p class="text-gray-600">Incident: {{ incident.incident.name }}</p>
                    <p class="text-gray-600">Created At: {{ new Date(incident.created_at).toLocaleString() }}</p>
                </div>
                <div>
                    <p class="text-lg font-semibold">Heroes Nearby (within 50km)</p>
                    <ul class="mt-2">
                        <li v-for="user in users" :key="user.id" class="mb-2">
                            <p class="text-gray-800">{{ user.name }}</p>
                            <p class="text-gray-600">{{ user.phone }}</p>
                        </li>
                    </ul>
                    <p v-if="users.length == 0" class="text-gray-600">No heroes found.</p>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
