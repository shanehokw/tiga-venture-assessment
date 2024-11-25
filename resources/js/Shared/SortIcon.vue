<template>
    <span
        class="ml-2 flex-none rounded bg-gray-100 text-gray-900 group-hover:bg-gray-200"
    >
        <ChevronUpDownIcon
            v-if="
                filters.orderBy !== field ||
                (filters.orderDirection !== 'asc' &&
                    filters.orderDirection !== 'desc')
            "
            class="size-5"
            aria-hidden="true"
        />
        <ChevronUpIcon
            v-if="filters.orderBy === field && filters.orderDirection === 'asc'"
            class="size-5"
            aria-hidden="true"
        />
        <ChevronDownIcon
            v-if="
                filters.orderBy === field && filters.orderDirection === 'desc'
            "
            class="size-5"
            aria-hidden="true"
        />
    </span>
</template>

<script>
import {
    ChevronDownIcon,
    ChevronUpDownIcon,
    ChevronUpIcon,
} from '@heroicons/vue/24/solid';
export default {
    components: {
        ChevronDownIcon,
        ChevronUpIcon,
        ChevronUpDownIcon,
    },
    props: {
        field: String,
        filters: Object,
    },
};
</script>
