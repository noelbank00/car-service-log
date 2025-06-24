<script setup lang="ts">
import type { Service } from '@/types/model';

interface Props {
    services: Service[];
}

defineProps<Props>();
</script>

<template>
    <div class="ml-8 bg-gray-50 p-4">
        <div class="grid grid-cols-4 bg-gray-200 text-xs text-gray-600 uppercase">
            <div class="px-4 py-2">Naplószám</div>
            <div class="px-4 py-2">Esemény</div>
            <div class="px-4 py-2">Esemény időpontja</div>
            <div class="px-4 py-2">Dokumentum azonosító</div>
        </div>
        <div 
            v-for="service in services" 
            :key="'service_' + service.id" 
            class="grid grid-cols-4 border-b bg-white"
        >
            <div class="px-4 py-3 text-sm text-gray-900">{{ service.log_number }}</div>
            <div class="px-4 py-3 text-sm text-gray-900">{{ service.event }}</div>
            <div class="px-4 py-3 text-sm text-gray-900">{{ service.event_time }}</div>
            <div class="px-4 py-3 text-sm text-gray-900">{{ service.document_id }}</div>
        </div>
    </div>
</template>