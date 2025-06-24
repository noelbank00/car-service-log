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
        <div class="w-full scroll-auto">
            <div class="relative overflow-x-auto">
                <table class="w-full text-left text-sm text-gray-500 rtl:text-right dark:text-gray-400">
                    <thead class="bg-gray-50 text-xs text-gray-700 uppercase dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th class="px-6 py-3">Ügyfél azonosító</th>
                            <th class="px-6 py-3">Név</th>
                            <th class="px-6 py-3">Okmányazonosító</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            class="border-b border-gray-200 bg-white dark:border-gray-700 dark:bg-gray-800"
                            v-for="client in clients"
                            :key="client.id"
                        >
                            <td class="px-6 py-4 font-medium whitespace-nowrap text-gray-900 dark:text-white">
                                {{ client.id }}
                            </td>
                            <td class="px-6 py-4 font-medium whitespace-nowrap text-gray-900 dark:text-white">
                                {{ client.name }}
                            </td>
                            <td class="px-6 py-4 font-medium whitespace-nowrap text-gray-900 dark:text-white">
                                {{ client.card_number }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>
