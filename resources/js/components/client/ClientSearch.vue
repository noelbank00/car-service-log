<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { ref } from 'vue';

interface Props {
    search?: {
        name: string;
        card_number: string;
    };
    error?: string;
    hasActiveSearch: boolean;
}

interface Emits {
    (e: 'search', data: { name?: string; card_number?: string }): void;

    (e: 'clear'): void;
}

const props = defineProps<Props>();
const emit = defineEmits<Emits>();

const searchForm = ref({
    name: props.search?.name || '',
    card_number: props.search?.card_number || '',
});

const searchErrors = ref<{
    name?: string;
    card_number?: string;
    general?: string;
}>({});

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

    emit('search', {
        name: searchForm.value.name || undefined,
        card_number: searchForm.value.card_number || undefined,
    });
};

const handleClear = () => {
    searchForm.value.name = '';
    searchForm.value.card_number = '';
    searchErrors.value = {};
    emit('clear');
};
</script>

<template>
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
        <p v-if="error" class="mt-2 text-sm text-red-500">{{ error }}</p>

        <!-- Clear search button -->
        <div v-if="hasActiveSearch" class="mt-4">
            <Button @click="handleClear" variant="outline" class="w-full md:w-auto">Szűrő törlése</Button>
        </div>
    </div>
</template>
