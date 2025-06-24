<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { type AppPageProps } from '@/types';
import type { Client } from '@/types/model';
import { Head, router, usePage } from '@inertiajs/vue3';
import { computed, ref } from 'vue';

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
const expandedClients = ref<Set<number>>(new Set());
const expandedCars = ref<Set<number>>(new Set());

const searchForm = ref({
    name: page.props.search?.name || '',
    card_number: page.props.search?.card_number || '',
});

const searchErrors = ref<{
    name?: string;
    card_number?: string;
    general?: string;
}>({});

const serverError = computed(() => page.props.error);

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

const validateSearch = () => {
    searchErrors.value = {};

    const hasName = searchForm.value.name.trim() !== '';
    const hasCardNumber = searchForm.value.card_number.trim() !== '';

    if (!hasName && !hasCardNumber) {
        searchErrors.value.general = 'Legalább az egyik mező kitöltése kötelező';
        return false;
    }

    if (hasName && hasCardNumber) {
        searchErrors.value.general = 'Csak az egyik mező tölthető ki egyszerre';
        return false;
    }

    if (hasCardNumber) {
        const cardNumberRegex = /^\d+$/;
        if (!cardNumberRegex.test(searchForm.value.card_number)) {
            searchErrors.value.card_number = 'Az okmányazonosító csak betűket és számokat tartalmazhat';
            return false;
        }
    }

    return true;
};

const handleSearch = () => {
    if (!validateSearch()) {
        return;
    }

    router.get(
        '/',
        {
            name: searchForm.value.name || undefined,
            card_number: searchForm.value.card_number || undefined,
        },
        {
            preserveState: true,
            preserveScroll: true,
        },
    );
};

const clearSearch = () => {
    searchForm.value.name = '';
    searchForm.value.card_number = '';
    searchErrors.value = {};

    router.get(
        '/',
        {},
        {
            preserveState: true,
            preserveScroll: true,
        },
    );
};

const hasActiveSearch = computed(() => {
    const search = page.props.search;
    return (search?.name && search.name.trim() !== '') || (search?.card_number && search.card_number.trim() !== '');
});

const searchResult = computed(() => {
    if (hasActiveSearch.value && clients.value.length === 1 && !serverError.value) {
        return clients.value[0];
    }
    return null;
});

const totalServiceCount = computed(() => {
    if (!searchResult.value) return 0;
    return (
        searchResult.value.cars?.reduce((total, car) => {
            return total + (car.services?.length || 0);
        }, 0) || 0
    );
});
</script>

