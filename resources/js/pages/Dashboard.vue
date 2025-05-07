<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import Todo from '@/pages/Todo.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, router } from '@inertiajs/vue3';
import { ref } from 'vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
];

export type Todo = {
    id: number;
    name: string;
    note: string | null;
    finished: boolean;
};

defineProps<{
    todos: Todo[];
    errors: object;
}>();

const showModal = ref(false);

const newTodo = ref({
    name: '',
    note: null,
});

function openModal(): void {
    showModal.value = true;
}

/**
 * Closes the modal by resetting the modal display state and clearing the new todo values.
 * Additionally, navigates to the dashboard to reset validation errors.
 */
function closeModal(): void {
    showModal.value = false;
    newTodo.value = {
        name: '',
        note: null,
    };

    // Visit the dashboard page to reset validation errors
    router.visit(route('dashboard'), {preserveScroll: true});
}

/**
 * Handles the submission of a form by posting data to a specified route and managing success or error responses.
 */
function submitForm(): void {
    router.post(route('todo.create'), newTodo.value, {
        onSuccess: () => {
            // Optionally, refresh the page or update the local state
            closeModal();
        },
        onError: (error) => {
            console.error('Failed to create todo:', error);
        },
    });
}
</script>

<template>
    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="p-4">
            <!-- New todo button -->
            <div class="mb-8">
                <button @click="openModal" class="rounded border bg-gray-200 p-2 hover:bg-gray-400 dark:bg-gray-600 dark:hover:bg-gray-400">
                    New Todo
                </button>
            </div>

            <!-- Todos list -->
            <div class="grid h-full grid-cols-2 gap-4">
                <Todo v-for="todo in todos" :key="todo.id" :todo="todo" />
            </div>

            <!-- Modal with dark variants -->
            <div v-if="showModal" class="bg-opacity-50 fixed inset-0 z-50 flex items-center justify-center bg-black">
                <div class="w-full max-w-md rounded bg-white p-6 shadow-lg dark:bg-gray-800">
                    <h2 class="mb-4 text-xl font-semibold text-gray-900 dark:text-gray-100">Create New Todo</h2>
                    <form @submit.prevent="submitForm" class="space-y-4">
                        <div>
                            <label class="mb-1 block text-gray-700 dark:text-gray-300" for="name">Name</label>
                            <input
                                v-model="newTodo.name"
                                id="name"
                                type="text"
                                required
                                class="w-full rounded border bg-white p-2 text-black dark:bg-gray-700 dark:text-white"
                            />
                            <div v-if="errors.name" class="text-red-500 text-sm">{{ errors.name }}</div>
                        </div>

                        <div>
                            <label class="mb-1 block text-gray-700 dark:text-gray-300" for="note">Note</label>
                            <textarea
                                v-model="newTodo.note"
                                id="note"
                                class="w-full rounded border bg-white p-2 text-black dark:bg-gray-700 dark:text-white"
                            ></textarea>
                            <div v-if="errors.note" class="text-red-500 text-sm">{{ errors.note }}</div>
                        </div>

                        <div class="flex justify-end space-x-2">
                            <button
                                type="button"
                                @click="closeModal"
                                class="rounded bg-gray-300 px-4 py-2 text-black dark:bg-gray-600 dark:text-white"
                            >
                                Cancel
                            </button>
                            <button type="submit" class="rounded bg-black px-4 py-2 text-white hover:bg-gray-700">Add</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
