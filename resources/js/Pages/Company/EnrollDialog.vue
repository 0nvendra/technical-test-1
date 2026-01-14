<script setup>
import { ref } from 'vue'
defineProps({
    handleEnroll: Boolean,
})
const csrfToken = ref(document.querySelector('meta[name="csrf-token"]')?.content || '')
defineEmits(['close'])
</script>
<template>
    <el-dialog>
        <dialog id="enrollDialog" aria-labelledby="dialog-title"
            class="fixed inset-0 size-sm max-h-none max-w-none overflow-y-auto bg-transparent backdrop:bg-transparent">
            <el-dialog-backdrop
                class="fixed inset-0 bg-gray-500/75 transition-opacity data-closed:opacity-0 data-enter:duration-300 data-enter:ease-out data-leave:duration-200 data-leave:ease-in"></el-dialog-backdrop>
            <div tabindex="0"
                class="flex min-h-full items-end justify-center p-4 text-center focus:outline-none sm:items-center sm:p-0">
                <el-dialog-panel
                    class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all data-closed:translate-y-4 data-closed:opacity-0 data-enter:duration-300 data-enter:ease-out data-leave:duration-200 data-leave:ease-in sm:my-8 sm:w-full sm:max-w-lg data-closed:sm:translate-y-0 data-closed:sm:scale-95">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                <form :action="route('company.store')" method="post" enctype="multipart/form-data"
                                    Accept="application/json" @submit="submitForm">
                                    <!-- token below:
                                    {{ csrfToken }} -->
                                    <input type="hidden" name="_token" :value="csrfToken">
                                    <div class="space-y-12">
                                        <div class="border-b border-gray-900/10 pb-12">
                                            <h2 class="text-base/7 font-semibold text-gray-900">Enroll Company
                                            </h2>
                                            <p class="mt-1 text-sm/6 text-gray-600">Please filled requred informatioon
                                                below(*).</p>
                                            <div class="mt-10 grid ">
                                                <div class="sm:col-span-4 py-2">
                                                    <label for="name"
                                                        class="block text-sm/6 font-medium text-gray-900">Company
                                                        Name</label>
                                                    <div class="mt-2">
                                                        <input id="name" type="text" name="name" required
                                                            autocomplete="given-name"
                                                            class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6" />
                                                    </div>
                                                </div>

                                                <div class="sm:col-span-4 py-2">
                                                    <label for="email"
                                                        class="block text-sm/6 font-medium text-gray-900">Email
                                                        address</label>
                                                    <div class="mt-2">
                                                        <input id="email" type="email" name="email" autocomplete="email"
                                                            required
                                                            class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6" />
                                                    </div>
                                                </div>

                                                <div class="sm:col-span-4 py-2 justify-center">
                                                    <label for="email"
                                                        class="block text-sm/6 font-medium text-gray-900">Logo</label>
                                                    <div class="mt-2">
                                                        <input id="logo" type="file" name="logo" required
                                                            class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 " />
                                                        <!-- preview akan di kerjakan nnti setelah utama selesai, below -->
                                                        <div
                                                            class="justify-center w-32 h-32 border-2 border-dashed border-gray-400 rounded-md overflow-hidden flex items-center justify-center">
                                                            <img id="logoPreview" src="" alt="Preview"
                                                                class="object-cover w-full h-full hidden" />
                                                            <span id="placeholderText"
                                                                class="text-gray-400 text-sm">Preview</span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="sm:col-span-4 py-2">
                                                    <label for="website"
                                                        class="block text-sm/6 font-medium text-gray-900">Website / Url
                                                        address</label>
                                                    <div class="mt-2">
                                                        <input id="website" type="text" name="website"
                                                            placeholder="must full format, example: http://google.com/"
                                                            autocomplete="website" required
                                                            class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 " />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mt-6 flex items-center justify-end gap-x-6">
                                        <button type="button" command="close" commandfor="enrollDialog"
                                            class="text-sm/6 font-semibold text-gray-900">Cancel</button>
                                        <button type="submit"
                                            class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                                            Submit</button>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </el-dialog-panel>
            </div>
        </dialog>
    </el-dialog>
</template>