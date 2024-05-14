<template>
      <div class="relative overflow-x-auto rounded-b-lg">
                        <table
                            class="w-full text-sm text-left rtl:text-right text-gray-500 "
                        >
                            <thead
                                class="text-xs text-gray-700 uppercase bg-gray-100 "
                            >
                                <tr class="border-gray-300">
                                    <th scope="col" class="px-6 py-3">
                                       SL
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                       Date
                                    </th>
                                    <th scope="col" class="px-6 py-3">Status</th>

                                    <th scope="col" class="px-6 py-3">Amount</th>
                                    <th scope="col" class="px-6 py-3">Requested Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(withdraws,index) in props.withdraws"
                                    class="bg-gray-50 border border-gray-300"
                                >
                                    <th
                                        scope="row"
                                        class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap "
                                    >
                                       {{ index+1 }}
                                    </th>
                                    <th
                                        scope="row"
                                        class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap "
                                    >
                                       {{ moment(withdraws.created_at).format('Do MMM YY') }}
                                    </th>
                                    <td class="px-6 py-4 ">
                                        <span v-if="withdraws.status == 0" class="text-amber-500">Pending</span>
                                        <span v-else-if="withdraws.status == 1" class="text-green-500">Accepted</span>
                                        <span v-else-if="withdraws.status == 2" class="text-blue-500">Paid</span>
                                        <span v-else-if="withdraws.status == 3" class="text-red-500">Rejected</span>
                                    </td>

                                    <td class="px-6 py-4 text-gray-900 ">{{ withdraws.amount}}</td>
                                    <td class="px-6 py-4 text-gray-900 ">{{ withdraws.requested_amount}}</td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
</template>

<script setup>
import moment from 'moment'
  const props =  defineProps(['withdraws'])
  console.log(props)
</script>

<style scoped>

</style>
