<template>
    <app-layout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Edit {{job.title}}
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
                                                <jet-label for="type" value="Employment Type" :required="true"/>
                                                <select v-model="form.type" id="type" class="mt-1 block w-full border-gray-300 focus:border-green-300 focus:ring focus:ring-green-200 focus:ring-opacity-50 rounded-md shadow-sm" required>
                                                     <option selected="selected" :value="job_type.id">{{job_type.title}}</option>
                                                    <option v-for="type in allJobTypes" :key="type.id" :value="type.id">{{type.title}}</option>
                                                </select>
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
                                            <div class="mb-4 grid grid-cols-2 gap-2">
                                                <div>
                                                    <jet-label for="salary" value="Salary" :required="true"/>
                                                    <jet-input id="salary" type="number" class="mt-1 block w-full border-gray-300 focus:border-green-300 focus:ring focus:ring-green-200 focus:ring-opacity-50 rounded-md shadow-sm" v-model="form.salary" autofocus />
                                                </div>
                                                <div>
                                                    <jet-label for="duration" value="Duration" :required="true"/>
                                                    <select v-model="form.salary_duration" id="duration" class="mt-1 block w-full border-gray-300 focus:border-green-300 focus:ring focus:ring-green-200 focus:ring-opacity-50 rounded-md shadow-sm" required>
                                                        <option selected="selected" :value="job.salary_duration">{{job.salary_duration}}</option>
                                                        <option value="Year">Year</option>
                                                        <option value="Month">Month</option>
                                                        <option value="Day">Day</option>
                                                        <option value="Hour">Hour</option>

                                                    </select>
                                                </div>
                                            </div>
                                            <div class="mb-4">
                                                <jet-label for="location" value="Location" :required="true"/>
                                                <jet-input id="location" type="text" class="mt-1 block w-full" v-model="form.location" required autofocus />
                                            </div>
                                            <div class="mb-4">
                                                <jet-label for="slug" value="Slug" />
                                                <jet-input id="slug" type="text" class="mt-1 block w-full" v-model="form.slug"  autofocus />
                                            </div>
                                            <div class="mb-4 grid grid-cols-2 md:grid-cols-4">
                                                <jet-label for="cover_letter" value="Cover Letter" :required="true"/>
                                                <jet-checkbox id="cover_letter" class="mt-1 block" v-model="form.has_cover_letter"  autofocus />
                                                <jet-label for="cover_letter_r" value="Required" />
                                                <jet-checkbox id="cover_letter_r" class="mt-1 block" v-model="form.cover_letter_r"  autofocus />
                                            </div>
                                            <div class="mb-4 grid grid-cols-2 md:grid-cols-4">
                                                <jet-label for="cv" value="CV" :required="true"/>
                                                <jet-checkbox id="cv" class="mt-1 block" v-model="form.has_cv"  autofocus />
                                                <jet-label for="cv_r" value="Required" />
                                                <jet-checkbox id="cv_r" class="mt-1 block" v-model="form.cv_r"  autofocus />
                                            </div>
                                            <div class="mb-4 grid grid-cols-2 md:grid-cols-4">
                                                <jet-label for="has_phone" value="Phone" :required="true"/>
                                                <jet-checkbox id="phone" class="mt-1 block" v-model="form.has_phone"  autofocus />
                                                <jet-label for="phone_r" value="Required" />
                                                <jet-checkbox id="phone_r" class="mt-1 block" v-model="form.has_phone"  autofocus />
                                            </div>
                                            <div class="mb-4 grid grid-cols-2 md:grid-cols-4">
                                                <jet-label for="has_first_name" value="First Name" :required="true"/>
                                                <jet-checkbox id="has_first_name" class="mt-1 block" v-model="form.has_first_name"  autofocus />
                                                <jet-label for="first_name_r" value="Required" />
                                                <jet-checkbox id="first_name_r" class="mt-1 block" v-model="form.first_name_r"  autofocus />
                                            </div>
                                            <div class="mb-4 grid grid-cols-2 md:grid-cols-4">
                                                <jet-label for="has_last_name" value="Last Name" :required="true"/>
                                                <jet-checkbox id="has_last_name" class="mt-1 block" v-model="form.has_last_name"  autofocus />
                                                <jet-label for="last_name_r" value="Required" />
                                                <jet-checkbox id="last_name_r" class="mt-1 block" v-model="form.last_name_r"  autofocus />
                                            </div>
                                            <div class="mb-4 grid grid-cols-2 md:grid-cols-4">
                                                <jet-label for="has_linkedin" value="Linkedin" :required="true"/>
                                                <jet-checkbox id="has_linkedin" class="mt-1 block" v-model="form.has_linkedin"  autofocus />
                                                <jet-label for="linkedin_r" value="Required" />
                                                <jet-checkbox id="linkedin_r" class="mt-1 block" v-model="form.linkedin_r"  autofocus />
                                            </div>
                                            <div class="mb-4 grid grid-cols-2 md:grid-cols-4">
                                                <jet-label for="has_twitter" value="Twitter" :required="true"/>
                                                <jet-checkbox id="has_twitter" class="mt-1 block" v-model="form.has_twitter"  autofocus />
                                                <jet-label for="twitter_r" value="Required" />
                                                <jet-checkbox id="twitter_r" class="mt-1 block" v-model="form.twitter_r"  autofocus />
                                            </div>
                                            <div class="mb-4 grid grid-cols-2 md:grid-cols-4">
                                                <jet-label for="has_facebook" value="Facebook" :required="true"/>
                                                <jet-checkbox id="has_facebook" class="mt-1 block" v-model="form.has_facebook"  autofocus />
                                                <jet-label for="facebook_r" value="Required" />
                                                <jet-checkbox id="facebook_r" class="mt-1 block" v-model="form.facebook_r"  autofocus />
                                            </div>
                                            <div class="mb-4 grid grid-cols-2 md:grid-cols-4">
                                                <jet-label for="has_website" value="Website" :required="true"/>
                                                <jet-checkbox id="has_website" class="mt-1 block" v-model="form.has_website"  autofocus />
                                                <jet-label for="website_r" value="Required" />
                                                <jet-checkbox id="website_r" class="mt-1 block" v-model="form.website_r"  autofocus />
                                            </div>
                                            <div class="mb-4 grid grid-cols-2 md:grid-cols-4">
                                                <jet-label for="has_image" value="Image" :required="true"/>
                                                <jet-checkbox id="has_image" class="mt-1 block" v-model="form.has_image"  autofocus />
                                                <jet-label for="image_r" value="Required" />
                                                <jet-checkbox id="image_r" class="mt-1 block" v-model="form.image_r"  autofocus />
                                            </div>
                                            <div class="mb-4 grid grid-cols-2 md:grid-cols-4">
                                                <jet-label for="has_state" value="State" :required="true"/>
                                                <jet-checkbox id="has_state" class="mt-1 block" v-model="form.has_state"  autofocus />
                                                <jet-label for="state_r" value="Required" />
                                                <jet-checkbox id="state_r" class="mt-1 block" v-model="form.state_r"  autofocus />
                                            </div>
                                            <div class="mb-4 grid grid-cols-2 md:grid-cols-4">
                                                <jet-label for="has_city" value="City" :required="true"/>
                                                <jet-checkbox id="has_city" class="mt-1 block" v-model="form.has_city"  autofocus />
                                                <jet-label for="city_r" value="Required" />
                                                <jet-checkbox id="city_r" class="mt-1 block" v-model="form.city_r"  autofocus />
                                            </div>
                                            <div class="mb-4 grid grid-cols-2 md:grid-cols-4">
                                                <jet-label for="has_street" value="Street" :required="true"/>
                                                <jet-checkbox id="has_street" class="mt-1 block" v-model="form.has_street"  autofocus />
                                                <jet-label for="street_r" value="Required" />
                                                <jet-checkbox id="street_r" class="mt-1 block" v-model="form.street_r"  autofocus />
                                            </div>
                                            <!-- <div class="mb-4 grid grid-cols-2 md:grid-cols-4">
                                                <jet-label for="select_all" value="Select All" :required="false"/>
                                                <jet-checkbox id="select_all" class="mt-1 block" v-model="selectAll"  autofocus />
                                            </div> -->
                                        </div>
                                        <div class="flex items-center justify-end mt-4">
                                            <jet-button class="ml-4 bg-green-400" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                                Update
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
            job:Object,
            job_type:Object,
            job_types:Object,
            errors:Object
        },
        data(){
            return {
                allJobTypes:this.job_types,
                showingModal:false,
                select_all:false,
                form: this.$inertia.form({
                    title:this.job.title,
                    type:this.job_type,
                    description:this.job.description,
                    location:this.job.location,
                    slug:this.job.slug,
                    is_live:this.job.is_live,
                    salary:this.job.salary,
                    salary_duration:this.job.salary_duration,
                    can_expire:this.job.can_expire,
                    goes_live:this.job.goes_live,
                    expires:this.job.expires,
                    has_phone:this.job.has_phone,
                    has_first_name:this.job.has_first_name,
                    has_last_name:this.job.has_last_name,
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
                    .put(this.route('jobs.update', this.job.id), {
                        onFinish: function(response){
                            console.log(response)
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
