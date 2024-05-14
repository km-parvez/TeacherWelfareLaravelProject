<script setup>
import { ref } from 'vue';
import { Link, router, useForm } from '@inertiajs/vue3';
import ActionMessage from '@/Components/ActionMessage.vue';
import FormSection from '@/Components/FormSection.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import TextArea from '@/Components/TextArea.vue';

const props = defineProps({
    user: Object,
});

const form = useForm({
    _method: 'PUT',
    name: props.user.name,
    email: props.user.email,
    nid: props.user.nid,
    blood_group: props.user.blood_group,
    photo: null,
    father_name: props.user.father_name,
    phone: props.user.phone,
    mother_name: props.user.mother_name,
    spouse_name: props.user.spouse_name,
    present_address: props.user.present_address,
    permanent_address: props.user.permanent_address,
    joining_date: props.user.joining_date,
    prl_date: props.user.prl_date,
    designation: props.user.designation,
    school_name:props.user.school_name,
    date_of_birth: props.user.date_of_birth,
    payscale: props.user.payscale,
    total_salary_withdraw: props.user.total_salary_withdraw,
});

const verificationLinkSent = ref(null);
const photoPreview = ref(null);
const photoInput = ref(null);
const bloods = ref(['A+','A-','B+','B-','O+','O-','AB+','AB-'])
const updateProfileInformation = () => {
    console.log(form)
    if (photoInput.value) {
        form.photo = photoInput.value.files[0];
    }

    form.post(route('user-profile-information.update'), {
        errorBag: 'updateProfileInformation',
        preserveScroll: true,
        onSuccess: () => clearPhotoFileInput(),
    });
};

const sendEmailVerification = () => {
    verificationLinkSent.value = true;
};

const selectNewPhoto = () => {
    photoInput.value.click();
};

const updatePhotoPreview = () => {
    const photo = photoInput.value.files[0];

    if (! photo) return;

    const reader = new FileReader();

    reader.onload = (e) => {
        photoPreview.value = e.target.result;
    };

    reader.readAsDataURL(photo);
};

const deletePhoto = () => {
    router.delete(route('current-user-photo.destroy'), {
        preserveScroll: true,
        onSuccess: () => {
            photoPreview.value = null;
            clearPhotoFileInput();
        },
    });
};

const clearPhotoFileInput = () => {
    if (photoInput.value?.value) {
        photoInput.value.value = null;
    }
};
</script>

