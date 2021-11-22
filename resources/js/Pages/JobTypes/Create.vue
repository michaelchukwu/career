<template>
    <app-layout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Create Job Post
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                    <div class="flex flex-col">
                        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                            <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                                <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg p-6">
                                    <div v-show="showError" v-for="error in errors" :key="error.error" class="mb-4 font-lg text-sm text-red-600">
                                        <span v-for="err in error" :key="err.id">{{err}}</span>
                                    </div>
                                    <form @submit.prevent="submit">
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                            <div class="mb-4">
                                                <jet-label for="title" value="Title" :required="true"/>
                                                <jet-input id="title" type="text" class="mt-1 block w-full" v-model="form.title" autofocus />
                                            </div>

                                            <div class="mb-4">
                                                <jet-label for="slug" value="Slug" />
                                                <jet-input id="slug" type="text" class="mt-1 block w-full" v-model="form.slug"  autofocus />
                                            </div>
                                        </div>
                                        <div class="flex items-center justify-end mt-4">
                                            <jet-button class="ml-4 bg-green-400" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                                Create
                                            </jet-button>

                                        </div>
                                    </form>
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
            job_types:Object,
            errors:Object
        },
        data(){
            return {
                allJobTypes:this.job_types,
                showingModal:false,
                accountWallet:null,
                accountName:null,
                accountKey:null,
                accountId:null,
                accountCreatedAt:null,
                accountIp:null,
                form: this.$inertia.form({
                    title:null,
                    slug:null,
                })
            }
        },
        methods:{
            submit() {
                this.form
                    .transform(data => ({
                        ... data
                    }))
                    .post(this.route('job-types.store'), {
                        onFinish: function(response){
                            console.log(response)
                            this.form.reset()
                        },
                        onSuccess: (response)=>{
                            this.form.reset()
                        }
                    })
            },
            del(id){
                this.$inertia.delete(`/job-types/${id}`, {
                    onBefore: () => confirm('Are you sure you want to delete this account?'),
                    onSuccess: (response) => this.allJobTypes = { ...response.props.job_types}
                })
            },
        }
    })
</script>
