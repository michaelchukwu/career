<template>
    <Head title="Welcome" />
    <div class="relative min-h-screen bg-gray-50">
        <header>
            <div id="top" class="grid lg:grid-cols-2 gap-4 py-2 bg-transparent w-full mb-10 items-center ">
                <div class="block lg:flex max-w-7xl mx-auto pt-12">
                    <div class="mx-auto lg:mx-6 px-6 lg:px-0 flex gap-3 items-center">
                        <img src="https://nexianigeria.com/wp-content/uploads/2019/11/nexia-logo-retina-scaled.png" alt="" class="h-16 w-72">
                    </div>
                </div>
            </div>
        </header>
        <Modal :show="showingModal" @close="showingModal = false">
            <div class="w-full mx-auto sm:max-w-7xl mt-6 px-6 py-4 bg-white overflow-hidden">
                <div class="text-xl font-bold mb-6">
                    <h2>Apply for the {{job.title}} position</h2>
                    <hr>
                </div>

                <div v-show="showError" v-for="error in errors" :key="error.error" class="mb-4 font-lg text-sm text-red-600">
                    <span v-for="err in error" :key="err.id">{{err}}</span>
                </div>
                <form @submit.prevent="submit">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                        <div v-show="job.has_first_name" class="mb-4">
                            <jet-label for="first_name" value="First Name" />
                            <jet-input id="first_name" type="text" class="mt-1 block w-full" v-model="form.first_name"  autofocus />
                        </div>
                        <div v-show="job.has_last_name" class="mb-4">
                            <jet-label for="last_name" value="Last Name" />
                            <jet-input id="last_name" type="text" class="mt-1 block w-full" v-model="form.last_name"  autofocus />
                        </div>
                        <div class="mb-4">
                            <jet-label for="Email" value="Email Address" :required="true"/>
                            <jet-input id="email" type="email" class="mt-1 block w-full border-gray-300 focus:border-green-300 focus:ring focus:ring-green-200 focus:ring-opacity-50 rounded-md shadow-sm" v-model="form.email" required autofocus />
                        </div>
                        <div v-show="job.has_phone" class="mb-4">
                            <jet-label for="phone" value="Phone Number" :required="job.phone_r"/>
                            <jet-input id="phone" type="tel" class="mt-1 block w-full" v-model="form.phone" req autofocus />
                        </div>
                        <div v-show="job.has_cv" class="mb-4">
                            <jet-label for="cv" value="CV" />
                            <jet-input id="cv" type="file" class="mt-1 block w-full" @input="form.cv = $event.target.files[0]"  autofocus />
                                <progress v-if="form.progress" :value="form.progress.percentage" max="100">
                                    {{ form.progress.percentage }}%
                                </progress>
                            <!-- <jet-input id="cv" type="file" class="mt-1 block w-full" v-model="form.cv"  autofocus /> -->
                        </div>
                        <div v-show="job.has_cover_letter" class="mb-4">
                            <jet-label for="cover_letter" value="Cover Letter" />
                            <jet-input id="cover_letter" type="file" class="mt-1 block w-full" @input="form.cover_letter = $event.target.files[0]"  autofocus />
                                <progress v-if="form.progress" :value="form.progress.percentage" max="100">
                                    {{ form.progress.percentage }}%
                                </progress>
                            <!-- <jet-input id="cover_letter" type="file" class="mt-1 block w-full" v-model="form.cover_letter"  autofocus /> -->
                        </div>
                        <div v-show="job.has_linkedin" class="mb-4">
                            <jet-label for="linkedin" value="Linkedin URL" />
                            <jet-input id="linkedin" type="text" class="mt-1 block w-full" v-model="form.linkedin"  autofocus />
                        </div>
                        <div v-show="job.has_twitter" class="mb-4">
                            <jet-label for="twitter" value="Twitter Handle" />
                            <jet-input id="twitter" type="text" class="mt-1 block w-full" v-model="form.twiiter"  autofocus />
                        </div>
                        <div v-show="job.has_facebook" class="mb-4">
                            <jet-label for="facebook" value="Facebook URL" />
                            <jet-input id="facebook" type="text" class="mt-1 block w-full" v-model="form.facebook"  autofocus />
                        </div>
                        <div v-show="job.has_website" class="mb-4">
                            <jet-label for="website" value="Website" />
                            <jet-input id="website" type="text" class="mt-1 block w-full" v-model="form.website"  autofocus />
                        </div>
                        <div v-show="job.has_image" class="mb-4">
                            <jet-label for="image" value="Image" />
                            <jet-input id="image" type="file" class="mt-1 block w-full" @input="form.image = $event.target.files[0]" autofocus />
                                <progress v-if="form.progress" :value="form.progress.percentage" max="100">
                                    {{ form.progress.percentage }}%
                                </progress>
                            <!-- <jet-input id="image" type="text" class="mt-1 block w-full" v-model="form.image"  autofocus /> -->
                        </div>
                        <div v-show="job.has_state" class="mb-4">
                            <jet-label for="state" value="State" />
                            <jet-input id="state" type="text" class="mt-1 block w-full" v-model="form.state"  autofocus />
                        </div>
                        <div v-show="job.has_city" class="mb-4">
                            <jet-label for="city" value="City" />
                            <jet-input id="first_name" type="text" class="mt-1 block w-full" v-model="form.city"  autofocus />
                        </div>
                        <div v-show="job.has_street" class="mb-4">
                            <jet-label for="street" value="Street" />
                            <jet-input id="first_name" type="text" class="mt-1 block w-full" v-model="form.street"  autofocus />
                        </div>
                    </div>

                    <div class="flex items-center justify-end mt-4">


                        <jet-button class="ml-4 bg-car" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                            Apply
                        </jet-button>
                    </div>
                </form>
            </div>
        </Modal>
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
                                    <button @click="apply()" class="flex items-center text-lnk">
                                    Apply Now
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-4 hover:ml-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                    </svg>
                                    </button>
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
                                    <!-- <div class="py-4 border-b border-gray-200">
                                        <div class="text-base text-gray-500 font-thin">Salary</div>
                                        <div @show="job.salary" class="text-xl text-black ">&#8358;{{job.salary}}/{{job.salary_duration}}</div>
                                    </div> -->
                                    <div class="py-4 border-b border-gray-200">
                                        <div class="text-base text-gray-500 font-thin">Type</div>
                                        <div class="text-xl text-black ">{{job.type.title}}</div>
                                    </div>

                                </div>

                            </div>
                            <div class="flex justify-between pt-4">
                                <button @click="apply()" class="flex items-center text-lnk ml-7">
                                    Apply Now
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-4 hover:ml-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <footer class="absolute bottom-0 items-center w-full flex justify-center">
            &copy; 2021 Nexia Abel Agbo &amp; Co.
        </footer>
    </div>
