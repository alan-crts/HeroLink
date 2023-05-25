<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import Multiselect from '@vueform/multiselect'
import Map from '@/components/Map.vue'
import { Head, Link, useForm } from '@inertiajs/vue3';
import LocationButton from "@/Components/LocationButton.vue";

const form = useForm({
    name: '',
    phone: '',
    password: '',
    password_confirmation: '',
    latitude: '',
    longitude: '',
    incidents: [],
});
const props = defineProps({
    incidents: {
        type: Array
    },
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<style src="@vueform/multiselect/themes/default.css"></style>

<template>
    <GuestLayout>
        <Head title="Register" />

        <form @submit.prevent="submit">
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
                    placeholder="Name"
                />

                <InputError class="mt-2" :message="form.errors.name" />
            </div>

            <div class="mt-4">
                <InputLabel for="phone" value="Phone" />

                <TextInput
                    id="phone"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.phone"
                    required
                    autocomplete="phone"
                    placeholder="Phone"
                />

                <InputError class="mt-2" :message="form.errors.phone" />
            </div>
            <div class="mt-4">
                    <InputLabel for="map" value="Map" />
                    <Map :center="{lat: form.latitude!=''?form.latitude:48.5, lng: form.longitude!=''?form.longitude:2.2}" :zoom="5" :marker="form.latitude!=''&&form.longitude!=''?{lat: form.latitude, lng: form.longitude}:null" @update-latitude="form.latitude = $event" @update-longitude="form.longitude = $event" ref="map" />
                    <LocationButton @update-latitude="form.latitude = $event" @update-longitude="form.longitude = $event" />
            </div>
            <div class="mt-4">
                <InputLabel for="latitude" value="Latitude" />

                <TextInput
                    id="latitude"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.latitude"
                    required
                    placeholder="latitude"
                />

                <InputError class="mt-2" :message="form.errors.latitude" />
            </div>

            <div class="mt-4">
                <InputLabel for="longitude" value="Longitude" />

                <TextInput
                    id="longitude"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.longitude"
                    required
                    placeholder="longitude"
                />

                <InputError class="mt-2" :message="form.errors.longitude" />
            </div>

            <div class="mt-4">
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
            <div class="mt-4">
                <InputLabel for="password" value="Password" />

                <TextInput
                    id="password"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.password"
                    required
                    autocomplete="new-password"
                    placeholder="Password"
                />

                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="mt-4">
                <InputLabel for="password_confirmation" value="Confirm Password" />

                <TextInput
                    id="password_confirmation"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.password_confirmation"
                    required
                    autocomplete="new-password"
                    placeholder="Confirm Password"
                />

                <InputError class="mt-2" :message="form.errors.password_confirmation" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <Link
                    :href="route('login')"
                    class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                >
                    Already registered?
                </Link>

                <PrimaryButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Register
                </PrimaryButton>
            </div>
        </form>
    </GuestLayout>
</template>

