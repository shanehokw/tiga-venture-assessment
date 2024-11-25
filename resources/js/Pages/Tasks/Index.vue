<script lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import SortIcon from '@/Shared/SortIcon.vue';
import TextInput from '@/Shared/TextInput.vue';

import { pickBy } from 'lodash';

const searchParams = new URLSearchParams(window.location.search);

export default {
    components: {
        TextInput,
        SortIcon,
    },
    layout: AuthenticatedLayout,
    props: {
        tasks: Object,
    },
    data() {
        return {
            filters: {
                search: searchParams.get('search') ?? '',
                orderBy: searchParams.get('orderBy') ?? '',
                orderDirection: searchParams.get('orderDirection') ?? '',
            },
        };
    },
    methods: {
        index() {
            this.$inertia.get('/task', pickBy(this.filters), {
                preserveState: true,
            });
        },
        sort(field: string) {
            if (this.filters.orderBy === field) {
                this.filters.orderDirection =
                    this.filters.orderDirection === 'asc' ? 'desc' : 'asc';
            } else {
                this.filters.orderBy = field;
                this.filters.orderDirection = 'asc';
            }

            this.index();
        },
    },
};
</script>

<template>
    <Head title="Tasks" />
    <div class="mt-3 flex justify-center">
        <div class="w-4/5 rounded-2xl bg-white p-4">
            <div class="flex flex-wrap gap-y-4 rounded-xl">
                <div class="flex w-full justify-between">
                    <text-input
                        v-model="filters.search"
                        class="w-full"
                        placeholder="Search your tasks"
                    />
                    <button @click="index" class="bg-blue-700 px-2 text-white">
                        Search
                    </button>
                </div>
                <div class="flex w-full justify-between">
                    <h2 class="text-4xl">Your Tasks</h2>
                    <a href="/task/create">Add</a>
                </div>
                <table class="min-w-full divide-y divide-gray-300">
                    <thead>
                        <tr>
                            <th
                                scope="col"
                                class="py-3.5 text-left text-sm font-semibold text-gray-900"
                            >
                                Task
                            </th>
                            <th
                                scope="col"
                                class="py-3.5 text-left text-sm font-semibold text-gray-900"
                            >
                                Description
                            </th>
                            <th
                                scope="col"
                                class="cursor-pointer py-3.5 text-left text-sm font-semibold text-gray-900"
                                @click="sort('due_date')"
                            >
                                <div class="flex">
                                    <span> Due Date </span>
                                    <sort-icon
                                        :field="'due_date'"
                                        :filters="filters"
                                    ></sort-icon>
                                </div>
                            </th>
                            <th
                                scope="col"
                                class="cursor-pointer py-3.5 text-left text-sm font-semibold text-gray-900"
                                @click="sort('created_at')"
                            >
                                <div class="flex">
                                    <span> Created Date </span>
                                    <sort-icon
                                        :field="'created_at'"
                                        :filters="filters"
                                    ></sort-icon>
                                </div>
                            </th>
                            <th
                                scope="col"
                                class="py-3.5 text-left text-sm font-semibold text-gray-900"
                            >
                                Status
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white">
                        <tr v-for="task in tasks" :key="task.id">
                            <td
                                class="py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-0"
                            >
                                <a v-bind:href="`/task/${task.id}/edit`">
                                    {{ task.name }}
                                </a>
                            </td>
                            <td class="px-3 py-4 text-sm text-gray-500">
                                <a v-bind:href="`/task/${task.id}/edit`">
                                    {{ task.description }}
                                </a>
                            </td>
                            <td
                                class="whitespace-nowrap px-3 py-4 text-sm text-gray-500"
                            >
                                <a v-bind:href="`/task/${task.id}/edit`">
                                    {{ task.due_date }}
                                </a>
                            </td>
                            <td
                                class="whitespace-nowrap px-3 py-4 text-sm text-gray-500"
                            >
                                <a v-bind:href="`/task/${task.id}/edit`">
                                    {{ task.created_at }}
                                </a>
                            </td>
                            <td
                                class="whitespace-nowrap px-3 py-4 text-sm text-gray-500"
                            >
                                <a v-bind:href="`/task/${task.id}/edit`">
                                    {{ task.status }}
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>
