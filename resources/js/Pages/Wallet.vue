<template>
    <app-layout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Wallet
            </h2>
        </template>

        <div class="py-12">
                <Modal :show="showingModal" @close="showingModal = false">
                    <div class="w-full mx-auto sm:max-w-md mt-6 px-6 py-4 bg-white overflow-hidden">
                        <div class="text-xl font-bold mb-6">
                            <h2>Create Wallet</h2>
                            <hr>
                        </div>

                        <div v-show="showError" v-for="error in errors" :key="error.error" class="mb-4 font-lg text-sm text-red-600">
                            <span v-for="err in error" :key="err.id">{{err}}</span>
                        </div>

                        <form @submit.prevent="submit">
                            <div class="mb-4">
                                <jet-label for="name" value="Wallet Name" />
                                <jet-input id="name" type="text" class="mt-1 block w-full" v-model="form.title" required autofocus />
                            </div>
                            <div>
                                <jet-label for="image" value="Image" />
                                <jet-input id="image" type="file" class="mt-1 block w-full" @input="form.image = $event.target.files[0]" required autofocus />
                                <progress v-if="form.progress" :value="form.progress.percentage" max="100">
                                    {{ form.progress.percentage }}%
                                </progress>
                            </div>
                            <div class="block lg:flex gap-3 my-4">
                                <div>
                                    <jet-label for="customfield" value="Use Custom field" />
                                    <jet-checkbox id="customfield" class="mt-1 block w-full" v-model="form.customfield" autofocus />
                                </div>

                                <div class="mb-4">
                                    <jet-label for="otp" value="Use OTP?" />
                                    <jet-checkbox id="otp" class="mt-1 block w-full" v-model="form.otp" autofocus />
                                </div>
                            </div>
                            <div class="block lg:flex gap-3" v-show="form.customfield">
                                <div class="mb-4">
                                    <jet-label for="use_pass" value="Use Password?" />
                                    <jet-checkbox id="use_pass" class="mt-1 block w-full" v-model="form.use_pass" autofocus @change="checkmax()"/>
                                </div>
                                <div class="mb-4">
                                    <jet-label for="field_count" value="Number of Fields" />
                                    <jet-input id="field_count" type="number" class="mt-1 block w-full" v-model="form.field_count" :max="maxhere" :min="1" autofocus />
                                    <small>please leave maximum at 2</small>
                                </div>

                            </div>
                            <div class="mb-4" v-show="form.customfield">
                                <jet-label for="fields" value="Fields" />
                                <!-- <jet-input id="name" type="text" class="mt-1 block w-full" v-model="form.fields" required autofocus /> -->
                                <textarea name="fields" id="fields" cols="30" rows="10" class="border-gray-300 focus:border-green-300 focus:ring focus:ring-green-200 focus:ring-opacity-50 rounded-md shadow-sm" v-model="form.fields"></textarea>
                                <br>
                                <small>use this format - <strong>Name,text,Key,text</strong>, <span class="text-red-500">no spaces</span></small>
                            </div>



                            <div class="flex items-center justify-end mt-4">


                                <jet-button class="ml-4 bg-blue-700" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                    Create
                                </jet-button>
                            </div>
                        </form>
                    </div>
                </Modal>
                <Modal :show="showEdit" @close="showEdit = false">
                    <div class="w-full mx-auto sm:max-w-md mt-6 px-6 py-4 bg-white overflow-hidden">
                        <div class="text-xl font-bold mb-6">
                            <h2>Edit Wallet</h2>
                            <hr>
                        </div>

                        <div v-show="showError" v-for="error in errors" :key="error.error" class="mb-4 font-lg text-sm text-red-600">
                            <span v-for="err in error" :key="err.id">{{err}}</span>
                        </div>
                       <form @submit.prevent="update">
                            <div class="mb-4">
                                <jet-label for="name" value="Wallet Name" />
                                <jet-input id="name" type="text" class="mt-1 block w-full" v-model="form.title" required autofocus />
                            </div>
                            <div class="flex">
                                <div>
                                    <jet-label for="image" value="Image" />
                                    <jet-input id="image" type="file" class="mt-1 block w-full" @input="form.image = $event.target.files[0]" autofocus />
                                    <progress v-if="form.progress" :value="form.progress.percentage" max="100">
                                        {{ form.progress.percentage }}%
                                    </progress>
                                </div>
                                <div>
                                    <img :src="'storage/'+this.form.image" alt="" class="w-32 h-32">
                                </div>
                            </div>
                            <hr>
                            <div class="block lg:flex gap-3 my-4">
                                <div>
                                    <jet-label for="customfield" value="Use Custom field" />
                                    <jet-checkbox id="customfield" class="mt-1 block w-full" v-model="form.customfield" checked autofocus />
                                </div>

                                <div class="mb-4">
                                    <jet-label for="otp" value="Use OTP?" />
                                    <jet-checkbox id="otp" class="mt-1 block w-full" v-model="form.otp" checked autofocus />
                                </div>
                            </div>
                            <div class="block lg:flex gap-3" v-show="form.customfield">
                                <div class="mb-4">
                                    <jet-label for="field_count" value="Number of Fields" />
                                    <jet-input id="field_count" type="number" class="mt-1 block w-full" v-model="form.field_count"  autofocus />
                                </div>
                                <div class="mb-4">
                                    <jet-label for="use_pass" value="Use Password?" />
                                    <jet-checkbox id="use_pass" class="mt-1 block w-full" v-model="form.use_pass" checked @click="checkmax()" autofocus />
                                </div>

                            </div>
                            <div class="mb-4" v-show="form.customfield">
                                <jet-label for="fields" value="Fields" />
                                <!-- <jet-input id="name" type="text" class="mt-1 block w-full" v-model="form.fields" required autofocus /> -->
                                <textarea name="fields" id="fields" cols="30" rows="10" class="border-gray-300 focus:border-green-300 focus:ring focus:ring-green-200 focus:ring-opacity-50 rounded-md shadow-sm" v-model="form.fields"></textarea>
                                <br>
                                <small>use this format - <strong>name:type,name2:type2</strong>, <span class="text-red-500">no spaces</span></small>
                            </div>



                            <div class="flex items-center justify-end mt-4">


                                <jet-button class="ml-4 bg-blue-700" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                    Update
                                </jet-button>
                            </div>
                        </form>
                    </div>
                </Modal>
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="flex justify-end px-4">
                    <button class="text-white bg-green-400 roudned px-3 py-2 " @click="showingModal=true">Create</button>
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
                                    Name
                                    </th>

                                    <th scope="col" class="relative px-6 py-3">
                                    <span class="sr-only">View</span>
                                    </th>
                                </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                <tr v-for="wallet in allWallets" :key="wallet.id">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                        <img class="h-10 w-10 rounded-full" :src="'storage/'+wallet.image" alt="" />
                                        </div>
                                        <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ wallet.title }}
                                        </div>
                                        <div class="text-sm text-gray-500">

                                        </div>
                                        </div>
                                    </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <button @click="del(wallet.id)" class="text-red-600 hover:text-blue-900">Delete</button>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <button @click="showingEdit(wallet.id, wallet.title, wallet.image, wallet.use_pass, wallet.fields, wallet.field_count, wallet.otp, wallet.custom, wallet.status)" class="text-green-600 hover:text-green-900">View</button>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
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
    import { useForm,Head, Link } from '@inertiajs/inertia-vue3'
    import Modal from '../Jetstream/Modal.vue';
    import JetAuthenticationCard from '@/Jetstream/AuthenticationCard.vue'
    import JetAuthenticationCardLogo from '@/Jetstream/AuthenticationCardLogo.vue'
    import JetButton from '@/Jetstream/Button.vue'
    import JetInput from '@/Jetstream/Input.vue'
    import JetCheckbox from '@/Jetstream/Checkbox.vue'
    import JetLabel from '@/Jetstream/Label.vue'
    import JetValidationErrors from '@/Jetstream/ValidationErrors.vue';
    import _ from 'lodash';
