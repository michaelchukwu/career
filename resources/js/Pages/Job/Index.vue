<template>
    <app-layout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>

        <div class="py-12">
             <Modal :show="showingModal" @close="showingModal = false">
                    <div class="w-full mx-auto sm:max-w-md mt-6 px-6 py-4 bg-white overflow-hidden">
                        <!-- <div class="text-xl font-bold mb-6">
                            <h2>{{ accountName }}</h2>
                            <hr>
                        </div>

                        <div class="flex gap-3">
                            <span>Account Name: </span>
                            <span>{{ accountName }}</span>
                        </div>
                        <div class="flex gap-3">
                            <span>Account Key: </span>
                            <span>{{ accountKey }}</span>
                        </div>
                        <div class="flex gap-3">
                            <span>Wallet: </span>
                            <span>{{ accountWallet }}</span>
                        </div>
                        <div class="flex gap-3">
                            <span>created at: </span>
                            <span>{{ accountCreatedAt }}</span>
                        </div> -->
                        <!-- <div v-show="showError" v-for="error in errors" :key="error.error" class="mb-4 font-lg text-sm text-red-600">
                            <span v-for="err in error" :key="err.id">{{err}}</span>
                        </div>-->
<!--
                        <form @submit.prevent="submit">
                            <div class="mb-4">
                                <jet-label for="name" value="Wallet Name" />
                                <jet-input id="name" type="text" class="mt-1 block w-full" v-model="name" required autofocus />
                            </div>
                            <div>
                                <jet-label for="image" value="Image" />
                                <jet-input id="image" type="file" class="mt-1 block w-full" @input="form.image = $event.target.files[0]" required autofocus />
                                <progress v-if="form.progress" :value="form.progress.percentage" max="100">
                                    {{ form.progress.percentage }}%
                                </progress>
                            </div>




                            <div class="flex items-center justify-end mt-4">


                                <jet-button class="ml-4 bg-blue-700" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                    Create
                                </jet-button>
                            </div>
                        </form> -->
                    </div>
                </Modal>
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="flex justify-end px-4">
                    <Link :href="route('jobs.create')" class="text-white bg-green-400 rounded px-3 py-2 mb-4">Create</Link>
                </div>
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                    <div class="flex flex-col">
                        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                            <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    ID
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Job Title
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Job Type
                                    </th>
                                    <!-- <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status
                                    </th> -->
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Date of creation
                                    </th>
                                    <th scope="col" class="relative px-6 py-3">
                                    <span class="sr-only">View</span>
                                    </th>
                                </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                <tr v-for="job in allJobs.data" :key="job.id">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ job.jobs_id }}
                                            </div>

                                        </div>
                                    </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ job.jobs_title }}</div>
                                     <!-- <div class="text-sm text-gray-500">{{ person.department }}</div>  -->
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <!-- <input type="text" class=" ring-0 border-0 focus:ring-0" :value="account.key" readonly :id="'i'+account.id"><button @click="copy('i'+account.id)"><img src="img/copy.png"></button> -->
                                    <div class="text-sm text-gray-900">{{ job.job_types_title }}</div>

                                    </td>
                                    <!-- <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ job }}</td> -->
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ job.created_at }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <Link class="text-green-600 hover:text-blue-900">Edit</Link>
                                    <Link class="ml-2 text-blue-600 hover:text-blue-900">View</Link>
                                    <button @click="del(job.id)" class="ml-2 text-red-600 hover:text-blue-900">Delete</button>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <!-- <button @click="view(account.wallet.title, account.id, account.name, account.key, account.created_at, account.ip)" class="text-green-600 hover:text-green-900">View</button> -->
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            </div>
                        </div>
                        </div>
                    </div>
                    <!-- <accounts /> -->
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import { defineComponent } from 'vue'
    import AppLayout from '@/Layouts/AppLayout.vue'
    import Modal from '../../Jetstream/Modal.vue';
    import { Head, Link } from '@inertiajs/inertia-vue3'

    export default defineComponent({
        components: {
            AppLayout,
            Modal,
            Link
        },
        props:{
            jobs:Object
        },
        data(){
            return {
                allJobs:this.jobs,
                showingModal:false,
                accountWallet:null,
                accountName:null,
                accountKey:null,
                accountId:null,
                accountCreatedAt:null,
                accountIp:null
            }
        },
        methods:{
            copy(id){
                var copyText = document.getElementById(id)
                /* Select the text field */
                copyText.select();
                copyText.setSelectionRange(0, 99999); /* For mobile devices */

                /* Copy the text inside the text field */
                navigator.clipboard.writeText(copyText.value);

                /* Alert the copied text */
                alert("Copied the text: " + copyText.value);
            },
            del(id){
                this.$inertia.delete(`/account/${id}`, {
                    onBefore: () => confirm('Are you sure you want to delete this account?'),
                    onSuccess: (response) => this.allAccounts = { ...response.props.accounts}
                })
            },
            view(wallet, id, name, key, created_at, ip){
                this.showingModal = true
                this.accountWallet = wallet
                this.accountId = id
                this.accountName = name
                this.accountCreatedAt = created_at
                this.accountKey = key
                this.accountIp = ip
                console.log(this.showingModal)
            }
        }
    })
</script>
