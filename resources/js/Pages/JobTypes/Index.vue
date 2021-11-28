<template>
    <app-layout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="flex justify-end px-4">
                    <Link :href="route('job-types.create')" class="text-white bg-green-400 rounded px-3 py-2 mb-4">Create</Link>
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
                                    Title
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Slug
                                    </th>

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
                                                {{ job.id }}
                                            </div>

                                        </div>
                                    </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ job.title }}</div>
                                     <!-- <div class="text-sm text-gray-500">{{ person.department }}</div>  -->
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <!-- <input type="text" class=" ring-0 border-0 focus:ring-0" :value="account.key" readonly :id="'i'+account.id"><button @click="copy('i'+account.id)"><img src="img/copy.png"></button> -->
                                    <div class="text-sm text-gray-900">{{ job.slug }}</div>

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
                            <pagination class="mt-6" :links="allJobs.links" />
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
    import Pagination from '@/Bits/Pagination'

    export default defineComponent({
        components: {
            AppLayout,
            Modal,
            Link,
            Pagination
        },
        props:{
            job_types:Object
        },
        data(){
            return {
                allJobs:this.job_types,
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
