<script setup lang="ts">
import Heading from '@/components/Heading.vue';
import Button from '@/components/ui/button/Button.vue';
import { Calendar } from '@/components/ui/calendar/';
import Input from '@/components/ui/input/Input.vue';
import Label from '@/components/ui/label/Label.vue';
import { Popover, PopoverContent, PopoverTrigger } from '@/components/ui/popover/';
import Textarea from '@/components/ui/textarea/Textarea.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { cn } from '@/lib/utils';
import { type BreadcrumbItem } from '@/types';
import { Head, useForm } from '@inertiajs/vue3';
import { DateFormatter, type DateValue, getLocalTimeZone } from '@internationalized/date';
import { Calendar as CalendarIcon, ListPlus } from 'lucide-vue-next';
import { ref } from 'vue';

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
    category: [] as number[],
    due_date: '',
});

interface Category {
    id: number;
    name: string;
}

const categories = [
    { id: 1, name: 'Work' },
    { id: 2, name: 'Personal' },
    { id: 3, name: 'Urgent' },
];

defineProps<{
    categories: Category[];
}>();

const df = new DateFormatter('en-US', {
    dateStyle: 'long',
});

const value = ref<DateValue>();

function toggleCategory(id: number) {
    const index = form.category.indexOf(id);
    if (index > -1) {
        form.category.splice(index, 1); // hapus
    } else {
        form.category.push(id); // tambah
    }
}
</script>

<template>
    <Head title="Task Lists" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="px-4 py-6">
            <div class="flex justify-between">
                <Heading title="Add a task" description="Create your new to-do task" />
            </div>

            <form @submit.prevent="form.post('/tasks')" class="w-3/5 space-y-4">
                <!-- Name -->
                <div class="space-y-2">
                    <Label>Task Name</Label>
                    <Input v-model="form.title" type="text" placeholder="Write your task name here" />
                    <div v-if="form.errors.title" class="text-sm text-red-500">{{ form.errors.title }}</div>
                </div>

                <!-- Deskripsi -->
                <div class="space-y-2">
                    <Label>Desription</Label>
                    <Textarea v-model="form.description" placeholder="Write the description of the task here"></Textarea>
                    <div v-if="form.errors.description" class="text-sm text-red-500">{{ form.errors.description }}</div>
                </div>

                <!-- Tanggal -->
                <div class="space-y-2">
                    <Label>Deadline</Label>
                    <Popover>
                        <PopoverTrigger as-child>
                            <Button variant="outline" :class="cn('w-full justify-start text-left font-normal', !value && 'text-muted-foreground')">
                                <CalendarIcon class="mr-2 h-4 w-4" />
                                {{ value ? df.format(value.toDate(getLocalTimeZone())) : 'Pick a date' }}
                            </Button>
                        </PopoverTrigger>
                        <PopoverContent class="w-auto p-0">
                            <Calendar v-model="value" initial-focus />
                        </PopoverContent>
                    </Popover>
                    <div v-if="form.errors.due_date" class="text-sm text-red-500">{{ form.errors.due_date }}</div>
                </div>

                <!-- Kategori -->
                <div class="space-y-2">
                    <Label>Category</Label>
                    <div class="flex flex-wrap gap-2">
                        <Button
                            v-for="cat in categories"
                            :key="cat.id"
                            type="button"
                            @click="toggleCategory(cat.id)"
                            :class="[
                                'cursor-pointer rounded-full border-2 px-3 py-1.5 text-sm font-medium transition hover:bg-secondary',
                                form.category.includes(cat.id)
                                    ? 'border-blue-400 bg-blue-100 font-semibold text-blue-500 hover:bg-blue-200'
                                    : 'bg-muted text-muted-foreground',
                            ]"
                        >
                            {{ cat.name }}
                        </Button>
                    </div>

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
