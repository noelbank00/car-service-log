<script setup lang="ts">
import ClientSearch from '@/components/client/ClientSearch.vue';
import ClientSearchResult from '@/components/client/ClientSearchResult.vue';
import ClientsTable from '@/components/client/ClientsTable.vue';
import { type AppPageProps } from '@/types';
import type { Client } from '@/types/model';
import { Head, router, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

type Props = AppPageProps<{
    clients: {
        data: Client[];
    };
    search?: {
        name: string;
        card_number: string;
    };
    error?: string;
}>;

const page = usePage<Props>();
const clients = computed(() => page.props.clients.data);
const serverError = computed(() => page.props.error);

const hasActiveSearch = computed(() => {
    const search = page.props.search;

    return Boolean((search?.name && search.name.trim() !== '') || (search?.card_number && search.card_number.trim() !== ''));
});

const searchResult = computed(() => {
    if (hasActiveSearch.value && clients.value.length === 1 && !serverError.value) {
        return clients.value[0];
    }
    return null;
});

const handleSearch = (searchData: { name?: string; card_number?: string }) => {
    router.get('/', searchData, {
        preserveState: true,
        preserveScroll: true,
    });
};

const handleClearSearch = () => {
    router.get('/', {}, {
        preserveState: true,
        preserveScroll: true,
    });
};
</script>

<template>
    <Head title="Dashboard" />
    <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
        <ClientSearch
            :search="page.props.search"
            :error="serverError"
            :has-active-search="hasActiveSearch"
            @search="handleSearch"
            @clear="handleClearSearch"
        />

        <ClientsTable :clients="clients" />

        <ClientSearchResult
            v-if="searchResult"
            :client="searchResult"
        />
    </div>
</template>