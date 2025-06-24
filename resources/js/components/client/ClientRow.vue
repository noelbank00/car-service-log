<script setup lang="ts">
import type { Client } from '@/types/model';
import CarsList from './CarsList.vue';

interface Props {
    client: Client;
    isExpanded: boolean;
    expandedCars: Set<number>;
}

interface Emits {
    (e: 'toggle'): void;
    (e: 'toggleCar', carId: number): void;
}

const props = defineProps<Props>();
const emit = defineEmits<Emits>();

const handleToggle = () => {
    if (props.client.cars && props.client.cars.length > 0) {
        emit('toggle');
    }
};

const handleToggleCar = (carId: number) => {
    emit('toggleCar', carId);
};
</script>

<template>
    <div class="grid grid-cols-3 border-b border-gray-200 bg-white">
        <div
            :class="
                'px-6 py-4 font-medium whitespace-nowrap' +
                (client.cars && client.cars.length > 0 ? ' text-gray-900 cursor-pointer hover:underline' : ' text-gray-400 cursor-not-allowed')
            "
            @click="handleToggle"
        >
            {{ client.id }}
        </div>
        <div class="px-6 py-4 font-medium whitespace-nowrap text-gray-900">
            {{ client.name }}
        </div>
        <div class="px-6 py-4 font-medium whitespace-nowrap text-gray-900">
            {{ client.card_number }}
        </div>

        <CarsList
            v-if="isExpanded && client.cars && client.cars.length > 0"
            :cars="client.cars"
            :expanded-cars="expandedCars"
            @toggle-car="handleToggleCar"
        />
    </div>
</template>