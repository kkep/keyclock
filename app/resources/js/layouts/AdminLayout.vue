<template>
    <div class="card flex flex-row justify-center">
        <Menu :model="items" class="flex flex-[0_1_100px] flex-col h-[100vh] sticky top-0">
            <template #start>
                <span class="inline-flex items-center gap-1 px-2 py-2">
                    <span class="text-xl font-semibold">PRIME<span class="text-primary">APP</span></span>
                </span>
            </template>
            <template #submenulabel="{ item }" class="flex-grow">
                <span class="text-primary font-bold">{{ item.label }}</span>
            </template>
            <template #item="{ item, props }">
                <Link v-ripple :href="item.url" class="flex items-center" v-bind="props.action">
                    <span :class="item.icon" />
                    <span>{{ item.label }}</span>
                    <Badge v-if="item.badge" class="ml-auto" :value="item.badge" />
                    <span v-if="item.shortcut" class="ml-auto border border-surface rounded bg-emphasis text-muted-color text-xs p-1">{{ item.shortcut }}</span>
                </Link>
            </template>
            <template #end>
                <button v-ripple class="relative overflow-hidden w-full border-0 bg-transparent flex items-start p-2 pl-4 hover:bg-surface-100 dark:hover:bg-surface-800 rounded-none cursor-pointer transition-colors duration-200">
                    <Avatar image="https://primefaces.org/cdn/primevue/images/avatar/amyelsner.png" class="mr-2" shape="circle" />
                    <span class="inline-flex flex-col items-start">
                        <span class="font-bold">{{ $page.props.auth.user.name }}</span>
                    </span>
                </button>
            </template>
        </Menu>
        <div class="flex-grow md:w-60">
            <div class="card">
                <slot></slot>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref } from "vue";
import { Link } from '@inertiajs/vue3';
import Avatar from 'primevue/avatar';
import Badge from 'primevue/badge';
import Menu from 'primevue/menu';

const items = ref([
    {
        label: 'Главная',
        icon: 'pi pi-home',
        url: route('home'),
    },
    {
        label: 'Новости',
        icon: 'pi pi-palette',
        url: route('admin.article.index'),
    },
    {
        label: 'Лайки',
        icon: 'pi pi-heart',
        url: route('admin.like.index'),
    },
    {
        label: 'Комментарии',
        icon: 'pi pi-comment',
        url: route('admin.comment.index'),
    },
]);
</script>

<style>
.p-menu-list {
    flex-grow: 1;
}
</style>
