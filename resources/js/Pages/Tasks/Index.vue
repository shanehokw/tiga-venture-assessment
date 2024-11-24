<script lang="ts" setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { ChevronDownIcon, ChevronLeftIcon } from '@heroicons/vue/24/solid';

defineProps({ tasks: Object });
</script>

<template>
    <Head title="Tasks" />
    <AuthenticatedLayout>
        <div class="mt-3 flex justify-center">
            <div class="w-4/5 rounded-2xl bg-white p-4">
                <div class="flex flex-wrap gap-y-4 rounded-xl">
                    <div class="flex w-full justify-between">
                        <h2 class="text-4xl">Your Tasks</h2>
                        <a href="/task/create">Add</a>
                    </div>
                    <table class="min-w-full divide-y divide-gray-300">
                        <thead>
                            <tr>
                                <th
                                    scope="col"
                                    class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0"
                                >
                                    <a href="#" class="group inline-flex">
                                        Task
                                        <span
                                            class="invisible ml-2 flex-none rounded text-gray-400 group-hover:visible group-focus:visible"
                                        >
                                            <ChevronDownIcon
                                                class="size-5"
                                                aria-hidden="true"
                                            />
                                        </span>
                                    </a>
                                </th>
                                <th
                                    scope="col"
                                    class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0"
                                >
                                    <a href="#" class="group inline-flex">
                                        Description
                                        <span
                                            class="invisible ml-2 flex-none rounded text-gray-400 group-hover:visible group-focus:visible"
                                        >
                                            <ChevronDownIcon
                                                class="size-5"
                                                aria-hidden="true"
                                            />
                                        </span>
                                    </a>
                                </th>
                                <th
                                    scope="col"
                                    class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900"
                                >
                                    <a href="#" class="group inline-flex">
                                        Due Date
                                        <span
                                            class="ml-2 flex-none rounded bg-gray-100 text-gray-900 group-hover:bg-gray-200"
                                        >
                                            <ChevronDownIcon
                                                class="size-5"
                                                aria-hidden="true"
                                            />
                                        </span>
                                    </a>
                                </th>
                                <th
                                    scope="col"
                                    class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900"
                                >
                                    <a href="#" class="group inline-flex">
                                        Created Date
                                        <span
                                            class="invisible ml-2 flex-none rounded text-gray-400 group-hover:visible group-focus:visible"
                                        >
                                            <ChevronDownIcon
                                                class="invisible ml-2 size-5 flex-none rounded text-gray-400 group-hover:visible group-focus:visible"
                                                aria-hidden="true"
                                            />
                                        </span>
                                    </a>
                                </th>
                                <th
                                    scope="col"
                                    class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0"
                                >
                                    <a href="#" class="group inline-flex">
                                        Status
                                        <span
                                            class="invisible ml-2 flex-none rounded text-gray-400 group-hover:visible group-focus:visible"
                                        >
                                            <ChevronDownIcon
                                                class="size-5"
                                                aria-hidden="true"
                                            />
                                        </span>
                                    </a>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white">
                            <tr v-for="task in tasks" :key="task.id">
                                <td
                                    class="py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-0"
                                >
                                    {{ task.name }}
                                </td>
                                <td class="px-3 py-4 text-sm text-gray-500">
                                    {{ task.description }}
                                </td>
                                <td
                                    class="whitespace-nowrap px-3 py-4 text-sm text-gray-500"
                                >
                                    {{ task.due_date }}
                                </td>
                                <td
                                    class="whitespace-nowrap px-3 py-4 text-sm text-gray-500"
                                >
                                    {{ task.created_at }}
                                </td>
                                <td
                                    class="whitespace-nowrap px-3 py-4 text-sm text-gray-500"
                                >
                                    {{ task.status }}
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <div
                        class="flex items-center justify-between border-t border-gray-200 bg-white px-4 py-3 sm:px-6"
                    >
                        <div class="flex flex-1 justify-between sm:hidden">
                            <a
                                href="#"
                                class="relative inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50"
                                >Previous</a
                            >
                            <a
                                href="#"
                                class="relative ml-3 inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50"
                                >Next</a
                            >
                        </div>
                        <div
                            class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between"
                        >
                            <div>
                                <p class="text-sm text-gray-700">
                                    Showing
                                    {{ ' ' }}
                                    <span class="font-medium">1</span>
                                    {{ ' ' }}
                                    to
                                    {{ ' ' }}
                                    <span class="font-medium">10</span>
                                    {{ ' ' }}
                                    of
                                    {{ ' ' }}
                                    <span class="font-medium">97</span>
                                    {{ ' ' }}
                                    results
                                </p>
                            </div>
                            <div>
                                <nav
                                    class="isolate inline-flex -space-x-px rounded-md shadow-sm"
                                    aria-label="Pagination"
                                >
                                    <a
                                        href="#"
                                        class="relative inline-flex items-center rounded-l-md px-2 py-2 text-gray-400 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0"
                                    >
                                        <span class="sr-only">Previous</span>
                                        <ChevronLeftIcon
                                            class="size-5"
                                            aria-hidden="true"
                                        />
                                    </a>
                                    <!-- Current: "z-10 bg-indigo-600 text-white focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600", Default: "text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:outline-offset-0" -->
                                    <a
                                        href="#"
                                        aria-current="page"
                                        class="relative z-10 inline-flex items-center bg-indigo-600 px-4 py-2 text-sm font-semibold text-white focus:z-20 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                                        >1</a
                                    >
                                    <a
                                        href="#"
                                        class="relative inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0"
                                        >2</a
                                    >
                                    <a
                                        href="#"
                                        class="relative hidden items-center px-4 py-2 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0 md:inline-flex"
                                        >3</a
                                    >
                                    <span
                                        class="relative inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-700 ring-1 ring-inset ring-gray-300 focus:outline-offset-0"
                                        >...</span
                                    >
                                    <a
                                        href="#"
                                        class="relative hidden items-center px-4 py-2 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0 md:inline-flex"
                                        >8</a
                                    >
                                    <a
                                        href="#"
                                        class="relative inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0"
                                        >9</a
                                    >
                                    <a
                                        href="#"
                                        class="relative inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0"
                                        >10</a
                                    >
                                    <a
                                        href="#"
                                        class="relative inline-flex items-center rounded-r-md px-2 py-2 text-gray-400 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0"
                                    >
                                        <span class="sr-only">Next</span>
                                        <ChevronRightIcon
                                            class="size-5"
                                            aria-hidden="true"
                                        />
                                    </a>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
