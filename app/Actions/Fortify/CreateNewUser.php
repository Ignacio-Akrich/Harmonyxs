<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;
use Spatie\Permission\Models\Role;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array  $input
     * @return \App\Models\User
     */
    public function create(array $input)
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
            'roles' => 'required',
            'lat' => 'required',
            'lng' => 'required'

        ])->validate();

        return User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
            'music_genre' => $input['music_genre'],
            'age' => $input['age'],
            'lat'=> $input['lat'],
            'lng' => $input['lng'],
            'instrumento' => $input['instrumento'],
            'experience' => $input['experience'],
            'band_experience' => $input['band_experience'],
            'member' => $input['member'],
            'address_rehearsal_room' => $input['address_rehearsal_room'],
            'creation_date' => $input['creation_date'],
            'concert_experience' => $input['concert_experience'],
            'availability_table' => $input['availability_table'],
            'gender' => $input['gender'],
            'description' => $input['description']
        ])->assignRole($input['roles']);
    }
}
