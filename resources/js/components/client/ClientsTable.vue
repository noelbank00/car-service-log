<script setup lang="ts">
import type { Client } from '@/types/model';
import { ref } from 'vue';
import ClientRow from './ClientRow.vue';

interface Props {
    clients: Client[];
}

defineProps<Props>();

const expandedClients = ref<Set<number>>(new Set());
const expandedCars = ref<Set<number>>(new Set());

const toggleClient = (clientId: number) => {
    if (expandedClients.value.has(clientId)) {
        expandedClients.value.delete(clientId);
    } else {
        expandedClients.value.add(clientId);
    }
};

const toggleCar = (carId: number) => {
    if (expandedCars.value.has(carId)) {
        expandedCars.value.delete(carId);
    } else {
        expandedCars.value.add(carId);
    }
};

const isExpanded = (clientId: number) => {
    return expandedClients.value.has(clientId);
};
</script>

<template>
    <div class="w-full overflow-x-auto rounded-xl">
        <div class="min-w-full">
            <!-- Header -->
            <div class="grid grid-cols-3 bg-gray-50 text-xs text-gray-700 uppercase">
                <div class="px-6 py-3">Ügyfél azonosító</div>
                <div class="px-6 py-3">Név</div>
                <div class="px-6 py-3">Okmányazonosító</div>
            </div>
            <!-- Rows -->
            <ClientRow
                v-for="client in clients"
                :key="client.id"
                :client="client"
                :is-expanded="isExpanded(client.id)"
                :expanded-cars="expandedCars"
                @toggle="toggleClient(client.id)"
                @toggle-car="toggleCar"
            />
        </div>
    </div>
</template>