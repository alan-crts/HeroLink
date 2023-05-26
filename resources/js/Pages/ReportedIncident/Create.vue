<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import CreateReportedIncidentForm from "@/Pages/ReportedIncident/Partials/CreateReportedIncidentForm.vue";

defineProps({
    status: {
        type: String,
    },
    incidents: {
        type: Array
    }
});
</script>

<template>
    <Head title="Report an Incident" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Report an Incident</h2>
        </template>

        <div class="py-12 flex flex-col sm:justify-center items-center">
            <div class="w-full sm:max-w-xl mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
                <CreateReportedIncidentForm :status="status" :incidents="incidents" class="max-w-xl" />
            </div>
        </div>
    </AuthenticatedLayout>
</template>
