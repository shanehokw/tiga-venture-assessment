<script lang="ts">
import TextInput from '@/Shared/TextInput.vue';
import LoadingButton from '@/Shared/LoadingButton.vue';

export default {
    components: {
        TextInput,
    },
    remember: 'form',
    data() {
        return {
            form: this.$inertia.form({
                name: null,
                description: null,
                due_date: null,
            }),
        };
    },
    methods: {
        store() {
            this.form.post('/task');
        },
    },
};
</script>
<script lang="ts" setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
</script>
<template>
    <div>
        <Head title="Create Task" />
        <AuthenticatedLayout>
            <div class="mt-3 flex justify-center">
                <div class="w-4/5 rounded-2xl bg-white p-4">
                    <h1 class="mb-8 text-3xl font-bold">
                        <a
                            class="text-gray-400 hover:text-gray-600"
                            href="/task"
                            >Tasks</a
                        >
                        <span class="font-medium text-gray-400">/</span> Create
                    </h1>
                    <div
                        class="w-full overflow-hidden rounded-md bg-white shadow"
                    >
                        <form @submit.prevent="store">
                            <div class="flex flex-wrap p-8">
                                <text-input
                                    v-model="form.name"
                                    :error="form.errors.name"
                                    class="w-full pb-8 pr-6"
                                    label="Name"
                                />
                                <text-input
                                    v-model="form.description"
                                    :error="form.errors.description"
                                    class="w-full pb-8 pr-6"
                                    label="Description"
                                />
                                <text-input
                                    v-model="form.due_date"
                                    :error="form.errors.due_date"
                                    class="w-full pb-8 pr-6"
                                    label="Due date"
                                    :placeholder="'dd/mm/yyyy'"
                                />
                            </div>
                            <div
                                class="flex items-center justify-end border-t border-gray-100 bg-gray-50 px-8 py-4"
                            >
                                <loading-button
                                    :loading="form.processing"
                                    type="submit"
                                    >Create Task</loading-button
                                >
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    </div>
</template>
