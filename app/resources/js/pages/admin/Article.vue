<script setup lang="ts">
import AdminLayout from '@/layouts/AdminLayout.vue';
import { Head } from '@inertiajs/vue3';
import { dateFormatter } from '@/lib/utils';
import EntityTable from '@/components/EntityTable.vue';
import AddEntityDialog from '@/components/AddEntityDialog.vue';

const fields = {
    id: { editable: false, formatter: false },
    author_id: { editable: true, formatter: false },
    title: { editable: true, formatter: false },
    text: { editable: true, formatter: false },
    poster_url: { editable: true, formatter: false },
    created_at: { editable: false, formatter: dateFormatter },
    updated_at: { editable: true, formatter: dateFormatter },
    deleted_at: { editable: true, formatter: dateFormatter },
};
</script>

<template>
    <Head title="Администрирование | Новости" />

    <AdminLayout>
        <div class="p-5 flex flex-col gap-5">
            <div>
                <AddEntityDialog :fields="fields" entity="article"/>
            </div>

            <div>
                <EntityTable :fields="fields" entity="article" />
            </div>
        </div>
    </AdminLayout>
</template>
