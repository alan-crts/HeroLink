<script setup>
import { onMounted, ref } from 'vue';

defineProps({
    options: {
        type: String,
        required: true,
    },
    modelValue: {
        type: String,
        required: true,
    },
});

defineEmits(['update:modelValue']);

const input = ref(null);

defineExpose({ focus: () => input.value.focus() });

</script>

<template>
    <select
        class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
        ref="select"
        :value="modelValue"
        @input="$emit('update:modelValue', $event.target.value)"
    >
        <option value="" disabled>Select an option</option>
        <option v-for="value in options" :key="value.id" :value="value.id">{{ value.name }}</option>
    </select>
</template>
