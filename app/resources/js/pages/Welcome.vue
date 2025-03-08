<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import {ref} from "vue";
import SelectButton from 'primevue/selectbutton';
import { useAppearance } from '@/composables/useAppearance';

const themeOptions = ['light', 'dark', 'system'];

const { appearance, updateAppearance } = useAppearance()
</script>

<template>
    <Head title="Главная" />
    <div class="flex min-h-screen flex-col items-center bg-[#FDFDFC] p-6 text-[#1b1b18] dark:bg-[#0a0a0a] lg:justify-center lg:p-8">
        <header class="not-has-[nav]:hidden mb-6 w-full max-w-[335px] text-sm lg:max-w-4xl">

            <nav class="flex items-center justify-end gap-4">
                <SelectButton v-model="appearance" :options="themeOptions" @valueChange="updateAppearance" size="small" />
                <template v-if="$page.props.auth.user">
                    <i class="pi pi-user dark:text-[#EDEDEC] dark:hover:border-[#3E3E3A]" style="font-size: 1rem"></i>
                    <span class="dark:text-[#EDEDEC] dark:hover:border-[#3E3E3A]">{{ $page.props.auth.user.name }}</span>
                </template>


                <Link
                    v-if="$page.props.auth.user"
                    :href="route('admin.article.index')"
                    class="inline-block rounded-sm border border-[#19140035] px-5 py-1.5 text-sm leading-normal text-[#1b1b18] hover:border-[#1915014a] dark:border-[#3E3E3A] dark:text-[#EDEDEC] dark:hover:border-[#62605b]"
                >
                    Admin UI
                </Link>
                <template v-else>
                    <a
                        href="/login"
                        class="inline-block rounded-sm border border-transparent px-5 py-1.5 text-sm leading-normal text-[#1b1b18] hover:border-[#19140035] dark:text-[#EDEDEC] dark:hover:border-[#3E3E3A]"
                    >Войти</a>
                    <a
                        href="/register"
                        class="inline-block rounded-sm border border-transparent px-5 py-1.5 text-sm leading-normal text-[#1b1b18] hover:border-[#19140035] dark:text-[#EDEDEC] dark:hover:border-[#3E3E3A]"
                    >Регистрация</a>
                </template>
            </nav>
        </header>
        <div class="duration-750 starting:opacity-0 flex w-full items-center justify-center opacity-100 transition-opacity lg:grow">
            <main class="flex w-full max-w-[335px] flex-col-reverse overflow-hidden rounded-lg lg:max-w-4xl lg:flex-row">
                <div v-for="article of $page.props.articles.data" class="grid grid-cols-12 gap-3">
                    <div class="col-span-3">
                        <img :src="article.poster_url" class="aspect-square object-cover w-full">
                    </div>
                    <div class="col-span-9">
                        <p class="font-bold dark:text-[#EDEDEC] dark:hover:border-[#3E3E3A]">{{ article.title }}</p>
                        <p class="dark:text-[#EDEDEC] dark:hover:border-[#3E3E3A]">{{ article.text }}</p>
                    </div>
                </div>
            </main>
        </div>
        <div class="h-14.5 hidden lg:block"></div>
    </div>
</template>