</template>
<style scoped>
    .slide-fade-enter-active {
        transition: all .5s ease;
    }
    .slide-fade-leave-active {
        transition: all .8s cubic-bezier(1.0, 0.5, 0.8, 1.0);
    }
    .slide-fade-enter, .slide-fade-leave-to
        /* .slide-fade-leave-active below version 2.1.8 */ {
        transform: translateX(10px);
        opacity: 0;
    }
</style>

<script>
    import { defineComponent } from 'vue'
    import { Head, Link } from '@inertiajs/inertia-vue3'
    import JetAuthenticationCard from '@/Jetstream/AuthenticationCard.vue'
    import JetAuthenticationCardLogo from '@/Jetstream/AuthenticationCardLogo.vue'
    import JetButton from '@/Jetstream/Button.vue'
    import JetInput from '@/Jetstream/Input.vue'
    import JetCheckbox from '@/Jetstream/Checkbox.vue'
    import JetLabel from '@/Jetstream/Label.vue'
    import JetValidationErrors from '@/Jetstream/ValidationErrors.vue';
    import Modal from '../Jetstream/Modal.vue';
    import _ from 'lodash';
    import Button from '../Jetstream/Button.vue'


    export default defineComponent({
        components: {
            Head,
            JetAuthenticationCard,
            JetAuthenticationCardLogo,
            JetButton,
            JetInput,
            JetCheckbox,
            JetLabel,
            JetValidationErrors,
            Link,
            Modal,
            Button,
        },
        props: {
            status: String,
            errors: Object,
            job: Object,
            message: String
        },
        data(){
            return {
            showingModal:false,
            otpModal:false,
            wallet:'',
            term:'',
            showError: false,
            custom:0,
            club:null,
            form: this.$inertia.form({
                    email : null,
                    phone : null,
                    first_name : null,
                    last_name : null,
                    linkedin : null,
                    twitter : null,
                    facebook : null,
                    website : null,
                    cv : null,
                    cover_letter : null,
                    image : null,
                    state : null,
                    city : null,
                    street : null,
                    job:this.job.id
                })
            }
        },
        methods:{
            apply(){
                this.showingModal = true
            },
            submit() {
                this.form
                    .transform(data => ({
                        ... data
                    }))
                    .post(this.route('apply'), {
                        onFinish: (response)=>{
                            console.log(response)

                        },
                        onSuccess: (response) => {
                            this.form.reset()
                            this.showingModal = false
                        }
                    })
            },
            loadMore(){

                axios.get(this.allJobs.next_page_url).then(response => {
                        this.allJobs = {
                            ...response.data,
                            data: [...this.allJobs.data, ...response.data.data]
                        }
                    })

            },
            search(){
                axios.get(route('home', {"term":this.term})).then(response => {
                        this.allJobs = {
                            ...response.data,
                            data: [ ...response.data.data]
                        }
                    })
            }
        },
        mounted(){
            window.addEventListener('scroll', (e)=>{
                if(document.documentElement.scrollTop >360){
                    document.getElementById('top').classList.replace('bg-transparent', 'bg-gray-500')
                    document.getElementById('top-search').classList.replace('hidden', 'block')
                    document.getElementById('logo-text').classList.replace('block', 'hidden')
                }else{
                    document.getElementById('top').classList.replace('bg-gray-500', 'bg-transparent')
                    document.getElementById('top-search').classList.replace('block', 'hidden')
                    document.getElementById('logo-text').classList.replace('hidden', 'block')
                }
            })
        }
        // mounted(){
        //     window.addEventListener('scroll', debounce((e)=>{
        //         let pixelsFromBottom = document.documentElement.offsetHeight-document.documentElement.scrollTop-window.innerHeight
        //         if(pixelsFromBottom < 2000){
        //             axios.get(this.allWallets.next_page_url).then(response => {
        //                 this.allWallets = {
        //                     ...response.data,
        //                     data: [...this.allWallets.data, ...response.data.data]
        //                 }
        //             })
        //         }
        //     },1000))
        // }
    })
</script>
