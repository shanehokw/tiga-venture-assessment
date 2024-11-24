<script lang="ts" setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

defineProps({ tasks: Object });
</script>

<template>
    <Head title="Tasks" />
    <AuthenticatedLayout>
        <div v-for="task in tasks" :key="task.id">
            {{ task.name }}
        </div>
    </AuthenticatedLayout>
</template>
