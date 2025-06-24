<script setup lang="ts">
import { type AppPageProps } from '@/types';
import type { Client } from '@/types/model';
import { Head, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

type Props = AppPageProps<{
    clients: {
        data: Client[];
    };
}>;

const page = usePage<Props>();
const clients = computed(() => page.props.clients.data);
</script>

<template>
    <Head title="Dashboard" />
    <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
        <div class="w-full overflow-x-auto">
            <div class="min-w-full">
                <!-- Header -->
                <div class="grid grid-cols-3 bg-gray-50 text-xs text-gray-700 uppercase dark:bg-gray-700 dark:text-gray-400">
                    <div class="px-6 py-3">Ügyfél azonosító</div>
                    <div class="px-6 py-3">Név</div>
                    <div class="px-6 py-3">Okmányazonosító</div>
                </div>
                <!-- Rows -->
                <div
                    v-for="client in clients"
                    :key="client.id"
                    class="grid grid-cols-3 border-b border-gray-200 bg-white dark:border-gray-700 dark:bg-gray-800"
                >
                    <div class="px-6 py-4 font-medium whitespace-nowrap text-gray-900 dark:text-white">
                        {{ client.id }}
                    </div>
                    <div class="px-6 py-4 font-medium whitespace-nowrap text-gray-900 dark:text-white">
                        {{ client.name }}
                    </div>
                    <div class="px-6 py-4 font-medium whitespace-nowrap text-gray-900 dark:text-white">
                        {{ client.card_number }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
