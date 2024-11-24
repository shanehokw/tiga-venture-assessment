<script>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import LoadingButton from '@/Shared/LoadingButton.vue';
import TextInput from '@/Shared/TextInput.vue';

export default {
    components: {
        LoadingButton,
        TextInput,
    },
    layout: AuthenticatedLayout,
    props: {
        task: Object,
    },
    remember: 'form',
    data() {
        return {
            form: this.$inertia.form({
                name: this.task.name,
                description: this.task.description,
                due_date: this.task.due_date,
            }),
        };
    },
    methods: {
        update() {
            this.form.put(`/task/${this.task.id}`);
        },
    },
};
</script>

<template>
    <div>
        <Head :title="form.name" />
        <div class="mt-3 flex justify-center">
            <div class="w-4/5 rounded-2xl bg-white p-4">
                <h1 class="mb-8 text-3xl font-bold">
                    <a class="text-gray-400 hover:text-gray-600" href="/task"
                        >Tasks</a
                    >
                    <span class="font-medium text-gray-400">/</span>
                    {{ form.name }}
                </h1>
                <div class="w-full overflow-hidden rounded-md bg-white shadow">
                    <form @submit.prevent="update">
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
                            class="flex items-center border-t border-gray-100 bg-gray-50 px-8 py-4"
                        >
                            <loading-button
                                :loading="form.processing"
                                class="ml-auto"
                                type="submit"
                                >Save</loading-button
                            >
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>
