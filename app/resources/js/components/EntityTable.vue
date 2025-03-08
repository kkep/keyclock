<script setup lang="ts">
import InputText from 'primevue/inputtext';
import Paginator from 'primevue/paginator';
import Column from 'primevue/column';
import DataTable, { DataTableRowEditSaveEvent } from 'primevue/datatable';
import { router, useForm } from '@inertiajs/vue3';
import UserSelect from '@/components/UserSelect.vue';
import { ref } from 'vue';

const props = defineProps({
    fields: { type: Object, required: true },
    entity: { type: String, required: true },
});

const editingRows = ref([]);

const onCellEditComplete = (event: DataTableRowEditSaveEvent<any>) => {
    const data = {...event.newData};
    useForm(data).put(route(`admin.${props.entity}.update`, data));
}

const onPageChange = ({ page, rows }: {page: number, rows: number}) => {
    router.reload({ only: ['data'], data: { page: page + 1, perPage: rows } })
}
</script>

<template>
    <DataTable :value="$page.props.data.data" v-model:editingRows="editingRows" editMode="row" @row-edit-save="onCellEditComplete">
        <Column :rowEditor="true" style="width: 10%; min-width: 8rem" bodyStyle="text-align:center"></Column>
        <Column v-for="(fieldObj, key) of fields" :field="key" :header="key" :key="key">
            <template #body="{ data, field }">
                {{ fields[field].formatter ? fields[field].formatter(data[field]) : data[field] }}
            </template>

            <template v-if="fieldObj.editable" #editor="{ data, field }">
                <template v-if="field === 'author_id' || field === 'user_id'">
                    <UserSelect v-model="data[field]" />
                </template>
                <InputText v-else v-model="data[field]" autofocus fluid />
            </template>
        </Column>
    </DataTable>
    <Paginator
        :first="($page.props.data.current_page - 1) * $page.props.data.per_page"
        :rows="$page.props.data.per_page"
        :totalRecords="$page.props.data.total"
        :rowsPerPageOptions="[5, 10, 20, 30]"
        @page="onPageChange"
    />
</template>

<style scoped>

</style>
