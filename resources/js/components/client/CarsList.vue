<script setup lang="ts">
import type { Car } from '@/types/model';
import ServicesList from './ServicesList.vue';

interface Props {
    cars: Car[];
    expandedCars: Set<number>;
}

interface Emits {
    (e: 'toggleCar', carId: number): void;
}

const props = defineProps<Props>();
const emit = defineEmits<Emits>();

const isCarExpanded = (carId: number) => {
    return props.expandedCars.has(carId);
};

const toggleCar = (carId: number) => {
    emit('toggleCar', carId);
};
</script>

<template>
    <div class="col-span-3 bg-gray-50 p-4">
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
            <div v-for="car in cars" :key="'car_' + car.id" class="col-span-3">
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

                <ServicesList 
                    v-if="isCarExpanded(car.id) && car.services && car.services.length > 0" 
                    :services="car.services"
                />
            </div>
        </div>
    </div>
</template>