<script setup lang="ts">
import type { Client } from '@/types/model';
import { computed } from 'vue';

interface Props {
    client: Client;
}

const props = defineProps<Props>();

const totalServiceCount = computed(() => {
    return props.client.cars?.reduce((total, car) => {
        return total + (car.services?.length || 0);
    }, 0) || 0;
});
</script>

<template>
    <div class="w-full rounded-xl bg-white p-6 shadow">
        <h3 class="mb-4 text-lg font-semibold text-gray-900">Találat</h3>
        <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-5">
            <div>
                <p class="text-sm text-gray-600">Ügyfél azonosítója</p>
                <p class="font-medium text-gray-900">{{ client.id }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-600">Ügyfél neve</p>
                <p class="font-medium text-gray-900">{{ client.name }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-600">Ügyfél okmányazonosítója</p>
                <p class="font-medium text-gray-900">{{ client.card_number }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-600">Autóinak darabszáma</p>
                <p class="font-medium text-gray-900">{{ client.cars?.length || 0 }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-600">Összes szerviznapló bejegyzés</p>
                <p class="font-medium text-gray-900">{{ totalServiceCount }}</p>
            </div>
        </div>
    </div>
</template>