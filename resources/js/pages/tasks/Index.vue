<script setup lang="ts">
import Heading from '@/components/Heading.vue';
import Button from '@/components/ui/button/Button.vue';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import { ListPlus } from 'lucide-vue-next';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Tasks',
        href: '/tasks',
    },
];

interface Task {
    id: number;
    title: string;
    description: string;
    status: 'pending' | 'on_progress' | 'done';
    due_date: string | null;
    categories: { id: number; name: string }[];
}

interface Props {
    tasks: Task[];
}

const props = defineProps<Props>();
</script>

<template>
    <Head title="Task Lists" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="px-4 py-6">
            <div class="flex flex-row justify-between">
                <Heading title="Tasks" description="Manage your to-do list tasks" />
                <div>
                    <a href="/tasks/create">
                        <Button class="cursor-pointer">
                            <ListPlus />
                            Add a Task
                        </Button>
                    </a>
                </div>
            </div>

            <div class="rounded-md border">
                <Table>
                    <TableHeader>
                        <TableRow>
                            <TableHead>ID</TableHead>
                            <TableHead>Tasks</TableHead>
                            <TableHead>Description</TableHead>
                            <TableHead>Status</TableHead>
                            <TableHead>Category</TableHead>
                            <TableHead>Deadline</TableHead>
                        </TableRow>
                    </TableHeader>
                    <TableBody>
                        <TableRow v-for="task in props.tasks" :key="task.id">
                            <TableCell>{{ task.id }}</TableCell>
                            <TableCell>{{ task.title }}</TableCell>
                            <TableCell>{{ task.description }}</TableCell>
                            <TableCell>
                                <span
                                    class="rounded px-2 py-1 text-xs capitalize"
                                    :class="{
                                        'bg-yellow-100 text-yellow-800': task.status === 'pending',
                                        'bg-blue-100 text-blue-800': task.status === 'on_progress',
                                        'bg-green-100 text-green-800': task.status === 'done',
                                    }"
                                >
                                    {{ task.status.replace('_', ' ') }}
                                </span>
                            </TableCell>
                            <TableCell>
                                <div class="flex flex-wrap gap-1">
                                    <span v-for="category in task.categories" :key="category.id" class="rounded bg-gray-200 px-2 py-0.5 text-xs">
                                        {{ category.name }}
                                    </span>
                                </div>
                            </TableCell>
                            <TableCell>
                                {{ task.due_date ?? '-' }}
                            </TableCell>
                        </TableRow>
                    </TableBody>
                </Table>
            </div>
        </div>
    </AppLayout>
</template>
