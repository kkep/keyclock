<script setup lang="ts">
import Select from 'primevue/select';
import { ref } from 'vue';
import {debounceTime} from '@/lib/utils';

defineProps({ label: String })
const model = defineModel();

const users = ref([]);
const loadingUsers = ref(false);

const onFilterUsers = debounceTime((e: { value: string }) => {
    loadingUsers.value = true;
    fetch(route('admin.user.index', {search: e.value})).then(request => {
        request.json().then(response => {
            users.value = response.data;
            loadingUsers.value = false;
        })
    });
}, 3000);
</script>

<template>
    <Select
        v-model="model"
        inputId="user_id"
        :options="users"
        optionLabel="name"
        optionValue="id"
        class="w-full"
        variant="filled"
        filter
        :loading="loadingUsers"
        @filter="onFilterUsers"
    />
    <label for="user_id">{{ label }}</label>
</template>

<style scoped>

</style>
