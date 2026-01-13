<script setup>
import { ref } from 'vue'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, router } from '@inertiajs/vue3';

const props = defineProps({
    title: {
        type: String,
        default: ''
    },
    datas: {
        type: Array,
        default: () => []
    },
})

// ini sample usage dari dokumentasi https://antdv.com/components/table, bisa coba di implementasi di backend/controller
// columns: [
//     {
//         title: 'Name',
//         dataIndex: 'name',
//         key: 'name',
//     },
//     {
//         title: 'Age',
//         dataIndex: 'age',
//         key: 'age',
//     },
//     {
//         title: 'Address',
//         dataIndex: 'address',
//         key: 'address',
//     },
// ],
// #2 refrensi https://codesandbox.io/s/t75ptj <-- for pagination

const edit = (id) => {
    // alert('hello edit ' + id);
}

const columns = [
    {
        title: 'Index',
        dataIndex: 'id',
        key: 'id',
    },
    {
        title: 'Name',
        dataIndex: 'name',
        key: 'name',
    },
    {
        title: 'Email',
        dataIndex: 'email',
        key: 'email',
    },
    {
        title: 'logo',
        dataIndex: 'logo',
        key: 'logo',
    },
    {
        title: 'Website',
        dataIndex: 'website',
        key: 'website',
    },
    {
        title: 'Action',
        key: 'action',
    }
];


const handlePaginate = (pagination) => {
    router.get(route('company.index'), {
        page: pagination.current,
    }, {
        preserveScroll: true,
        preserveState: true,
    })
}

let selectedId = "";
let selectedName = "";

const handleRemove = (id, name) => {
    selectedId = id;
    selectedName = name;
}

const handleRemoveData = () => {
    router.delete(route('company.destroy', selectedId), {
        onFinish: () => {
            selectedId = "";
            selectedName = "";
        },
    })
}
</script>

<template>

    <Head :title="title" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                {{ title }}
            </h2>
        </template>

        <div class="container bg-white-500 mx-auto pt-5">
            <div class="pt-6 p-8 sm:p-6 lg:p-8 y-6 shadow-sm rounded-lg bg-white-500">
                <a-table :columns="columns" :dataSource="props.datas.data" :pagination="{
                    current: props.datas.meta.current_page,
                    pageSize: props.datas.meta.per_page,
                    total: props.datas.meta.total
                }" @change="handlePaginate">
                    <template #bodyCell="{ column, record }">
                        <template v-if="column.key === 'logo'">
                            <img :src="record.logo" alt="">
                        </template>
                        <template v-if="column.key === 'website'">
                            <button class="text-blue-500 underline text-left">
                                <a :href="record.website" target="_blank">{{
                                    record.website }}</a>
                            </button>
                        </template>
                        <template v-if="column.key === 'action'">
                            <div class="inline-flex rounded shadow-xs -space-x-px" role="group">
                                <button type="button"
                                    class="inline-flex items-center text-body bg-neutral-primary-soft border border-default hover:bg-neutral-secondary-medium hover:text-heading focus:ring-3 focus:ring-neutral-tertiary-soft font-medium leading-5 rounded-s-base text-sm px-3 py-2 focus:outline-none">
                                    <span>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                            <path
                                                d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                            <path fill-rule="evenodd"
                                                d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z" />
                                        </svg>
                                    </span>
                                </button>
                                <button @click="handleRemove(record.id, record.name)" command="show-modal"
                                    commandfor="dialog"
                                    class="bg-yellow-200 inline-flex items-center text-body bg-neutral-primary-soft border border-default hover:bg-neutral-secondary-medium hover:text-heading focus:ring-3 focus:ring-neutral-tertiary-soft font-medium leading-5 rounded-s-base text-sm px-3 py-2 focus:outline-none">
                                    <span>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
                                            <path
                                                d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8z" />
                                        </svg>
                                    </span>
                                </button>
                                <button @click="handleRemove(record.id, record.name)" command="show-modal"
                                    commandfor="dialog"
                                    class="bg-red-400 inline-flex items-center text-body bg-neutral-primary-soft border border-default hover:bg-neutral-secondary-medium hover:text-heading focus:ring-3 focus:ring-neutral-tertiary-soft font-medium leading-5 rounded-s-base text-sm px-3 py-2 focus:outline-none">
                                    <span>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
                                            <path
                                                d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8z" />
                                        </svg>
                                    </span>
                                </button>
                            </div>
                        </template>
                    </template>
                </a-table>
            </div>
        </div>

        <!-- design panel untuk remove  -->
        <!-- refrensi https://tailwindcss.com/plus/ui-blocks/application-ui/overlays/modal-dialogs -->

        <el-dialog>
            <dialog id="dialog" aria-labelledby="dialog-title"
                class="fixed inset-0 size-auto max-h-none max-w-none overflow-y-auto bg-transparent backdrop:bg-transparent">
                <el-dialog-backdrop
                    class="fixed inset-0 bg-gray-900/50 transition-opacity data-closed:opacity-0 data-enter:duration-300 data-enter:ease-out data-leave:duration-200 data-leave:ease-in"></el-dialog-backdrop>

                <div tabindex="0"
                    class="flex min-h-full items-end justify-center p-4 text-center focus:outline-none sm:items-center sm:p-0">
                    <el-dialog-panel
                        class="relative transform overflow-hidden rounded-lg bg-gray-800 text-left shadow-xl outline -outline-offset-1 outline-white/10 transition-all data-closed:translate-y-4 data-closed:opacity-0 data-enter:duration-300 data-enter:ease-out data-leave:duration-200 data-leave:ease-in sm:my-8 sm:w-full sm:max-w-lg data-closed:sm:translate-y-0 data-closed:sm:scale-95">
                        <div class="bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <div class="sm:flex sm:items-start">
                                <div
                                    class="mx-auto flex size-12 shrink-0 items-center justify-center rounded-full bg-red-500/10 sm:mx-0 sm:size-10">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"
                                        data-slot="icon" aria-hidden="true" class="size-6 text-red-400">
                                        <path
                                            d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z"
                                            stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </div>
                                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                    <h3 id="dialog-title" class="text-base font-semibold text-white">Remove account
                                    </h3>
                                    <div class="mt-2">
                                        <p class="text-sm text-gray-400">Are you sure you want to Remove {{ selectedName
                                        }} from
                                            company?</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-700/25 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                            <!-- remove below -->
                            <button type="button" command="close" commandfor="dialog" @click="handleRemoveData()"
                                class="inline-flex w-full justify-center rounded-md bg-red-500 px-3 py-2 text-sm font-semibold text-white hover:bg-red-400 sm:ml-3 sm:w-auto">
                                Remove</button>
                            <!-- and cancel below btw -->
                            <button type="button" command="close" commandfor="dialog"
                                class="mt-3 inline-flex w-full justify-center rounded-md bg-white/10 px-3 py-2 text-sm font-semibold text-white inset-ring inset-ring-white/5 hover:bg-white/20 sm:mt-0 sm:w-auto">
                                Cancel</button>
                        </div>
                    </el-dialog-panel>
                </div>
            </dialog>
        </el-dialog>

    </AuthenticatedLayout>
</template>
