<template>
    <Head title="Welcome" />
    <div class="relative min-h-screen bg-gray-50">
        <header>
            <div id="top" class="grid lg:grid-cols-2 gap-4 py-2 bg-transparent w-full mb-10 items-center ">
                <div class="block lg:flex max-w-7xl mx-auto pt-12">
                    <div class="mx-auto lg:mx-6 px-6 lg:px-0 flex gap-3 items-center">
                        <Link href="/">
                            <img src="https://nexianigeria.com/wp-content/uploads/2019/11/nexia-logo-retina-scaled.png" alt="" class="h-16 w-72">
                        </Link>
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

                <div class="p-2 mb-4 text-lnk">
                    Please apply for only one job role.<br> Application for more than one role will disqualify the applicant.
                    <br>Deadline: <strong>30 Nov. 2021</strong>
                </div>

                <form @submit.prevent="submit">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                        <div v-if="job.has_first_name" class="mb-4">
                            <jet-label for="first_name" value="First Name" :required="true"/>
                            <jet-input id="first_name" type="text" class="mt-1 block w-full" v-model="form.first_name" :required="job.first_name_r" autofocus />
                        </div>
                        <div v-if="job.has_last_name" class="mb-4">
                            <jet-label for="last_name" value="Last Name" :required="true"/>
                            <jet-input id="last_name" type="text" class="mt-1 block w-full" v-model="form.last_name" :required="job.last_name_r" autofocus />
                        </div>
                        <div class="mb-4">
                            <jet-label for="Email" value="Email Address" :required="true"/>
                            <jet-input id="email" type="email" class="mt-1 block w-full border-gray-300 focus:border-green-300 focus:ring focus:ring-green-200 focus:ring-opacity-50 rounded-md shadow-sm" v-model="form.email" required autofocus />
                        </div>
                        <div v-if="job.has_phone" class="mb-4">
                            <jet-label for="phone" value="Phone Number" :required="job.phone_r"/>
                            <jet-input id="phone" type="tel" class="mt-1 block w-full" v-model="form.phone" :required="job.phone_r" autofocus />
                        </div>
                        <div v-if="job.has_age" class="mb-4">
                            <jet-label for="age" value="Age" :required="job.age_r"/>
                            <jet-input id="age" type="number" class="mt-1 block w-full border-gray-300 focus:border-green-300 focus:ring focus:ring-green-200 focus:ring-opacity-50 rounded-md shadow-sm" v-model="form.age" :required="job.age_r" autofocus />
                        </div>
                        <div v-if="job.has_dob" class="mb-4">
                            <jet-label for="dob" value="Date of birth" :required="job.dob_r" />
                            <jet-input id="dob" type="date" :required="job.dob_r" class="mt-1 block w-full border-gray-300 focus:border-green-300 focus:ring focus:ring-green-200 focus:ring-opacity-50 rounded-md shadow-sm" v-model="form.dob" autofocus />
                        </div>
                        <div v-if="job.has_gender" class="mb-4">
                            <jet-label for="gender" value="Gender" :required="job.gender_r"/>
                            <select v-model="form.gender" id="gender" :required="job.gender_r" class="mt-1 block w-full border-gray-300 focus:border-green-300 focus:ring focus:ring-green-200 focus:ring-opacity-50 rounded-md shadow-sm">
                                <option value="Female">Female</option>
                                <option value="Male">Male</option>
                            </select>
                            <!-- <textarea id="gender" class="mt-1 block w-full border-gray-300 focus:border-green-300 focus:ring focus:ring-green-200 focus:ring-opacity-50 rounded-md shadow-sm" v-model="form.gender"></textarea> -->
                        </div>
                        <div v-if="job.has_cv" class="mb-4">
                            <jet-label for="cv" value="CV" :required="job.cv_r" />
                            <jet-input id="cv" type="file" :required="job.cv_r" class="mt-1 block w-full" @input="form.cv = $event.target.files[0]"  autofocus accept=".doc,.docx,.pdf" />
                                <progress v-if="form.progress" :value="form.progress.percentage" max="100">
                                    {{ form.progress.percentage }}%
                                </progress>
                            <!-- <jet-input id="cv" type="file" class="mt-1 block w-full" v-model="form.cv"  autofocus /> -->
                        </div>
                        <div v-if="job.has_cover_letter" class="mb-4">
                            <jet-label for="cover_letter" :required="job.cover_letter_r" value="Cover Letter" />
                            <jet-input id="cover_letter" :required="job.cover_letter_r" type="file" class="mt-1 block w-full" @input="form.cover_letter = $event.target.files[0]" autofocus accept=".doc,.docx,.pdf" />
                                <progress v-if="form.progress" :value="form.progress.percentage" max="100">
                                    {{ form.progress.percentage }}%
                                </progress>
                            <!-- <jet-input id="cover_letter" type="file" class="mt-1 block w-full" v-model="form.cover_letter"  autofocus /> -->
                        </div>
                        <div v-if="job.has_linkedin" class="mb-4">
                            <jet-label for="linkedin" value="Linkedin URL" :required="job.linkedin_r" />
                            <jet-input id="linkedin" type="text" :required="job.linkedin_r" class="mt-1 block w-full" v-model="form.linkedin"  autofocus />
                        </div>
                        <div v-if="job.has_twitter" class="mb-4">
                            <jet-label for="twitter" value="Twitter Handle" :required="job.twitter_r"/>
                            <jet-input id="twitter" :required="job.twitter_r" type="text" class="mt-1 block w-full" v-model="form.twiiter"  autofocus />
                        </div>
                        <div v-if="job.has_facebook" class="mb-4">
                            <jet-label for="facebook" value="Facebook URL" :required="job.twitter_r" />
                            <jet-input id="facebook" type="text" :required="job.twitter_r" class="mt-1 block w-full" v-model="form.facebook"  autofocus />
                        </div>
                        <div v-if="job.has_website" class="mb-4">
                            <jet-label for="website" value="Website" ::required="job.website_r" />
                            <jet-input id="website" type="text" ::required="job.website_r" class="mt-1 block w-full" v-model="form.website"  autofocus />
                        </div>
                        <div v-if="job.has_image" class="mb-4">
                            <jet-label for="image" value="Image" :required="job.image_r" />
                            <jet-input id="image" type="file" :required="job.image_r" class="mt-1 block w-full" @input="form.image = $event.target.files[0]" autofocus />
                                <progress v-if="form.progress" :value="form.progress.percentage" max="100">
                                    {{ form.progress.percentage }}%
                                </progress>
                            <!-- <jet-input id="image" type="text" class="mt-1 block w-full" v-model="form.image"  autofocus /> -->
                        </div>
                        <div v-if="job.has_state" class="mb-4">
                            <jet-label for="state" value="State" :required="job.state_r" />
                            <jet-input id="state" type="text" :required="job.state_r" class="mt-1 block w-full" v-model="form.state"  autofocus />
                        </div>
                        <div v-if="job.has_city" class="mb-4">
                            <jet-label for="city" value="City" :required="city_r" />
                            <jet-input id="city" type="text" :required="city_r" class="mt-1 block w-full" v-model="form.city"  autofocus />
                        </div>
                        <div v-if="job.has_street" class="mb-4">
                            <jet-label for="street" value="Street" :required="job.street_r" />
                            <jet-input id="street" type="text" :required="job.street_r" class="mt-1 block w-full" v-model="form.street"  autofocus />
                        </div>
                        <div v-if="job.has_marital" class="mb-4">
                            <jet-label for="marital" value="Marital Status" :required="job.marital_r"/>
                            <select v-model="form.marital" id="marital" :required="job.marital_r" class="mt-1 block w-full border-gray-300 focus:border-green-300 focus:ring focus:ring-green-200 focus:ring-opacity-50 rounded-md shadow-sm">
                                <option value="Single">Single</option>
                                <option value="Married">Married</option>
                                <option value="Divorced">Divorced</option>
                                <option value="Seperated">Seperated</option>
                            </select>
                            <!-- <textarea id="gender" class="mt-1 block w-full border-gray-300 focus:border-green-300 focus:ring focus:ring-green-200 focus:ring-opacity-50 rounded-md shadow-sm" v-model="form.gender"></textarea> -->
                        </div>
                        <div v-if="job.has_state_of_origin" class="mb-4">
                            <jet-label for="state_of_origin" value="State of Origin" :required="job.state_of_origin_r"/>
                            <select v-model="form.state_of_origin" id="state_of_origin" :required="job.state_of_origin_r" class="mt-1 block w-full border-gray-300 focus:border-green-300 focus:ring focus:ring-green-200 focus:ring-opacity-50 rounded-md shadow-sm">
                                <option value="Single">Single</option>
                                <option value="Married">Married</option>
                                <option value="Divorced">Divorced</option>
                                <option value="Seperated">Seperated</option>
                            </select>
                            <!-- <textarea id="gender" class="mt-1 block w-full border-gray-300 focus:border-green-300 focus:ring focus:ring-green-200 focus:ring-opacity-50 rounded-md shadow-sm" v-model="form.gender"></textarea> -->
                        </div>
                        <div v-if="job.has_job_city" class="mb-4">
                            <jet-label for="job_city" value="Preferred City" :required="job.job_city_r"/>
                            <select v-model="form.job_city" id="job_city" :required="job.job_city_r" class="mt-1 block w-full border-gray-300 focus:border-green-300 focus:ring focus:ring-green-200 focus:ring-opacity-50 rounded-md shadow-sm">
                                <option value="Single">Single</option>
                                <option value="Married">Married</option>
                                <option value="Divorced">Divorced</option>
                                <option value="Seperated">Seperated</option>
                            </select>
                            <!-- <textarea id="gender" class="mt-1 block w-full border-gray-300 focus:border-green-300 focus:ring focus:ring-green-200 focus:ring-opacity-50 rounded-md shadow-sm" v-model="form.gender"></textarea> -->
                        </div>

                        <div v-if="job.has_exp_post" class="mb-4">
                            <jet-label for="exp_post" value="Years of Post Qualification Experience" :required="job.exp_post_r" />
                            <jet-input id="exp_post" type="number" :required="job.exp_post_r" class="mt-1 block w-full border-gray-300 focus:border-green-300 focus:ring focus:ring-green-200 focus:ring-opacity-50 rounded-md shadow-sm" v-model="form.exp_post"  autofocus />
                            <!-- <textarea id="exp_post" class="mt-1 block w-full border-gray-300 focus:border-green-300 focus:ring focus:ring-green-200 focus:ring-opacity-50 rounded-md shadow-sm" v-model="form.exp_post"></textarea> -->
                        </div>
                        <div v-if="job.has_experience" class="mb-4">
                            <jet-label for="experience" value="Years of Experience" :required="experience_r" />
                            <!-- <textarea id="experience" class="mt-1 block w-full border-gray-300 focus:border-green-300 focus:ring focus:ring-green-200 focus:ring-opacity-50 rounded-md shadow-sm" v-model="form.experience"></textarea> -->
                            <jet-input id="experience" type="number" :required="experience_r" class="mt-1 block w-full border-gray-300 focus:border-green-300 focus:ring focus:ring-green-200 focus:ring-opacity-50 rounded-md shadow-sm" v-model="form.experience"  autofocus />

                        </div>
                        <div v-if="job.has_first_degree" class="mb-4">
                            <jet-label for="first_degree" value="First Degree" :required="job.first_degree_r" />
                            <select v-model="form.first_degree" id="first_degree" :required="job.first_degree_r" class="mt-1 block w-full border-gray-300 focus:border-green-300 focus:ring focus:ring-green-200 focus:ring-opacity-50 rounded-md shadow-sm">
                                <option value="BSc">BSc</option>
                                <option value="HND">HND</option>
                                <option value="ND">OND</option>
                            </select>
                        </div>
                        <div v-if="job.has_first_course" class="mb-4">
                            <jet-label for="first_course" value="Course of Study" :required="job.first_course_r" />
                            <jet-input id="first_course" type="text" :required="job.first_course_r" class="mt-1 block w-full" v-model="form.first_course"  autofocus />

                        </div>
                        <div v-if="job.has_first_grade" class="mb-4">
                            <jet-label for="first_grade" value="Grade" :required="job.first_grade_r" />
                            <select v-model="form.first_grade" id="first_grade" :required="job.first_grade_r" class="mt-1 block w-full border-gray-300 focus:border-green-300 focus:ring focus:ring-green-200 focus:ring-opacity-50 rounded-md shadow-sm">
                                <option value="First Class ">First Class</option>
                                <option value="Second Class (upper division)">Second Class (upper division)</option>
                                <option value="Second Class (lower division)">Second Class (lower division)</option>
                                <option value="Third Class">Third Class</option>
                            </select>
                        </div>
                        <div v-if="job.has_second_degree" class="mb-4">
                            <jet-label for="second_degree" value="Other Degrees" :required="job.second_degree_r" />
                            <jet-input id="second_degree" type="text" :required="job.second_degree_r" class="mt-1 block w-full" v-model="form.second_degree"  autofocus />
                            <small class="text-xs text-gray-500 font-extralight">eg Master's, PhD</small>
                        </div>
                        <div v-if="job.has_professional" class="mb-4">
                            <jet-label for="professional" :required="job.professional_r" value="Professional Qualifications" />
                            <select v-model="form.professional" :required="job.professional_r" id="professional" class="mt-1 block w-full border-gray-300 focus:border-green-300 focus:ring focus:ring-green-200 focus:ring-opacity-50 rounded-md shadow-sm">
                                <option value="ACCA">ACCA</option>
                                <option value="ICAN">ICAN</option>
                                <option value="Both">Both</option>
                                <option value="None">None</option>
                            </select>
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
                            <div v-show="success" class="mb-4 font-lg text-sm bg-green-300 text-green-800 p-2">
                                <span>Your Application has been received, we will get back to you shortly</span>
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
        <footer class="absolute bottom-0 items-center w-full flex justify-center mt-4">
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
            success:false,
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
                    age : null,
                    dob : null,
                    gender : null,
                    exp_post : null,
                    experience : null,
                    first_degree : null,
                    first_grade : null,
                    first_course : null,
                    second_degree : null,
                    second_course : null,
                    third_degree : null,
                    third_course : null,
                    professional : null,
                    marital:null,
                    state_of_origin:null,
                    job_city:null,
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
                            this.success = true;
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
