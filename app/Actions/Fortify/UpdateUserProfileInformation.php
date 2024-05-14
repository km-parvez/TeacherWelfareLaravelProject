<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\UpdatesUserProfileInformation;

class UpdateUserProfileInformation implements UpdatesUserProfileInformation
{
    /**
     * Validate and update the given user's profile information.
     *
     * @param  array<string, string>  $input
     */
    public function update(User $user, array $input): void
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'nid' => ['required', 'string', Rule::unique('users')->ignore($user->id)],
            'father_name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'size:11'],
            'blood_group' => ['required', 'string', 'max:255'],
            'mother_name' => ['required', 'string', 'max:255'],
            'spouse_name' => ['required', 'string', 'max:255'],
            'school_name' => ['required', 'string', 'max:255'],
            'designation' => ['required', 'string', 'max:255'],
            'payscale' => ['required', 'numeric', 'min:1'],
            'total_salary_withdraw' => ['required', 'numeric', 'min:1'],
            'present_address' => ['required', 'string', 'max:1255'],
            'permanent_address' => ['required', 'string', 'max:1255'],
            'joining_date' => ['required', 'date'],
            'prl_date' => ['required', 'date'],
            'date_of_birth' => ['required', 'date'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'photo' => ['nullable', 'mimes:jpg,jpeg,png', 'max:1024'],
        ])->validateWithBag('updateProfileInformation');

        if (isset($input['photo'])) {
            $user->updateProfilePhoto($input['photo']);
        }

        if ($input['email'] !== $user->email &&
            $user instanceof MustVerifyEmail) {
            $this->updateVerifiedUser($user, $input);
        } else {
            $user->forceFill([
                'name' => $input['name'],
                'nid' => $input['nid'],
                'blood_group' => $input['blood_group'],
                'phone' => $input['phone'],
                'email' => $input['email'],
                'father_name' => $input['father_name'],
                'mother_name' => $input['mother_name'],
                'spouse_name' => $input['spouse_name'],
                'school_name' => $input['school_name'],
                'designation' => $input['designation'],
                'payscale' => $input['payscale'],
                'total_salary_withdraw' => $input['total_salary_withdraw'],
                'present_address' => $input['present_address'],
                'permanent_address' => $input['permanent_address'],
                'joining_date' => $input['joining_date'],
                'prl_date' => $input['prl_date'],
                'date_of_birth' => $input['date_of_birth'],
            ])->save();
        }
    }

    /**
     * Update the given verified user's profile information.
     *
     * @param  array<string, string>  $input
     */
    protected function updateVerifiedUser(User $user, array $input): void
    {
        $user->forceFill([
            'name' => $input['name'],
            'email' => $input['email'],
            'email_verified_at' => null,
        ])->save();

        $user->sendEmailVerificationNotification();
    }
}
