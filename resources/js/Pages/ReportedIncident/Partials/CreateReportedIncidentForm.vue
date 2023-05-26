<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { useForm } from '@inertiajs/vue3';
import Map from "@/Components/Map.vue";
import LocationButton from "@/Components/LocationButton.vue";
import Selector from "@/Components/Selector.vue";
const props = defineProps({
    status: {
        type: String,
    },
    incidents: {
        type: Array
    }
});

const form = useForm({
    city: "",
    latitude: "",
    longitude: "",
    incident: ""
});

const submit = () => {
    form.post(route('reported_incident.store'), {
        onFinish: () => form.reset('city', 'latitude', 'longitude', 'incident'),
    });
};
</script>

<template>
    <section>
        <header>
            <h2 class="text-lg font-medium text-gray-900">Report an Incident</h2>

            <p class="mt-1 text-sm text-gray-600">
                Report an incident in your area for contact heroes.
            </p>
        </header>

        <form @submit.prevent="submit">
            <div>
                <InputLabel for="city" value="City" />

                <TextInput
                    id="name"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.city"
                    required
                    autofocus
                    autocomplete="name"
                />

                <InputError class="mt-2" :message="form.errors.city" />
            </div>

            <div>
                <InputLabel for="map" value="Map" />
                <Map :center="{lat: form.latitude!=''?form.latitude:48.5, lng: form.longitude!=''?form.longitude:2.2}" :marker="form.latitude!=''&&form.longitude!=''?{lat: form.latitude, lng: form.longitude}:null" :zoom="5" @update-latitude="form.latitude = $event" @update-longitude="form.longitude = $event" ref="map" />
                <LocationButton @update-latitude="form.latitude = $event" @update-longitude="form.longitude = $event" />
            </div>

            <div>
                <InputLabel for="latitude" value="Latitude" />

                <TextInput
                    id="latitude"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.latitude"
                    required
                    autocomplete="latitude"
                />

                <InputError class="mt-2" :message="form.errors.latitude" />
            </div>

            <div>
                <InputLabel for="longitude" value="Longitude" />

                <TextInput
                    id="longitude"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.longitude"
                    required
                    autocomplete="longitude"
                />

                <InputError class="mt-2" :message="form.errors.longitude" />
            </div>

            <div>
                <InputLabel for="incident" value="Incident" />

                <Selector
                    id="incident"
                    :options="incidents"
                    v-model="form.incident"
                    required
                />

                <InputError class="mt-2" :message="form.errors.incident" />
            </div>

            <div class="flex items-center justify-end mt-6">
                <PrimaryButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    <span v-if="form.processing">Submitting</span>
                    <span v-else>Submit</span>
                </PrimaryButton>
            </div>
        </form>
    </section>
</template>
