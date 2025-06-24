<script setup lang="ts">
import { type AppPageProps } from '@/types';
import type { Client } from '@/types/model';
import { Head, usePage } from '@inertiajs/vue3';
import { computed, ref } from 'vue';

type Props = AppPageProps<{
    clients: {
        data: Client[];
    };
}>;

const page = usePage<Props>();
const clients = computed(() => page.props.clients.data);
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

const isCarExpanded = (carId: number) => {
    return expandedCars.value.has(carId);
};
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
                    <div :class="'px-6 py-4 font-medium whitespace-nowrap text-gray-900 dark:text-white' + (client.cars && client.cars.length > 0 ? ' cursor-pointer' : ' cursor-not-allowed')"
                         @click="toggleClient(client.id)">
                        {{ client.id }}
                    </div>
                    <div class="px-6 py-4 font-medium whitespace-nowrap text-gray-900 dark:text-white cursor-pointer">
                        {{ client.name }}
                    </div>
                    <div class="px-6 py-4 font-medium whitespace-nowrap text-gray-900 dark:text-white">
                        {{ client.card_number }}
                    </div>

                    <div class="col-span-3 bg-gray-50 p-4 dark:bg-gray-900" v-if="isExpanded(client.id) && client.cars && client.cars.length > 0">
                        <div class="grid grid-cols-3 gap-2">
                            <div class="col-span-3 grid grid-cols-7 bg-gray-100 text-xs text-gray-600 uppercase dark:bg-gray-800 dark:text-gray-300">
                                <div class="px-4 py-2">Sorszám</div>
                                <div class="px-4 py-2">Típus</div>
                                <div class="px-4 py-2">Regisztráció időpontja</div>
                                <div class="px-4 py-2">Saját márkás-e?</div>
                                <div class="px-4 py-2">Balesetek száma</div>
                                <div class="px-4 py-2">Utolsó szervíz neve</div>
                                <div class="px-4 py-2">Utolsó szervíz időpontja</div>
                            </div>
                            <div v-for="car in client.cars" :key="'car_' + car.id" class="col-span-3">
                                <div class="grid grid-cols-7 bg-white dark:bg-gray-700">
                                    <div :class="'px-4 py-3 text-sm text-gray-900 dark:text-white' + (car.services && car.services.length > 0 ? ' cursor-pointer hover:underline' : ' cursor-not-allowed')"
                                         @click="toggleCar(car.id)">{{car.id}}</div>
                                    <div class="px-4 py-3 text-sm text-gray-900 dark:text-white">{{car.type}}</div>
                                    <div class="px-4 py-3 text-sm text-gray-900 dark:text-white">{{car.registered}}</div>
                                    <div class="px-4 py-3 text-sm text-gray-900 dark:text-white">{{car.ownbrand ? 'Igen' : 'Nem'}}</div>
                                    <div class="px-4 py-3 text-sm text-gray-900 dark:text-white">{{car.accidents}}</div>
                                    <div class="px-4 py-3 text-sm text-gray-900 dark:text-white">{{car.last_service_name ?? '-'}}</div>
                                    <div class="px-4 py-3 text-sm text-gray-900 dark:text-white">{{car.last_service_date ?? '-'}}</div>
                                </div>
                                
                                <div v-if="isCarExpanded(car.id) && car.services && car.services.length > 0" class="bg-gray-50 dark:bg-gray-800 p-4 ml-8">
                                    <div class="grid grid-cols-4 bg-gray-200 text-xs text-gray-600 uppercase dark:bg-gray-700 dark:text-gray-300">
                                        <div class="px-4 py-2">Naplószám</div>
                                        <div class="px-4 py-2">Esemény</div>
                                        <div class="px-4 py-2">Esemény időpontja</div>
                                        <div class="px-4 py-2">Dokumentum azonosító</div>
                                    </div>
                                    <div v-for="service in car.services" :key="'service_' + service.id" class="grid grid-cols-4 bg-white dark:bg-gray-600 border-b dark:border-gray-700">
                                        <div class="px-4 py-3 text-sm text-gray-900 dark:text-white">{{service.log_number}}</div>
                                        <div class="px-4 py-3 text-sm text-gray-900 dark:text-white">{{service.event}}</div>
                                        <div class="px-4 py-3 text-sm text-gray-900 dark:text-white">{{service.event_time}}</div>
                                        <div class="px-4 py-3 text-sm text-gray-900 dark:text-white">{{service.document_id}}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
