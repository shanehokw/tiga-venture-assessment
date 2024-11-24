<script lang="ts" setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Link } from '@inertiajs/vue3';

defineProps({ tasks: Object });
</script>

<template>
    <Head title="Tasks" />
    <AuthenticatedLayout>
        <div class="mt-3 flex justify-center">
            <div class="w-3/5 rounded-2xl bg-white p-4">
                <div class="flex flex-wrap gap-y-4 rounded-xl">
                    <h2 class="text-4xl">Your Tasks</h2>
                    <Link
                        v-for="task in tasks"
                        :key="task.id"
                        :href="`/task/${task.id}/edit`"
                        class="w-full rounded-xl"
                    >
                        {{ task.name }} - {{ task.status }}
                    </Link>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
