<template>
    <app-layout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{job.title}}
            </h2>
        </template>

        <div class="py-12">
            <div class="relative items-top py-6 lg:bg-transparent bg-gray-100 dark:bg-gray-900 ">
            <div class="max-w-7xl mx-auto">
                <div class="mx-auto px-6">

                    <div class="w-full px-2 py-2">
                        <div>
                            <div class="ml-3 pb-4 md:flex md:flex-row items-center md:justify-between md:border-b md:border-gray-200 ">

                                <div class="ml-4 flex flex-col">
                                    <span class="text-black text-4xl font-semibold">{{job.title}} - Nexia Nigeria</span>
                                    <span class="text-gray-400 text-sm font-light">Location: {{job.location}}</span>
                                </div>
                                <div class="ml-4 mt-4 md:mt-0">
                                    <Link :href="route('jobs.edit', job.id)" class="flex items-center text-lnk">
                                    Edit
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-4 hover:ml-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                    </svg>
                                    </Link>
                                </div>
                            </div>
                            <div class="ml-7 my-7 text-sm grid grid-cols-1 md:grid-cols-3 gap-3 text-gray-500 font-light py-4">
                                <div class="col-span-2">
                                    <h2 class="mb-2 text-3xl font-semibold">Description</h2>
                                    <div v-html="job.description"></div>
                                </div>
                                <div class="bg-car text-gray-600 md:px-4">
                                    <h2 class="mb-2 font-semibold text-car text-2xl">Details</h2>
                                    <div class="py-4 border-b border-gray-200">
                                        <div class="text-base text-gray-500 font-thin">Location</div>
                                        <div class="text-xl text-black ">{{job.location}}</div>
                                    </div>
                                    <div class="py-4 border-b border-gray-200">
                                        <div class="text-base text-gray-500 font-thin">Salary</div>
                                        <div @show="job.salary" class="text-xl text-black ">&#8358;{{job.salary}}/{{job.salary_duration}}</div>
                                    </div>
                                    <div class="py-4 border-b border-gray-200">
                                        <div class="text-base text-gray-500 font-thin">Type</div>
                                        <div class="text-xl text-black ">{{job_type.title}}</div>
                                    </div>

                                </div>

                            </div>
                            <div class="flex justify-between pt-4">
                                <Link :href="route('jobs.edit', job.id)" class="flex items-center text-lnk ml-7">
                                    Edit
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-4 hover:ml-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                    </svg>
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>
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
    import JetAuthenticationCard from '@/Jetstream/AuthenticationCard.vue'
    import JetAuthenticationCardLogo from '@/Jetstream/AuthenticationCardLogo.vue'
    import JetButton from '@/Jetstream/Button.vue'
    import JetInput from '@/Jetstream/Input.vue'
    import JetCheckbox from '@/Jetstream/Checkbox.vue'
    import JetLabel from '@/Jetstream/Label.vue'
    import JetValidationErrors from '@/Jetstream/ValidationErrors.vue';
    import _ from 'lodash';
    import Button from '../../Jetstream/Button.vue'
    import VueToast from 'vue-toast-notification';
    import 'vue-toast-notification/dist/theme-sugar.css';
    import Editor from '@tinymce/tinymce-vue'

    export default defineComponent({
        components: {
            AppLayout,
            Modal,
            Head,
            JetAuthenticationCard,
            JetAuthenticationCardLogo,
            JetButton,
            JetInput,
            JetCheckbox,
            JetLabel,
            JetValidationErrors,
            Link,
            Button,
            VueToast,
            'editor':Editor

        },
        props:{
            job:Object,
            job_type:Object,
            errors:Object
        },
        data(){
            return {
                allJobTypes:this.job_types,
                showingModal:false,
                select_all:false,
                form: this.$inertia.form({
                    title:null,
                    type:null,
                    description:null,
                    location:null,
                    slug:null,
                    is_live:false,
                    salary:null,
                    salary_duration:null,
                    can_expire:false,
                    goes_live:null,
                    expires:null,
                    has_phone:false,
                    has_first_name:false,
                    has_last_name:false,
                    has_linkedin:false,
                    has_twitter:false,
                    has_facebook:false,
                    has_website:false,
                    has_cv:false,
                    has_cover_letter:false,
                    has_image:false,
                    has_state:false,
                    has_city:false,
                    has_street:false,
                    phone_r:false,
                    first_name_r:false,
                    last_name_r:false,
                    linkedin_r:false,
                    twitter_r:false,
                    facebook_r:false,
                    website_r:false,
                    cv_r:false,
                    cover_letter_r:false,
                    image_r:false,
                    state_r:false,
                    city_r:false,
                    street_r:false
                })
            }
        },
        methods:{
            publish() {
                this.form.is_live = true
            },
            submit() {
                this.form
                    .transform(data => ({
                        ... data
                    }))
                    .post(this.route('jobs.store'), {
                        onFinish: function(response){
                            console.log(response)
                            this.$toast.success({
                                message: "You have successfully applied to this job",
                                type: "success",
                                duration: 5000,
                                dismissible: true
                            })
                            this.form.reset()
                        }
                    })
            },
            del(id){
                this.$inertia.delete(`/account/${id}`, {
                    onBefore: () => confirm('Are you sure you want to delete this account?'),
                    onSuccess: (response) => this.allAccounts = { ...response.props.accounts}
                })
            }
        }
    })
</script>
