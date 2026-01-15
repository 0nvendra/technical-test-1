<script setup>
import { ref } from 'vue'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, router } from '@inertiajs/vue3';
import EnrollDialog from './EnrollDialog.vue'
import ReadDialog from './ReadDialog.vue';
import EditDialog from './EditDialog.vue';
import CompanyReadDialog from '../Company/ReadDialog.vue'


const props = defineProps({
    title: {
        type: String,
        default: ''
    },
    datas: {
        type: Array,
        default: () => []
    },
    company: {
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

const columns = [
    {
        title: 'Index',
        dataIndex: 'id',
        key: 'id',
        width: 20,
        // responsive: ['md'], <-- must responsive for mobileView
    },

    {
        title: 'Full Name',
        dataIndex: 'fullName',
        key: 'fullName',
    },
    {
        title: 'Company',
        dataIndex: 'company_name',
        key: 'company_name',
    },
    {
        title: 'Email',
        dataIndex: 'email',
        key: 'email',
    },
    {
        title: 'Phone',
        dataIndex: 'phone',
        key: 'phone',
    },
    {
        title: 'Action',
        key: 'action',
        width: 100,
        fixed: 'right',
    }
];


const handlePaginate = (pagination) => {
    router.get(route('employee.index'), {
        page: pagination.current,
    }, {
        preserveScroll: true,
        preserveState: true,
    })
}

const selectedId = ref("");
const selectedName = ref("");
const showToast = ref(false);

const handleRemove = (id, name) => {
    selectedId.value = id;
    selectedName.value = name;
}

const handleRemoveData = () => {
    router.delete(route('employee.destroy', selectedId.value), {
        onFinish: () => {
            showToast.value = true;
            selectedId.value = ref("");
            selectedName.value = ref("");
            // timer manual, belum ketemu autoclosenya (bisa di cari dari tailwin)
            const autoclose = setTimeout(() => {
                showToast.value = false;
            }, 2500);
        },
    })
}

// bagian ReadDialog
const employeeData = ref({})
const selectedCompany = ref({})

</script>

<template>

    <Head :title="title" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-slate-800">
                {{ title }}
            </h2>
        </template>
        <div class="container bg-white-500 mx-auto pt-5">
            <div class="pt-6 sm:p-6 lg:p-8 y-6 shadow-sm rounded-lg bg-white-500">
                <div class="rounded py-2 px-2 pb-20">
                    <button command="show-modal" commandfor="enrollDialog"
                        class="float-right rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                        Enroll</button>
                </div>
                <a-table :columns="columns" :dataSource="props.datas.data" :pagination="{
                    current: props.datas.meta.current_page,
                    pageSize: props.datas.meta.per_page,
                    total: props.datas.meta.total,
                }" @change="handlePaginate">
                    <template #bodyCell="{ column, record }">
                        <template v-if="column.key === 'company_name'">
                            <button type="button" @click="(selectedCompany = { ...record.company })"
                                command="show-modal" commandfor="companyReadDialog"
                                class="bg-blue-200 inline-flex items-center text-body bg-neutral-primary-soft border border-default hover:bg-neutral-secondary-medium hover:text-heading focus:ring-3 focus:ring-neutral-tertiary-soft font-medium leading-5 rounded-s-base text-sm px-3 py-2 focus:outline-none">
                                <span class="font-bold underline">{{ record.company.name }}</span>
                            </button>
                        </template>
                        <template v-if="column.key === 'action'">
                            <div class="inline-flex rounded shadow-xs -space-x-px" role="group">
                                <button type="button" @click="(employeeData = { ...record })" command="show-modal"
                                    commandfor="editDialog"
                                    class="bg-slate-200 inline-flex items-center text-body bg-neutral-primary-soft border border-default hover:bg-neutral-secondary-medium hover:text-heading focus:ring-3 focus:ring-neutral-tertiary-soft font-medium leading-5 rounded-s-base text-sm px-3 py-2 focus:outline-none">
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
                                <button @click="(employeeData = { ...record })" command="show-modal"
                                    commandfor="readDialog"
                                    class="bg-slate-200 inline-flex items-center text-body bg-neutral-primary-soft border border-default hover:bg-neutral-secondary-medium hover:text-heading focus:ring-3 focus:ring-neutral-tertiary-soft font-medium leading-5 rounded-s-base text-sm px-3 py-2 focus:outline-none">
                                    <span>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-eye-fill" viewBox="0 0 16 16">
                                            <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0" />
                                            <path
                                                d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8m8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7" />
                                        </svg>
                                    </span>
                                </button>
                                <button @click="handleRemove(record.id, record.fullName)" command="show-modal"
                                    commandfor="removeDialog"
                                    class="bg-slate-200 inline-flex items-center text-body bg-neutral-primary-soft border border-default hover:bg-neutral-secondary-medium hover:text-heading focus:ring-3 focus:ring-neutral-tertiary-soft font-medium leading-5 rounded-s-base text-sm px-3 py-2 focus:outline-none">
                                    <span>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="red"
                                            class="bi bi-x-lg" viewBox="0 0 16 16">
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
            <dialog id="removeDialog" aria-labelledby="dialog-title"
                class="fixed inset-0 size-auto max-h-none max-w-none overflow-y-auto bg-transparent backdrop:bg-transparent">
                <el-dialog-backdrop
                    class="fixed inset-0 bg-gray-500/75 transition-opacity data-closed:opacity-0 data-enter:duration-300 data-enter:ease-out data-leave:duration-200 data-leave:ease-in"></el-dialog-backdrop>

                <div tabindex="0"
                    class="flex min-h-full items-end justify-center p-4 text-center focus:outline-none sm:items-center sm:p-0">
                    <el-dialog-panel
                        class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all data-closed:translate-y-4 data-closed:opacity-0 data-enter:duration-300 data-enter:ease-out data-leave:duration-200 data-leave:ease-in sm:my-8 sm:w-full sm:max-w-lg data-closed:sm:translate-y-0 data-closed:sm:scale-95">
                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <div class="sm:flex sm:items-start">
                                <div
                                    class="mx-auto flex size-12 shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:size-10">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"
                                        data-slot="icon" aria-hidden="true" class="size-6 text-red-600">
                                        <path
                                            d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z"
                                            stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </div>
                                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                    <h3 id="dialog-title" class="text-base font-semibold text-gray-900">Deactivate
                                        account</h3>
                                    <div class="mt-2">
                                        <p class="text-sm text-gray-500">Are you sure you want to Remove
                                            "<strong>{{ selectedName }}</strong>" from
                                            employee?</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                            <!-- remove below -->
                            <button type="button" command="close" commandfor="removeDialog" @click="handleRemoveData()"
                                class="inline-flex w-full justify-center rounded-md bg-red-500 px-3 py-2 text-sm font-semibold text-white hover:bg-red-400 sm:ml-3 sm:w-auto">
                                Remove</button>
                            <!-- and cancel below btw -->
                            <button type="button" command="close" commandfor="removeDialog"
                                class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-black inset-ring inset-ring-white/5 hover:bg-white/20 sm:mt-0 sm:w-auto">
                                Cancel</button>
                        </div>
                    </el-dialog-panel>
                </div>
            </dialog>
        </el-dialog>

        <!-- notif/toast for removed -->
        <div v-if="showToast" class="fixed top-40 right-5 bg-green-400 
            text-white px-4 py-2 rounded transition-all duration-1000 shadow-md ease-in-out">
            {{ title }} removed
        </div>
        <EnrollDialog :companies="company" />
        <ReadDialog :data="employeeData" />
        <EditDialog :data="employeeData" :companies="company" />
        <CompanyReadDialog :data="selectedCompany" />

    </AuthenticatedLayout>
</template>
