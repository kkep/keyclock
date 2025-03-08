<script setup lang="ts">
import { ref } from 'vue';
import {useForm} from '@inertiajs/vue3';
import Button from 'primevue/button';
import InputText from 'primevue/inputtext';
import IftaLabel from 'primevue/iftalabel';
import Dialog from 'primevue/dialog';
import FieldError from '@/components/FieldError.vue';
import UserSelect from '@/components/UserSelect.vue';
import Toast from 'primevue/toast';
import { useToast } from 'primevue/usetoast';

const toast = useToast();

const props = defineProps({
    fields: { type: Object, required: true},
    entity: { type: String, required: true },
});

const visible = ref(false);

const fieldKeys = Object.keys(props.fields)

const editableFields: any = {};

fieldKeys.forEach(key => {
    if (props.fields[key].editable) {
        editableFields[key] = null;
    }
})

const form = useForm(editableFields);

const submit = () => {
    form.post(
        route(`admin.${props.entity}.store`),
        {
            onSuccess: () => {
                toast.add({ severity: 'success', summary: 'Запись добавлена', life: 1500 });
                visible.value = false;
                form.reset();
            }
        }
    );
};
</script>

<template>
    <Toast />
    <Button label="Добавить" @click="visible = true" />

    <Dialog v-model:visible="visible" modal header="Добавить новость" :style="{ width: '30rem' }">
        <form @submit.prevent="submit" class="flex flex-col gap-3">
            <template v-for="(f, key) of editableFields">
                <IftaLabel v-if="key === 'user_id' || key === 'author_id'">
                    <UserSelect v-model="form[key]" :label="key" />
                    <FieldError>{{ form.errors[key] ?? '' }}</FieldError>
                </IftaLabel>
                <IftaLabel v-else>
                    <InputText :id="key" v-model="form[key]" class="w-full" />
                    <label :for="key">{{ key }}</label>
                    <FieldError>{{ form.errors[key] ?? '' }}</FieldError>
                </IftaLabel>
            </template>

            <div class="flex flex-row gap-5 justify-end">
                <Button label="Отмена" @click="visible = false" :disabled="form.processing" severity="secondary" />
                <Button label="Добавить" type="submit" :loading="form.processing" :disabled="form.processing" />
            </div>
        </form>
    </Dialog>
</template>

<style scoped>

</style>
