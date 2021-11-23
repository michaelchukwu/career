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
                    <!-- <div id="top-search" class=" hidden relative w-full text-gray-600 px-6 lg:px-0">
                            <input v-model="term" @keyup="search" class="border-2 border-gray-300 bg-white h-10 mt-2 w-full px-5 pr-16 rounded-lg text-sm focus:outline-none"
                            type="search" name="search" placeholder="Search for your wallet">
                            <button @click="search" type="submit" class="absolute right-0 top-0 mt-5 lg:mr-4 mr-9">
                            <svg class="text-gray-600 h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg"
                                xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px"
                                viewBox="0 0 56.966 56.966" style="enable-background:new 0 0 56.966 56.966;" xml:space="preserve"
                                width="512px" height="512px">
                                <path
                                d="M55.146,51.887L41.588,37.786c3.486-4.144,5.396-9.358,5.396-14.786c0-12.682-10.318-23-23-23s-23,10.318-23,23  s10.318,23,23,23c4.761,0,9.298-1.436,13.177-4.162l13.661,14.208c0.571,0.593,1.339,0.92,2.162,0.92  c0.779,0,1.518-0.297,2.079-0.837C56.255,54.982,56.293,53.08,55.146,51.887z M23.984,6c9.374,0,17,7.626,17,17s-7.626,17-17,17  s-17-7.626-17-17S14.61,6,23.984,6z" />
                            </svg>
                            </button>
                    </div> -->
                </div>

            </div>
            <div class="bg-clear h-52 flex flex-column items-center">
                    <div class="max-w-7xl text-white text-3xl mx-auto">
                        Current Jobs
                    </div>
                </div>
        </header>
        <div class="relative items-top py-6 lg:bg-transparent bg-gray-100 dark:bg-gray-900 mb-4">
            <div class="max-w-7xl mx-auto">
                <div class="mx-auto px-6 grid xs:grid-cols-1 md:grid-cols-2 gap-2">
                    <div v-show="jobs.data.length == 0" class="text-2xl font-bold ml-7">
                        No Jobs Posted here
                    </div>

                    <Link v-for="job in allJobs.data" :key="job.id" :href="'/position/'+job.id" class="w-full px-2 py-2 bg-white border-b-4 border-green-400 cursor-pointer transform hover:border-green-300">
                        <div>
                            <div class="ml-3 flex flex-row items-center">
                                <div>
                                    <img src="https://nexianigeria.com/wp-content/uploads/2019/11/favicon.png" alt="">
                                </div>
                                <div class="ml-4 flex flex-col">
                                    <span class="text-car text-2xl font-semibold">{{job.title}}</span>
                                    <span class="text-gray-400 text-sm font-light">{{job.location}}</span>
                                </div>
                            </div>
                            <div v-if="job.description" class="ml-3 text-sm text-gray-500 font-light py-4 mb-2" v-html="job.description.substring(0,300)"></div>
                            <div class="flex justify-between border-t border-gray-200 pt-4 max-h-11 h-12">
                                <!-- <div v-show="job.salary!==null" class="ml-3 text-base font-semibold text-gray-500">&#8358;{{job.salary}}/{{job.salary_duration}}</div>
                                <div v-show="job.salary==null" class="ml-3 text-base font-semibold text-gray-500">Undisclosed </div> -->
                                <Link :href="'/position/'+job.id" class="ml-3 text-base flex items-center text-lnk font-semibold hover:text-gray-500">
                                View More
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                                </Link>
                            </div>
                        </div>
                    </Link>
                </div>
            </div>
        </div>

        <footer class="absolute bottom-0 items-center w-full flex justify-center px-12">
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
            jobs: Object,
            message: String
        },
        data(){
            return {
            allJobs:this.jobs,
            }
        },
        methods:{

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
