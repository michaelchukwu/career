<template>
    <app-layout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Create a Notice
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
                                                <jet-label for="description" value="Description" :required="false"/>
                                                <editor
                                                v-model="form.description"
                                                api-key="pxgt6rab2kw87reh2mxmvfw8azbfv9cb3vsjttv3ktlcbs2k"
                                                :init="{
                                                    height: 200,
                                                    menubar: false,
                                                    plugins: [
                                                    'advlist autolink lists link image charmap print preview anchor',
                                                    'searchreplace visualblocks code fullscreen',
                                                    'insertdatetime media table paste code help wordcount'
                                                    ],
                                                    toolbar:
                                                    'undo redo | formatselect | bold italic backcolor | \
                                                    alignleft aligncenter alignright alignjustify | \
                                                    bullist numlist outdent indent | removeformat | help'
                                                }"
                                                />
                                            </div>
                                            <div class="mb-4">
                                                <jet-label for="position" value="Position" :required="true"/>
                                                <select v-model="form.position" id="position" class="mt-1 block w-full border-gray-300 focus:border-green-300 focus:ring focus:ring-green-200 focus:ring-opacity-50 rounded-md shadow-sm" required>
                                                    <option value="1">Welcome Page Only</option>
                                                    <!-- <option value="2">View Page Only</option> -->
                                                    <option value="3">Application Form Only</option>
                                                    <option value="4">All</option>

                                                </select>
                                            </div>
                                            <div class="mb-4">
                                                <jet-label for="color" value="Text Color" :required="true"/>
                                                <select v-model="form.color" id="color" class="mt-1 block w-full border-gray-300 focus:border-green-300 focus:ring focus:ring-green-200 focus:ring-opacity-50 rounded-md shadow-sm" required>
                                                    <option value="text-lnk" class="text-lnk">Danger-red</option>
                                                    <option value="text-green-500" class="text-green-500">Success-green</option>

                                                </select>
                                            </div>
                                            <!-- <div class="mb-4 grid grid-cols-2 md:grid-cols-4">
                                                <jet-label for="select_all" value="Select All" :required="false"/>
                                                <jet-checkbox id="select_all" class="mt-1 block" v-model="selectAll"  autofocus />
                                            </div> -->
                                        </div>
                                        <div class="flex items-center justify-end mt-4">
                                            <jet-button class="ml-4 bg-green-400" @click="publish()" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                                Publish
                                            </jet-button>
                                            <!-- <jet-button class="ml-4 bg-blue-400" @click="draft()" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                                Save Draft
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
                select_all:false,
                form: this.$inertia.form({
                    title:null,
                    description:null,
                    position:null,
                    color:null
                })
            }
        },
        methods:{
            submit() {
                this.form
                    .transform(data => ({
                        ... data
                    }))
                    .post(this.route('notice.store'), {
                        onFinish: function(response){
                            console.log(response)
                            this.$toast.success({
                                message: "You have successfully created the stuff",
                                type: "success",
                                duration: 5000,
                                dismissible: true
                            })
                            this.form.reset()
                        }
                    })
            }
        }
    })
</script>
