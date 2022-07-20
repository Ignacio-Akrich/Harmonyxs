<script setup>
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';
import JetAuthenticationCard from '@/Jetstream/AuthenticationCard.vue';
import JetAuthenticationCardLogo from '@/Jetstream/AuthenticationCardLogo.vue';
import JetButton from '@/Jetstream/Button.vue';
import JetInput from '@/Jetstream/Input.vue';
import JetCheckbox from '@/Jetstream/Checkbox.vue';
import JetLabel from '@/Jetstream/Label.vue';
import JetValidationErrors from '@/Jetstream/ValidationErrors.vue';

defineProps({
    canResetPassword: Boolean,
    status: String,
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.transform(data => ({
        ...data,
        remember: form.remember ? 'on' : '',
    })).post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <Head title="Log in" />

    <JetAuthenticationCard>
        <!-- Logo -->
       <div class="logo" >
           <Link :href="route('home')">
               <JetAuthenticationCardLogo />
           </Link>
       </div>
        <JetValidationErrors class="mb-4" />
        <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
            {{ status }}
        </div>
        <form @submit.prevent="submit">
            <h1 class="text-center">Log In</h1>
            <div>
                <JetLabel for="email" value="Email" />
                <input id="email" type="email" class="mt-1 form-control" v-model="form.email" required autofocus autocomplete="username" />
            </div>

            <div class="mt-4">
                <JetLabel for="password" value="Password" class="form-label" />
                <input id="password" type="password" class="mt-1 form-control" v-model="form.password" required autocomplete="current-password" />
            </div>

            <div class="mt-4 form-check">
                <label class="flex items-center">
                    <JetCheckbox v-model:checked="form.remember" name="remember" />
                    <label class="form-check-label" for="remember">Recuérdame</label>
                </label>
            </div>

            <div class="d-flex align-items-center justify-content-end mt-4">
                <!-- no me he registrado -->
                <Link :href="route('register')" class="text-sm text-gray-600 me-3">
                    ¿No tienes cuenta?
                </Link>
                <Link v-if="canResetPassword" :href="route('password.request')" class="underline text-sm text-gray-600 hover:text-gray-900">
                    He olvidado mi contraseña
                </Link>

                <JetButton class="mx-2">
                    Login
                </JetButton>
            </div>
        </form>
    </JetAuthenticationCard>
</template>