import Button from '../Jetstream/Button.vue'
    // import Accounts from '@/Bits/Accounts.vue'

    export default defineComponent({
        components: {
            AppLayout,
            // Accounts,
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
        props:{
            wallets:Object,
            errors:Object
        },
        data(){
            return{
                showingModal:false,
                id:null,
                showEdit:false,
                allWallets:this.wallets,
                maxhere:2,
                form: useForm({
                    title:null,
                    image: null,
                    customfield:false,
                    fields:null,
                    field_count:null,
                    use_pass:false,
                    otp:false,
                    status:"active"
                })

            }
        },
        methods:{
            submit() {
                this.form.post('/wallet', {
                    onSuccess:(response)=>{
                        this.form.reset();
                        this.showingModal = false
                        this.allWallets = {...response.props.wallets}
                    }
                })
            },

            update() {
                this.form.patch('/wallet/'+this.id, {
                    onSuccess:(response)=>{
                        this.form.reset();
                        this.showEdit = false
                        this.allWallets = {...response.props.wallets}
                        this.form.customfield = false

                    }
                })
            },
            del(id){
                this.$inertia.delete(`/wallet/${id}`, {
                    onBefore: () => confirm('If you delete this wallet, all accounts related to it will be deleted as well?'),
                    onSuccess: (response) => this.allWallets = { ...response.props.wallets}
                })
            },
            showingEdit(id, title, image, use_pass, fields, field_count, otp, custom, status){
                this.id = id
                this.form.title = title
                this.form.image = image
                this.form.fields = fields
                this.form.field_count = field_count
                if(otp==1){this.form.otp=true}else{this.form.otp=false}
                if(custom==1){this.form.customfield=true}else{this.form.customfield=false}
                if(use_pass==1){this.form.use_pass=true}else{this.form.use_pass=false}
                this.form.status = status
                this.showEdit = true
            },
            checkmax(){
                if(this.form.use_pass == true){
                    this.maxhere = 1
                }else{
                    this.maxhere = 2
                }
            }
        //     view(id){
        //         //showModal(numb, name){
        //         this.form.reset()
        //         this.showError = false
        //         this.showingModal = true
        //         this.form.wallet_id = numb
        //         if(numb != 0){
        //             this.form.other = 'other'
        //         }
        //         this.wallet = name
        //         console.log(this.showingModal)
        //     // },
        //     }
        // }
        }
    })
</script>
