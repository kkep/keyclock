<script setup lang="ts">
import AdminLayout from '@/layouts/AdminLayout.vue';
import { Head } from '@inertiajs/vue3';
import { dateFormatter } from '@/lib/utils';
import EntityTable from '@/components/EntityTable.vue';
import AddEntityDialog from '@/components/AddEntityDialog.vue';

const fields = {
    id: { editable: false, formatter: false },
    article_id: { editable: true, formatter: false },
    user_id: { editable: true, formatter: false },
    created_at: { editable: false, formatter: dateFormatter },
    updated_at: { editable: false, formatter: dateFormatter },
    deleted_at: { editable: false, formatter: dateFormatter },
};
</script>

<template>
    <Head title="Администрирование | Лайки" />

    <AdminLayout>
        <div class="p-5 flex flex-col gap-5">
            <div>
                <AddEntityDialog :fields="fields" entity="like"/>
            </div>

            <div>
                <EntityTable :fields="fields" entity="like" />
            </div>
        </div>
    </AdminLayout>
</template>