<template>
    <Head title="Dashboard" />
    <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
        <!-- Search Form -->
        <div class="w-full rounded-lg bg-white p-6 shadow">
            <h2 class="mb-4 text-lg font-semibold text-gray-900">Ügyfél keresése</h2>
            <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                <div>
                    <Label htmlFor="name">Ügyfél neve</Label>
                    <Input id="name" v-model="searchForm.name" type="text" placeholder="Név" :class="searchErrors.name ? 'border-red-500' : ''" />
                    <p v-if="searchErrors.name" class="mt-1 text-sm text-red-500">{{ searchErrors.name }}</p>
                </div>
                <div>
                    <Label htmlFor="card_number">Ügyfél okmányazonosítója</Label>
                    <Input
                        id="card_number"
                        v-model="searchForm.card_number"
                        type="text"
                        placeholder="Okmányazonosító"
                        :class="searchErrors.card_number ? 'border-red-500' : ''"
                    />
                    <p v-if="searchErrors.card_number" class="mt-1 text-sm text-red-500">{{ searchErrors.card_number }}</p>
                </div>
                <div class="flex items-end">
                    <Button @click="handleSearch" class="w-full">Keresés</Button>
                </div>
            </div>
            <p v-if="searchErrors.general" class="mt-2 text-sm text-red-500">{{ searchErrors.general }}</p>
            <p v-if="serverError" class="mt-2 text-sm text-red-500">{{ serverError }}</p>

            <!-- Clear search button -->
            <div v-if="hasActiveSearch" class="mt-4">
                <Button @click="clearSearch" variant="outline" class="w-full md:w-auto"> Szűrő törlése</Button>
            </div>
        </div>

        <div class="w-full overflow-x-auto rounded-xl">
            <div class="min-w-full">
                <!-- Header -->
                <div class="grid grid-cols-3 bg-gray-50 text-xs text-gray-700 uppercase">
                    <div class="px-6 py-3">Ügyfél azonosító</div>
                    <div class="px-6 py-3">Név</div>
                    <div class="px-6 py-3">Okmányazonosító</div>
                </div>
                <!-- Rows -->
                <div v-for="client in clients" :key="client.id" class="grid grid-cols-3 border-b border-gray-200 bg-white">
                    <div
                        :class="
                            'px-6 py-4 font-medium whitespace-nowrap' +
                            (client.cars && client.cars.length > 0 ? ' text-gray-900 cursor-pointer hover:underline' : ' text-gray-400 cursor-not-allowed')
                        "
                        @click="toggleClient(client.id)"
                    >
                        {{ client.id }}
                    </div>
                    <div class="px-6 py-4 font-medium whitespace-nowrap text-gray-900">
                        {{ client.name }}
                    </div>
                    <div class="px-6 py-4 font-medium whitespace-nowrap text-gray-900">
                        {{ client.card_number }}
                    </div>

                    <div class="col-span-3 bg-gray-50 p-4" v-if="isExpanded(client.id) && client.cars && client.cars.length > 0">
                        <div class="grid grid-cols-3 gap-2">
                            <div class="col-span-3 grid grid-cols-7 bg-gray-100 text-xs text-gray-600 uppercase">
                                <div class="px-4 py-2">Sorszám</div>
                                <div class="px-4 py-2">Típus</div>
                                <div class="px-4 py-2">Regisztráció időpontja</div>
                                <div class="px-4 py-2">Saját márkás-e?</div>
                                <div class="px-4 py-2">Balesetek száma</div>
                                <div class="px-4 py-2">Utolsó szervíz neve</div>
                                <div class="px-4 py-2">Utolsó szervíz időpontja</div>
                            </div>
                            <div v-for="car in client.cars" :key="'car_' + car.id" class="col-span-3">
                                <div class="grid grid-cols-7 bg-white">
                                    <div
                                        :class="
                                            'px-4 py-3 text-sm text-gray-900 ' +
                                            (car.services && car.services.length > 0 ? ' cursor-pointer hover:underline' : ' cursor-not-allowed')
                                        "
                                        @click="toggleCar(car.id)"
                                    >
                                        {{ car.id }}
                                    </div>
                                    <div class="px-4 py-3 text-sm text-gray-900">{{ car.type }}</div>
                                    <div class="px-4 py-3 text-sm text-gray-900">{{ car.registered }}</div>
                                    <div class="px-4 py-3 text-sm text-gray-900">{{ car.ownbrand ? 'Igen' : 'Nem' }}</div>
                                    <div class="px-4 py-3 text-sm text-gray-900">{{ car.accidents }}</div>
                                    <div class="px-4 py-3 text-sm text-gray-900">{{ car.last_service_name ?? '-' }}</div>
                                    <div class="px-4 py-3 text-sm text-gray-900">{{ car.last_service_date ?? '-' }}</div>
                                </div>

                                <div v-if="isCarExpanded(car.id) && car.services && car.services.length > 0" class="ml-8 bg-gray-50 p-4">
                                    <div class="grid grid-cols-4 bg-gray-200 text-xs text-gray-600 uppercase">
                                        <div class="px-4 py-2">Naplószám</div>
                                        <div class="px-4 py-2">Esemény</div>
                                        <div class="px-4 py-2">Esemény időpontja</div>
                                        <div class="px-4 py-2">Dokumentum azonosító</div>
                                    </div>
                                    <div v-for="service in car.services" :key="'service_' + service.id" class="grid grid-cols-4 border-b bg-white">
                                        <div class="px-4 py-3 text-sm text-gray-900">{{ service.log_number }}</div>
                                        <div class="px-4 py-3 text-sm text-gray-900">{{ service.event }}</div>
                                        <div class="px-4 py-3 text-sm text-gray-900">{{ service.event_time }}</div>
                                        <div class="px-4 py-3 text-sm text-gray-900">{{ service.document_id }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div v-if="searchResult" class="w-full rounded-xl bg-white p-6 shadow">
            <h3 class="mb-4 text-lg font-semibold text-gray-900">Találat</h3>
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-5">
                <div>
                    <p class="text-sm text-gray-600">Ügyfél azonosítója</p>
                    <p class="font-medium text-gray-900">{{ searchResult.id }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Ügyfél neve</p>
                    <p class="font-medium text-gray-900">{{ searchResult.name }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Ügyfél okmányazonosítója</p>
                    <p class="font-medium text-gray-900">{{ searchResult.card_number }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Autóinak darabszáma</p>
                    <p class="font-medium text-gray-900">{{ searchResult.cars?.length || 0 }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Összes szerviznapló bejegyzés</p>
                    <p class="font-medium text-gray-900">{{ totalServiceCount }}</p>
                </div>
            </div>
        </div>
    </div>
</template>