<template>
    <FormSection @submitted="updateProfileInformation">
        <template #title>
            Profile Information
        </template>

        <template #description>
            Update your account's profile information and email address.
        </template>

        <template #form>
            <!-- Profile Photo -->
            <div v-if="$page.props.jetstream.managesProfilePhotos" class="col-span-6 sm:col-span-4">
                <!-- Profile Photo File Input -->
                <input
                    id="photo"
                    ref="photoInput"
                    type="file"
                    class="hidden"
                    @change="updatePhotoPreview"
                >

                <InputLabel for="photo" value="Photo" />

                <!-- Current Profile Photo -->
                <div v-show="! photoPreview" class="mt-2">
                    <img :src="user.profile_photo_url" :alt="user.name" class="rounded-full h-20 w-20 object-cover">
                </div>

                <!-- New Profile Photo Preview -->
                <div v-show="photoPreview" class="mt-2">
                    <span
                        class="block rounded-full w-20 h-20 bg-cover bg-no-repeat bg-center"
                        :style="'background-image: url(\'' + photoPreview + '\');'"
                    />
                </div>

                <SecondaryButton class="mt-2 me-2" type="button" @click.prevent="selectNewPhoto">
                    Select A New Photo
                </SecondaryButton>

                <SecondaryButton
                    v-if="user.profile_photo_path"
                    type="button"
                    class="mt-2"
                    @click.prevent="deletePhoto"
                >
                    Remove Photo
                </SecondaryButton>

                <InputError :message="form.errors.photo" class="mt-2" />
            </div>

            <!-- Name -->
            <div class="col-span-6 sm:col-span-4">
                <InputLabel for="name" value="Name" />
                <TextInput
                    id="name"
                    v-model="form.name"
                    type="text"
                    class="mt-1 block w-full"
                    required
                    autocomplete="name"
                />
                <InputError :message="form.errors.name" class="mt-2" />
            </div>

            <!-- Email -->
            <div class="col-span-6 sm:col-span-4">
                <InputLabel for="email" value="Email" />
                <TextInput
                    id="email"
                    v-model="form.email"
                    type="email"
                    class="mt-1 block w-full"
                    required
                    autocomplete="username"
                />
                <InputError :message="form.errors.email" class="mt-2" />

                <div v-if="$page.props.jetstream.hasEmailVerification && user.email_verified_at === null">
                    <p class="text-sm mt-2">
                        Your email address is unverified.

                        <Link
                            :href="route('verification.send')"
                            method="post"
                            as="button"
                            class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                            @click.prevent="sendEmailVerification"
                        >
                            Click here to re-send the verification email.
                        </Link>
                    </p>

                    <div v-show="verificationLinkSent" class="mt-2 font-medium text-sm text-green-600">
                        A new verification link has been sent to your email address.
                    </div>
                </div>
            </div>
              <div class="col-span-6 sm:col-span-4">
                <InputLabel for="phone" value="Phone" />
                <TextInput
                    id="phone"
                    v-model="form.phone"
                    type="text"
                    class="mt-1 block w-full"
                    required
                    autocomplete="phone"
                />
                <InputError :message="form.errors.phone" class="mt-2" />
            </div>
              <div class="col-span-6 sm:col-span-4">
                <InputLabel for="nid" value="NID" />
                <TextInput
                    id="nid"
                    v-model="form.nid"
                    type="text"
                    class="mt-1 block w-full"
                    required
                    autocomplete="nid"
                />
                <InputError :message="form.errors.nid" class="mt-2" />
            </div>
              <div class="col-span-6 sm:col-span-4">
                <InputLabel for="blood_group" value="Blood Group" />
               <select v-model="form.blood_group" class="rounded-lg w-full">

                  <Option :value="blood" v-for="blood in bloods" :selected="form.blood_group">{{ blood}}</Option>
                </select>
                <InputError :message="form.errors.blood_group" class="mt-2" />
            </div>
             <div class="col-span-6 sm:col-span-4">
                <InputLabel for="father_name" value="Father Name" />
                <TextInput
                    id="father_name"
                    v-model="form.father_name"
                    type="text"
                    class="mt-1 block w-full"
                    required
                    autocomplete="father_name"
                />
                <InputError :message="form.errors.father_name" class="mt-2" />
            </div>
             <div class="col-span-6 sm:col-span-4">
                <InputLabel for="mother_name" value="Mother Name" />
                <TextInput
                    id="mother_name"
                    v-model="form.mother_name"
                    type="text"
                    class="mt-1 block w-full"
                    required
                    autocomplete="mother_name"
                />
                <InputError :message="form.errors.mother_name" class="mt-2" />
            </div>

             <div class="col-span-6 sm:col-span-4">
                <InputLabel for="spouse_name" value="Spouse Name" />
                <TextInput
                    id="spouse_name"
                    v-model="form.spouse_name"
                    type="text"
                    class="mt-1 block w-full"
                    required
                    autocomplete="spouse_name"
                />
                <InputError :message="form.errors.spouse_name" class="mt-2" />
            </div>
             <div class="col-span-6 sm:col-span-4">
                <InputLabel for="permanent_address" value="Permanent Address" />
                <TextArea
                    id="permanent_address"
                    v-model="form.permanent_address"
                    type="text"
                    class="mt-1 block w-full"
                    required
                    autocomplete="permanent_address"
                />
                <InputError :message="form.errors.permanent_address" class="mt-2" />
            </div>
             <div class="col-span-6 sm:col-span-4">
                <InputLabel for="present_address" value="Present Address" />
                <TextArea
                    id="present_address"
                    v-model="form.present_address"
                    type="text"
                    class="mt-1 block w-full"
                    required
                    autocomplete="present_address"
                />
                <InputError :message="form.errors.present_address" class="mt-2" />
            </div>
              <div class="col-span-6 sm:col-span-4">
                <InputLabel for="joining_date" value="Joining Date" />
                <TextInput
                    id="joining_date"
                    v-model="form.joining_date"
                    type="date"
                    class="mt-1 block w-full"
                    required
                    autocomplete="joining_date"
                />
                <InputError :message="form.errors.joining_date" class="mt-2" />
            </div>
              <div class="col-span-6 sm:col-span-4">
                <InputLabel for="prl_date" value="PRL Date" />
                <TextInput
                    id="prl_date"
                    v-model="form.prl_date"
                    type="date"
                    class="mt-1 block w-full"
                    required
                    autocomplete="prl_date"
                />
                <InputError :message="form.errors.prl_date" class="mt-2" />
            </div>
              <div class="col-span-6 sm:col-span-4">
                <InputLabel for="prl_date" value="Designation" />
                <select v-model="form.designation" class="rounded-lg w-full">
                  <Option value="Assistant Teacher" :selected="form.designation">Assistant Teacher</Option>
                  <Option value="Head Teacher" :selected="form.designation">Head Teacher</Option>
                </select>


                <InputError :message="form.errors.prl_date" class="mt-2" />
            </div>
              <div class="col-span-6 sm:col-span-4">
                <InputLabel for="date_of_birth" value="Date of Birth" />
                <TextInput
                    id="date_of_birth"
                    v-model="form.date_of_birth"
                    type="date"
                    class="mt-1 block w-full"
                    required
                    autocomplete="date_of_birth"
                />
                <InputError :message="form.errors.date_of_birth" class="mt-2" />
            </div>
              <div class="col-span-6 sm:col-span-4">
                <InputLabel for="school_name" value="School Name(Current)" />
                <TextInput
                    id="school_name"
                    v-model="form.school_name"
                    type="text"
                    class="mt-1 block w-full"
                    required
                    autocomplete="school_name"
                />
                <InputError :message="form.errors.school_name" class="mt-2" />
            </div>
              <div class="col-span-6 sm:col-span-4">
                <InputLabel for="payscale" value="Current Pay Scale" />
                <TextInput
                    id="payscale"
                    v-model="form.payscale"
                    type="number"
                    class="mt-1 block w-full"
                    required
                    autocomplete="payscale"
                />
                <InputError :message="form.errors.payscale" class="mt-2" />
            </div>
              <div class="col-span-6 sm:col-span-4">
                <InputLabel for="total_salary_withdraw" value="Total Salary Withdrawn" />
                <TextInput
                    id="total_salary_withdraw"
                    v-model="form.total_salary_withdraw"
                    type="number"
                    class="mt-1 block w-full"
                    required
                    autocomplete="total_salary_withdraw"
                />
                <InputError :message="form.errors.total_salary_withdraw" class="mt-2" />
            </div>
        </template>

        <template #actions>
            <ActionMessage :on="form.recentlySuccessful" class="me-3">
                Saved.
            </ActionMessage>

            <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                Save
            </PrimaryButton>
        </template>
    </FormSection>
</template>
