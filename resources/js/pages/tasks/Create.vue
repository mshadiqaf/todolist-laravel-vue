<script setup lang="ts">
import Heading from '@/components/Heading.vue';
import Button from '@/components/ui/button/Button.vue';
import Input from '@/components/ui/input/Input.vue';
import Label from '@/components/ui/label/Label.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, useForm } from '@inertiajs/vue3';
import { ListPlus } from 'lucide-vue-next';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Tasks',
        href: '/tasks',
    },
    {
        title: 'Add Task',
        href: '/tasks/create',
    },
];

const form = useForm({
    title: '',
    description: '',
    category: '',
    due_date: '',
});

interface Category {
    id: number;
    name: string;
}

defineProps<{
    categories: Category[];
}>();
</script>

<template>
    <Head title="Task Lists" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="px-4 py-6">
            <div class="flex justify-between">
                <Heading title="Add a task" description="Create your new to-do task" />
            </div>

            <form @submit.prevent="form.post('/tasks')" class="space-y-4">
                <div class="space-y-1">
                    <Label>Task Name</Label>
                    <Input v-model="form.title" type="text" placeholder="Write your task name here" />
                    <div v-if="form.errors.title" class="text-sm text-red-500">{{ form.errors.title }}</div>
                </div>
                <!-- Deskripsi -->
                <div class="space-y-1">
                    <Label>Desription</Label>
                    <textarea v-model="form.description" class="w-full rounded border px-3 py-2"></textarea>
                    <div v-if="form.errors.description" class="text-sm text-red-500">{{ form.errors.description }}</div>
                </div>

                <!-- Tanggal -->
                <div class="space-y-1">
                    <Label>Deadline</Label>
                    <input v-model="form.due_date" type="date" class="w-full rounded border px-3 py-2" />
                    <div v-if="form.errors.due_date" class="text-sm text-red-500">{{ form.errors.due_date }}</div>
                </div>

                <!-- Kategori -->
                <div class="space-y-1">
                    <Label>Category</Label>
                    <select v-model="form.category" class="w-full rounded border px-3 py-2">
                        <option disabled value="">Pilih Kategori</option>
                        <option v-for="cat in categories" :key="cat.id" :value="cat.id">
                            {{ cat.name }}
                        </option>
                    </select>
                    <div v-if="form.errors.category" class="text-sm text-red-500">{{ form.errors.category }}</div>
                </div>

                <!-- Submit -->
                <div>
                    <Button type="submit" :disabled="form.processing">
                        <ListPlus class="mr-2" />
                        Simpan
                    </Button>
                </div>
            </form>
        </div>
    </AppLayout>
</template>
