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
                    <!-- <Link :href="route('export')" class="text-white bg-green-400 rounded px-3 py-2 mb-4">Export to Excel</Link> -->
                    <a href="/export" class="text-white bg-green-400 rounded px-3 py-2 mb-4">Export to Excel</a>
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
                                    Applicant's Name
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Applicant's Email
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Applicant's Grade
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Job Type
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Job Role
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Date of Application
                                    </th>
                                    <th scope="col" class="relative px-6 py-3">
                                    <span class="sr-only">View</span>
                                    </th>
                                </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                <tr v-for="app in allApplications.data" :key="app.id">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ app.id }}
                                            </div>

                                        </div>
                                    </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ app.first_name+' '+app.last_name }}</div>
                                     <!-- <div class="text-sm text-gray-500">{{ person.department }}</div>  -->
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <!-- <input type="text" class=" ring-0 border-0 focus:ring-0" :value="account.key" readonly :id="'i'+account.id"><button @click="copy('i'+account.id)"><img src="img/copy.png"></button> -->
                                    <div class="text-sm text-gray-900">{{ app.email }}</div>

                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <!-- <input type="text" class=" ring-0 border-0 focus:ring-0" :value="account.key" readonly :id="'i'+account.id"><button @click="copy('i'+account.id)"><img src="img/copy.png"></button> -->
                                    <div class="text-sm text-gray-900">{{ app.first_grade }}</div>

                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ app.job_type }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ app.job_title }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ app.created_at }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <!-- <Link :href="route('applications.edit', app.id)" class="text-green-600 hover:text-blue-900">Edit</Link> -->
                                    <Link :href="'applications/'+app.id" class="ml-2 text-blue-600 hover:text-blue-900">View</Link>
                                    <!-- <button v-show="job.is_live" @click="unpublish(job.jobs_id)" class="ml-2 text-yellow-600 hover:text-yellow-900">Unpublish</button>
                                    <button v-show="!job.is_live" @click="publish(job.jobs_id)" class="ml-2 text-green-600 hover:text-green-900">Publish</button> -->
                                    <!-- <button @click="del(job.jobs_id)" class="ml-2 text-red-600 hover:text-blue-900">Delete</button> -->
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <!-- <button @click="view(account.wallet.title, account.id, account.name, account.key, account.created_at, account.ip)" class="text-green-600 hover:text-green-900">View</button> -->
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            <pagination class="mt-6" :links="allApplications.links" />
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
    import Pagination from '@/Bits/Pagination'
    import { defineComponent } from 'vue'
    import AppLayout from '@/Layouts/AppLayout.vue'
    import { Head, Link } from '@inertiajs/inertia-vue3'

    export default defineComponent({
        components: {
            AppLayout,
            Link,
            Pagination
        },
        props:{
            applications:Object
        },
        data(){
            return {
                allApplications:this.applications,
            }
        },
        methods:{
            del(id){
                this.$inertia.delete(`/applications/${id}`, {
                    onBefore: () => confirm('Are you sure you want to delete this account?'),
                    onSuccess: (response) => this.allJobs = { ...response.props.applications}
                })
            },
            reject(id){
                this.$inertia.get(`/applications/reject/${id}`, {
                    // onBefore: () => confirm('Are you sure you want to delete this account?'),
                    onSuccess: (response) => this.allApplications = { ...response.props.applications}
                })
            },
            accept(id){
                this.$inertia.get(`/applications/accept/${id}`, {
                    // onBefore: () => confirm('Are you sure you want to delete this account?'),
                    onSuccess: (response) => this.allApplications = { ...response.props.applications}
                })
            }
        }
    })
</script>
