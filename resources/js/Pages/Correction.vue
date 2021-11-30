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
                                            <div>
                                                <jet-label for="email" value="Email" :required="true"/>
                                                <select v-model="form.email" id="email" :required="true" class="mt-1 block w-full border-gray-300 focus:border-green-300 focus:ring focus:ring-green-200 focus:ring-opacity-50 rounded-md shadow-sm">
                                                    <option v-for="app in all" :key="app.id" :value="app.email">{{app.first_name}} - {{app.email}}</option>
                                                </select>
                                            </div>
                                            <div>
                                                <jet-label for="grade" value="Grade" :required="true"/>
                                                <select v-model="form.grade" id="grade" :required="true" class="mt-1 block w-full border-gray-300 focus:border-green-300 focus:ring focus:ring-green-200 focus:ring-opacity-50 rounded-md shadow-sm">
                                                    <option value="First Class ">First Class</option>
                                                    <option value="Second Class (upper division)">Second Class (upper division)</option>
                                                    <option value="Second Class (lower division)">Second Class (lower division)</option>
                                                    <option value="Third Class">Third Class</option>
                                                </select>
                                            </div>

                                        </div>
                                        <div class="flex items-center justify-end mt-4">
                                            <jet-button class="ml-4 bg-green-400" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                                Update
                                            </jet-button>
                                            <!-- <jet-button class="ml-4 bg-blue-400" @click.prevent="search()" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                                Search
                                            </jet-button> -->
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
    import Modal from '../Jetstream/Modal.vue';
    import { Head, Link } from '@inertiajs/inertia-vue3'
    import JetAuthenticationCard from '@/Jetstream/AuthenticationCard.vue'
    import JetAuthenticationCardLogo from '@/Jetstream/AuthenticationCardLogo.vue'
    import JetButton from '@/Jetstream/Button.vue'
    import JetInput from '@/Jetstream/Input.vue'
    import JetCheckbox from '@/Jetstream/Checkbox.vue'
    import JetLabel from '@/Jetstream/Label.vue'
    import JetValidationErrors from '@/Jetstream/ValidationErrors.vue';
    import _ from 'lodash';
    import Button from '../Jetstream/Button.vue'
    import VueToast from 'vue-toast-notification';
    import 'vue-toast-notification/dist/theme-sugar.css';
    import Editor from '@tinymce/tinymce-vue'
import axios from 'axios';

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
            applicants:Object,
            errors:Object
        },
        data(){
            return {
                applicant:null,
                all:this.applicants,
                form: this.$inertia.form({
                    email:null,
                    grade:null,
                })
            }
        },
        methods:{
            submit() {
                axios.get(route('c2rt', {"email":this.form.email, "grade":this.form.grade})).then(response => {
                    console.log(...response.data)
                    this.all = {...response.data}
                    this.form.reset()
                    console.log(this.applicant)
                })
            },
            // submit() {
            //     this.form
            //         .transform(data => ({
            //             ... data
            //         }))
            //         .get(this.route('c2rt'), {
            //             onFinish: function(response){
            //                 this.form.reset()
            //             }
            //         })
            // }
        }
    })
</script>
