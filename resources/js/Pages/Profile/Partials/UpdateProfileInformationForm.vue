<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import Multiselect from '@vueform/multiselect'
import { Link, useForm, usePage } from '@inertiajs/vue3';
import Map from "@/Components/Map.vue";
import LocationButton from "@/Components/LocationButton.vue";
const props = defineProps({
    status: {
        type: String,
    },
    incidents: {
        type: Array
    }
});

const user = usePage().props.auth.user;

const form = useForm({
    name: user.name,
    phone: user.phone,
    latitude: user.latitude,
    longitude: user.longitude,
    incidents: user.incidents.map(incident => incident.id)
});
</script>

<style src="@vueform/multiselect/themes/default.css"></style>

<template>
    <section>
        <header>
            <h2 class="text-lg font-medium text-gray-900">Profile Information</h2>

            <p class="mt-1 text-sm text-gray-600">
                Update your account's profile information and phone.
            </p>
        </header>

        <form @submit.prevent="form.patch(route('profile.update'))" class="mt-6 space-y-6">
            <div>
                <InputLabel for="name" value="Name" />

                <TextInput
                    id="name"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.name"
                    required
                    autofocus
                    autocomplete="name"
                />

                <InputError class="mt-2" :message="form.errors.name" />
            </div>

            <div>
                <InputLabel for="phone" value="Phone" />

                <TextInput
                    id="phone"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.phone"
                    required
                    autocomplete="phone"
                />

                <InputError class="mt-2" :message="form.errors.phone" />
            </div>

            <div>
                <InputLabel for="map" value="Map" />
                <Map :center="{lat: form.latitude, lng: form.longitude}" :marker="{lat: form.latitude, lng: form.longitude}" :zoom="5" @update-latitude="form.latitude = $event" @update-longitude="form.longitude = $event" ref="map" />
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
                <InputLabel for="incidents" value="Incidents" />

                <Multiselect v-model="form.incidents"
                             :native-support="true"
                             :name="'incidents'"
                             id="incidents"
                             mode="tags"
                             placeholder="Select your Incident(s)"
                             :create-option="true"
                             :max="3"
                             :close-on-select="false"
                             :options="incidents"
                />

                <InputError class="mt-2" :message="form.errors.incidents" />
            </div>

            <div class="flex items-center gap-4">
                <PrimaryButton :disabled="form.processing">Save</PrimaryButton>

                <Transition enter-from-class="opacity-0" leave-to-class="opacity-0" class="transition ease-in-out">
                    <p v-if="form.recentlySuccessful" class="text-sm text-gray-600">Saved.</p>
                </Transition>
            </div>
        </form>
    </section>
</template>
