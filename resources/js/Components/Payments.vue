<template>
      <div class="relative overflow-x-auto rounded-b-lg">
                        <table
                            class="w-full text-sm text-left rtl:text-right text-gray-500 "
                        >
                            <thead
                                class="text-xs text-gray-700 uppercase bg-gray-50 "
                            >
                                <tr>
                                    <th scope="col" class="px-6 py-3">
                                       Date
                                    </th>
                                    <th scope="col" class="px-6 py-3">Status</th>

                                    <th scope="col" class="px-6 py-3">Amount</th>
                                    <th scope="col" class="px-6 py-3">Action</th>
                                </tr>
                            </thead>
                            <tbody>

                                <tr v-for="(payment,index) in props.payments"
                                    class="bg-white border-b "
                                >
                                    <th
                                        scope="row"
                                        class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap "
                                    >
                                       {{ payment.date }}
                                    </th>
                                    <td class="px-6 py-4 "><span v-if="payment.status == 0" class="text-amber-500">Pending</span> <span v-else class="text-green-500">Completed</span></td>

                                    <td class="px-6 py-4 text-gray-900 ">{{ payment.amount}}</td>
                                    <td class="px-6 py-4 text-gray-900 "><Button class="bg-green-600 text-white px-3 py-2 rounded-lg">Receipt</Button></td>
                                </tr>

                            </tbody>
                        </table>
                          <div v-if="props.payments.length == 0" class="bg-gray-100 w-full text-xl py-3 px-5 text-center rounded-b-lg">
                                    No Payments Requests to show
                                </div>
                    </div>
</template>

<script setup>
  const props =  defineProps(['payments'])
</script>

<style scoped>

</style>
