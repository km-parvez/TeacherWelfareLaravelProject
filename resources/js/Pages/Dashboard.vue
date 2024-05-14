<script setup >
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import { Link, useForm } from "@inertiajs/vue3";
import { onMounted, ref } from "vue";
import moment from 'moment'
import Payments from "@/Components/Payments.vue";
import Withdraws from "@/Components/Withdraws.vue";
import { toast } from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';
const showPaymentForm = ref(false);
const showWithdrawForm = ref(false);
const showList = ref(true);
const paymentList = ref(true);
const withdrawForm = useForm({
    type: null,
    amount: '',
    details: '',
    current_payscale: '',
    requested_amount: '',
    total_salary_withdraw: '',
    requested_for_name: '',
    requested_for_date_of_birth: '',
    relation: '',
    education_details:'',
    education_details_2: [],
    disease_details: '',
    old_scholarship_details: '',
    latest_payment_receipt_details: '',
})
const paymentForm = useForm({
    amount: 0.0,
    date:moment().format('YYYY-MM-DD')
})
const showPayment = () => {
    showList.value = false
    showWithdrawForm.value = false;
    showPaymentForm.value = true;
}
const hideForm = () => {
    showList.value = true
    showWithdrawForm.value = false;
    showPaymentForm.value = false;
}
const showWithdraw = () => {
    showList.value = false
    showWithdrawForm.value = true;
    showPaymentForm.value = false;
    console.log('c')
}
const submitPayment = () => {
 paymentForm.post(route('makePayment'), {
     onFinish: () => {
         paymentForm.reset('amount', 'date')
         getLists()
         hideForm()
         toast('Payment Request Submitted Successfully');

     },
 });

}
const submitWithdraw = () => {
 withdrawForm.post(route('makeWithdraw'), {
     onFinish: () => {
         withdrawForm.reset()
         getLists()
         hideForm()
          toast('Withdraw Request Submitted Successfully');
     },
 });


}
const payments = ref([])
const withdraws = ref([])
const getLists = async () => {
    const {data} =await axios.get('getLists')
    if (data)
    {
        payments.value = data.payments
        withdraws.value = data.withdraws
    }
}
onMounted(() => {
getLists()
})
</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <img :src="$page.props.auth.user.profile_photo_url" alt="" class="rounded-full">
            <h2 class=" text-xl text-gray-800 leading-tight">
              Welcome <span class="font-semibold">{{ $page.props.auth.user.name }}</span>
                <p class="text-sm">{{ $page.props.auth.user.email }}</p>
            </h2>
        </template>

        <div  class="container px-5 sm:px-10 md:px-20 lg:px-25 gap-6 flex-wrap sm:flex mt-3">
                <div v-if="$page.props.auth.user.father_name == null" class="flex items-center justify-center w-full">
                <Link href="/user/profile" class="rounded-lg bg-amber-200 p-3">Click here To Complete Your profile</Link>
                </div>

            <div class="bg-slate-300 w-full rounded-md h-full min-h-screen px-5 sm:px-10 md:px-15 lg:px-20" :class="$page.props.auth.user.father_name == null?'pointer-events-none opacity-50':''">
                <div class="flex items-center justify-center h-32 gap-10">
                    <button
                        class="px-3 py-2 bg-blue-400 rounded-md text-white"
                        @click="showPayment()"
                    >
                        Make Subscription Payment
                    </button>
                    <button @click="showWithdraw()"
                        class="px-3 py-2 bg-green-700 rounded-md text-white"
                    >
                         Application for Grant
                    </button>
                </div>
                <div class="py-4 px-5 sm:px-15 md:px-20">
                     <form @submit.prevent="submitPayment" class="py-3 bg-gray-50 px-5 rounded-lg shadow-md" v-if="showPaymentForm">
                        <div class="w-full gap-5 py-3">
                            <h1 class="text-2xl text-center">Payment Request Form</h1>
                            <div>
                                <InputLabel for="amount" value="Amount" />
                                <TextInput
                                    id="amount"
                                    v-model="paymentForm.amount"
                                    type="number"
                                    class="mt-1 block w-full"
                                    required
                                    autofocus
                                    autocomplete="amount"
                                    placeholder="Enter Amount"
                                />
                                <InputError class="mt-2" :message="paymentForm.errors.amount" />
                            </div>
                            <div>
                                <InputLabel for="date" value="Date" />
                                <TextInput
                                    id="date"
                                    v-model="paymentForm.date"
                                    type="date"
                                    class="mt-1 block w-full"
                                    required
                                    autofocus
                                    autocomplete="date"
                                    placeholder="Select Date"
                                />
                                <InputError class="mt-2" :message="paymentForm.errors.date" />
                            </div></div>
                            <div class="flex items-center justify-end gap-5">
            <Button class="px-3 py-2 bg-gray-500  text-white rounded-lg" type="button" @click="hideForm">Cancel</Button>
            <Button class="px-3 py-2 bg-blue-500  text-white rounded-lg" type="submit">Send</Button>
        </div>
                </form>

                    <form class="w-full bg-gray-50 px-3 py-2 rounded-lg shadow-md" @submit.prevent="submitWithdraw" v-if="showWithdrawForm">
                           <h1 class="text-2xl text-center">Application for Grant Form</h1>
                        <div class="grid grid-cols-2 gap-5 mb-6 border-t my-3 py-5 px-3">

                             <div class="w-full">
                                <label
                                    class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                                    for="grid-state"
                                >
                                    Fund Requeest Type
                                </label>
                                <div class="relative space-y-5">
                                    <div class="flex gap-2 items-center">
                                    <input type="radio" v-model="withdrawForm.type" :value="1" />
                                    <InputLabel value="Medical Aid"/>

                                </div>
                                    <div class="flex gap-2 items-center">
                                    <input type="radio" v-model="withdrawForm.type" :value="2" />
                                    <InputLabel value="Scholarship"/>

                                </div>
                                    <!-- <input type="radio" v-model="withdrawForm.type" :value="2" />
                                    <select v-model="withdrawForm.type"
                                        class="block appearance-none w-full bg-white border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                        id="grid-state"
                                    >
                                        <option value="1">Medical Aid</option>
                                        <option value="2">Scholarship</option>
                                    </select>
                                    <div
                                        class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700"
                                    >

                                    </div> -->
                                </div>
                            </div>
                             <div class="w-full px-3 mb-6 md:mb-0">

                                <InputLabel for="current_payscale" value="Current Pay Scale" />
                                <TextInput
                                    id="current_payscale"
                                    v-model="withdrawForm.current_payscale"
                                    type="number"
                                    class="mt-1 block w-full"
                                    required
                                    autofocus
                                    autocomplete="current_payscale"
                                    placeholder="Enter Current Payscale"
                                />
                                <InputError class="mt-2" :message="withdrawForm.errors.current_payscale" />
                            </div>
                                <div class="w-full col-span-2">
                                <h1>Applying For </h1>
                                </div>
                            <div class="w-full px-3 mb-6 md:mb-0">

                                <InputLabel for="requested_for_name" value="Name" />
                                <TextInput
                                    id="requested_for_name"
                                    v-model="withdrawForm.requested_for_name"
                                    type="text"
                                    class="mt-1 block w-full"
                                    required
                                    autofocus
                                    autocomplete="requested_for_name"
                                    placeholder="Enter Applying for Name"
                                />
                                <InputError class="mt-2" :message="withdrawForm.errors.requested_for_name" />
                            </div>
                            <div class="w-full px-3 mb-6 md:mb-0">

                                <InputLabel for="requested_for_date_of_birth" value="Date of Birth" />
                                <TextInput
                                    id="requested_for_date_of_birth"
                                    v-model="withdrawForm.requested_for_date_of_birth"
                                    type="date"
                                    class="mt-1 block w-full"
                                    required
                                    autofocus
                                    autocomplete="requested_for_date_of_birth"
                                />
                                <InputError class="mt-2" :message="withdrawForm.errors.requested_for_date_of_birth" />
                            </div>
                            <div class="w-full px-3 mb-6 md:mb-0">

                                <InputLabel for="relation" value="Relation with member" />
                                <TextInput
                                    id="relation"
                                    v-model="withdrawForm.relation"
                                    type="text"
                                    class="mt-1 block w-full"
                                    required
                                    autofocus
                                    autocomplete="relation"
                                    placeholder="Enter relation with applying for"
                                />
                                <InputError class="mt-2" :message="withdrawForm.errors.relation" />
                            </div>
                            <div class="w-full px-3 mb-6 md:mb-0" v-if="withdrawForm.type == 2">

                                <InputLabel for="education_details" value="Name of institution studying & Class" />
                                <TextInput
                                    id="education_details"
                                    v-model="withdrawForm.education_details"
                                    type="text"
                                    class="mt-1 block w-full"
                                    required
                                    autofocus
                                    autocomplete="education_details"
                                    placeholder="Enter Name of the institute and class"
                                />
                                <InputError class="mt-2" :message="withdrawForm.errors.education_details" />
                            </div>
                            <div class="w-full px-3 mb-6 md:mb-0" v-if="withdrawForm.type == 1">

                                <InputLabel for="disease_details" value="Name of Disease" />
                                <TextInput
                                    id="disease_details"
                                    v-model="withdrawForm.disease_details"
                                    type="text"
                                    class="mt-1 block w-full"
                                    required
                                    autofocus
                                    autocomplete="disease_details"
                                    placeholder="Enter disease details"
                                />
                                <InputError class="mt-2" :message="withdrawForm.errors.disease_details" />
                            </div>
                            <div class="w-full px-3 mb-6 md:mb-0" v-if="withdrawForm.type == 1">

                                <InputLabel for="requested_amount" value="Requested Amount" />
                                <TextInput
                                    id="requested_amount"
                                    v-model="withdrawForm.requested_amount"
                                    type="number"
                                    class="mt-1 block w-full"
                                    required
                                    autofocus
                                    autocomplete="requested_amount"
                                    placeholder="Enter Amount"
                                />
                                <InputError class="mt-2" :message="withdrawForm.errors.requested_amount" />
                            </div>
                             <div class="w-full px-3 mb-6 md:mb-0" >

                                <InputLabel for="old_scholarship_details" value="Previous Scholarship Details"  v-if="withdrawForm.type == 2"/>
                                <InputLabel for="old_scholarship_details" value="Previous Medical Aid Details"  v-else/>
                                <TextInput
                                    id="old_scholarship_details"
                                    v-model="withdrawForm.old_scholarship_details"
                                    type="text"
                                    class="mt-1 block w-full"
                                    required
                                    autofocus
                                    autocomplete="old_scholarship_details"
                                    placeholder="Enter previous medical aid details"
                                />
                                <InputError class="mt-2" :message="withdrawForm.errors.old_scholarship_details" />
                            </div>
                            <div class="w-full px-3 mb-6 md:mb-0">

                                <InputLabel for="latest_payment_receipt_details" value="Latest Pay slip number & date " />
                                <TextInput
                                    id="latest_payment_receipt_details"
                                    v-model="withdrawForm.latest_payment_receipt_details"
                                    type="text"
                                    class="mt-1 block w-full"
                                    required
                                    autofocus
                                    autocomplete="latest_payment_receipt_details"
                                    placeholder="Enter payemnt receipt no & date"
                                />
                                <InputError class="mt-2" :message="withdrawForm.errors.latest_payment_receipt_details" />
                            </div>
                            <div class="w-full px-3 mb-6 md:mb-0">

                                <InputLabel for="total_salary_withdraw" value="Total Salary Withdrawn" />
                                <TextInput
                                    id="total_salary_withdraw"
                                    v-model="withdrawForm.total_salary_withdraw"
                                    type="number"
                                    class="mt-1 block w-full"
                                    required
                                    autofocus
                                    autocomplete="total_salary_withdraw"
                                    placeholder="Enter Total Salary withdrawn"
                                />
                                <InputError class="mt-2" :message="withdrawForm.errors.total_salary_withdraw" />
                            </div>

                         <div class="col-span-full" v-if="withdrawForm.type == 2">
                                <h2>Various Exam details</h2>
                                <div class="grid grid-cols-7">
                                    <label>SL:</label>
                                    <label>Exam Name:</label>
                                    <label>GPA:</label>
                                    <label>Passing Year:</label>
                                    <label>Board:</label>
                                    <label>Result:</label>
                                </div>
                                <div v-for="(education, index) in withdrawForm.education_details_2" :key="index" class="grid grid-cols-7 py-2 rounded-lg">

                                <input :value='index + 1' disabled class="rounded-s-lg">

                                <input v-model="education.exam_name" placeholder="Exam Name">


                                <input v-model="education.gpa" placeholder="GPA">


                                <input v-model="education.passing_year" placeholder="Passing Year">


                                <input v-model="education.board" placeholder="Board">


                                <input v-model="education.result" placeholder="Result" class="rounded-e-lg">
                                <button type="button" class="px-2" @click="withdrawForm.education_details_2.splice(index, 1)"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path d="M17 6H22V8H20V21C20 21.5523 19.5523 22 19 22H5C4.44772 22 4 21.5523 4 21V8H2V6H7V3C7 2.44772 7.44772 2 8 2H16C16.5523 2 17 2.44772 17 3V6ZM18 8H6V20H18V8ZM9 11H11V17H9V11ZM13 11H15V17H13V11ZM9 4V6H15V4H9Z" fill="rgba(221,33,33,1)"></path></svg></button>
                                </div>




                                <button type="button" @click="withdrawForm.education_details_2.push({
                                    exam_name: '',
                                    gpa: '',
                                    passing_year: '',
                                    board: '',
                                    result:''
                                })"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path d="M12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22ZM11 11H7V13H11V17H13V13H17V11H13V7H11V11Z" fill="rgba(70,146,221,1)"></path></svg></button>
                                  </div>
                                     <div class="w-full px-3 mb-6 md:mb-0" >

                                <InputLabel for="education_details" value="Documents Attachment" />
                                <TextInput
                                    id="education_details"
                                    v-model="withdrawForm.education_details"
                                    type="file"
                                    class="mt-1 block w-full bg-white border-gray-300 rounded-lg border"
                                    
                                    autofocus
                                    autocomplete="education_details"
                                />
                                <InputError class="mt-2" :message="withdrawForm.errors.education_details" />
                            </div>

                            </div>



                          <div class="w-full md:w-1/3 px-3 flex  justify-between items-center mb-6 md:mb-3">
                        <button @click="hideForm" class="px-2 py-3 bg-gray-400 text-white border-gray-800 rounded-md">Cancel</button>
                        <button class="px-2 py-3 bg-blue-400 text-white border-gray-800 rounded-md">Submit</button></div>
                    </form>
                </div>
                <div v-if="showList">
                    <div  class="w-full flex justify-between rounded bg-gray-200 items-center">
                        <div @click="paymentList = true"
                            class="flex justify-center w-full h-9" :class="paymentList ? 'border-white rounded-md border-2 bg-blue-400 text-white':''"
                        >
                            <button >Payment List</button>
                        </div>
                        <div @click="paymentList = false"
                            class="flex justify-center w-full h-9"
                        :class="!paymentList ? 'border-white rounded-md border-2 bg-blue-400 text-white':''"
                        >
                            <button >Application for Grant</button>
                        </div>
                    </div>

                  <Payments v-if="paymentList" :payments="payments"/>
                  <Withdraws v-else :withdraws="withdraws"/>
                </div>
            </div>
        </div>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div
                    class="bg-white overflow-hidden shadow-xl sm:rounded-lg"
                ></div>
            </div>
        </div>
    </AppLayout>
</template>
