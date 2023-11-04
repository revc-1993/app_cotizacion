<template>
    <DashboardLayout title="Datos de la empresa">
        <h1>{{ __("mail server") }}</h1>

        <form
            @submit.prevent="submit"
            class="w-full bg-white border border-slate-200 rounded-md shadow-xl"
        >
            <div
                class="flex items-center justify-start bg-slate-200 px-4 py-2 space-x-2 text-xs"
            >
                <label
                    for="mail server"
                    class="first-letter:capitalize lowercase text-sm"
                >
                    <b> {{ __("mail protocol") }} </b>
                    <b class="text-red-500">*</b>
                </label>
            </div>
            <div class="flex flex-col space-y-2 p-4">
                <div
                    class="grid grid-cols-1 gap-x-3 lg:grid-cols-2 mb-2 lg:mb-0 last:mb-0"
                >
                    <div class="mb-2 last:mb-0 first-letter:capitalize">
                        <label
                            for="mail_mailer"
                            class="first-letter:capitalize lowercase text-sm"
                            >{{ __("mail protocol") }}</label
                        >

                        <input
                            v-model="form.mail_mailer"
                            type="text"
                            name="name"
                            class="w-full bg-white text-sm border border-slate-300 rounded-md shadow placeholder:capitalize"
                            :placeholder="__('mail protocol')"
                            autofocus
                            autocomplete="off"
                        />

                        <transition name="fade">
                            <p
                                v-if="form.errors.mail_mailer"
                                class="text-xs text-red-500"
                            >
                                {{ form.errors.mail_mailer }}
                            </p>
                        </transition>

                        <ul
                            class="flex-wrap text-xs text-slate-400 mt-2 list-disc list-inside"
                        >
                            <li class="first-letter:capitalize lowercase">
                                {{ __("enter mail protocol") }}
                            </li>
                        </ul>
                    </div>
                    <div class="mb-2 last:mb-0 first-letter:capitalize">
                        <label
                            for="ruc"
                            class="first-letter:capitalize lowercase text-sm"
                            >{{ __("host") }}
                            <b class="text-red-500">*</b></label
                        >

                        <input
                            v-model="form.mail_host"
                            type="text"
                            name="host"
                            class="w-full bg-white text-sm border border-slate-300 rounded-md shadow placeholder:capitalize"
                            :placeholder="__('host')"
                            autofocus
                            autocomplete="off"
                        />

                        <transition name="fade">
                            <p
                                v-if="form.errors.mail_host"
                                class="text-xs text-red-500"
                            >
                                {{ form.errors.mail_host }}
                            </p>
                        </transition>

                        <ul
                            class="flex-wrap text-xs text-slate-400 mt-2 list-disc list-inside"
                        >
                            <li class="first-letter:capitalize lowercase">
                                {{ __("enter host") }}
                            </li>
                        </ul>
                    </div>
                </div>

                <div
                    class="grid grid-cols-1 gap-x-3 lg:grid-cols-2 mb-2 lg:mb-0 last:mb-0"
                >
                    <div class="mb-2 last:mb-0 first-letter:capitalize">
                        <label
                            for="email"
                            class="first-letter:capitalize lowercase text-sm"
                            >{{ __("email") }}
                            <b class="text-red-500">*</b></label
                        >

                        <input
                            v-model="form.email"
                            type="text"
                            name="email"
                            class="w-full bg-white text-sm border border-slate-300 rounded-md shadow placeholder:capitalize"
                            :placeholder="__('example of email')"
                            autofocus
                            autocomplete="off"
                        />

                        <transition name="fade">
                            <p
                                v-if="form.errors.email"
                                class="text-xs text-red-500"
                            >
                                {{ form.errors.email }}
                            </p>
                        </transition>

                        <ul
                            class="flex-wrap text-xs text-slate-400 mt-2 list-disc list-inside"
                        >
                            <li class="first-letter:capitalize lowercase">
                                {{ __("enter the email address") }}
                            </li>
                        </ul>
                    </div>
                    <div class="mb-2 last:mb-0 first-letter:capitalize">
                        <label
                            for="password"
                            class="first-letter:capitalize lowercase text-sm"
                            >{{ __("password") }}
                            <b class="text-red-500">*</b></label
                        >

                        <input
                            v-model="form.mail_password"
                            type="password"
                            name="mail_password"
                            class="w-full bg-white text-sm border border-slate-300 rounded-md shadow placeholder:capitalize"
                            :placeholder="__('password')"
                            autofocus
                            autocomplete="off"
                        />

                        <transition name="fade">
                            <p
                                v-if="form.errors.mail_password"
                                class="text-xs text-red-500"
                            >
                                {{ form.errors.mail_password }}
                            </p>
                        </transition>

                        <ul
                            class="flex-wrap text-xs text-slate-400 mt-2 list-disc list-inside"
                        >
                            <li class="first-letter:capitalize lowercase">
                                {{ __("enter password") }}
                            </li>
                        </ul>
                    </div>
                </div>

                <div
                    class="grid grid-cols-1 gap-x-3 lg:grid-cols-2 mb-2 lg:mb-0 last:mb-0"
                >
                    <div class="mb-2 last:mb-0 first-letter:capitalize">
                        <label
                            for="mail_from_name"
                            class="first-letter:capitalize lowercase text-sm"
                            >{{ __("sender name") }}
                            <b class="text-red-500">*</b></label
                        >

                        <input
                            v-model="form.mail_from_name"
                            type="text"
                            name="mail_from_name"
                            class="w-full bg-white text-sm border border-slate-300 rounded-md shadow placeholder:capitalize"
                            :placeholder="__('name sender')"
                            autofocus
                            autocomplete="off"
                        />

                        <transition name="fade">
                            <p
                                v-if="form.errors.mail_from_name"
                                class="text-xs text-red-500"
                            >
                                {{ form.errors.mail_from_name }}
                            </p>
                        </transition>

                        <ul
                            class="flex-wrap text-xs text-slate-400 mt-2 list-disc list-inside"
                        >
                            <li class="first-letter:capitalize lowercase">
                                {{ __("enter name sender") }}
                            </li>
                        </ul>
                    </div>
                    <div class="mb-2 last:mb-0 first-letter:capitalize">
                        <label
                            for="port"
                            class="first-letter:capitalize lowercase text-sm"
                            >{{ __("port") }}
                            <b class="text-red-500">*</b></label
                        >

                        <input
                            v-model="form.mail_port"
                            type="text"
                            name="port"
                            class="w-full bg-white text-sm border border-slate-300 rounded-md shadow placeholder:capitalize"
                            :placeholder="__('port')"
                            autofocus
                            autocomplete="off"
                        />

                        <transition name="fade">
                            <p
                                v-if="form.errors.mail_port"
                                class="text-xs text-red-500"
                            >
                                {{ form.errors.mail_port }}
                            </p>
                        </transition>

                        <ul
                            class="flex-wrap text-xs text-slate-400 mt-2 list-disc list-inside"
                        >
                            <li class="first-letter:capitalize lowercase">
                                {{ __("enter port") }}
                            </li>
                        </ul>
                    </div>
                </div>

                <div
                    class="grid grid-cols-1 gap-x-3 lg:grid-cols-2 mb-2 lg:mb-0 last:mb-0"
                ></div>
            </div>

            <div
                class="flex items-center justify-end bg-slate-200 px-4 py-2 space-x-2 text-xs"
            >
                <button
                    class="bg-slate-700 text-slate-200 border border-slate-800 rounded-md shadow px-3 py-2 uppercase font-bold"
                >
                    {{ __("save") }}
                </button>

                <Link
                    :href="route('dashboard')"
                    class="bg-slate-50 border border-slate-300 rounded-md shadow px-3 py-2 uppercase font-bold"
                >
                    {{ __("back") }}
                </Link>
            </div>
        </form>
    </DashboardLayout>
</template>

<style scoped>
.opacity-enter-active,
.opacity-leave-active {
    transition: all 300ms ease;
    opacity: 1;
}

.opacity-enter-from,
.opacity-leave-to {
    opacity: 0;
}
</style>

<script>
import { defineComponent } from "vue";
import { Link, useForm } from "@inertiajs/inertia-vue3";
import DashboardLayout from "@/Layouts/DashboardLayout";
import Icon from "@/Components/Icon";
import axios from "axios";

export default defineComponent({
    props: {
        configuration: Object,
    },

    components: {
        DashboardLayout,
        Link,
        Icon,
    },

    data() {
        return {
            form: useForm({
                mail_mailer: new String(),
                mail_host: new String(),
                email: new String(),
                mail_password: new String(),
                mail_port: new Number(),
                mail_from_name: new String(),
            }),
        };
    },
    methods: {
        submit() {
            this.form.post(route("superuser.configuration.submitMail"), {
                onSuccess: () => this.form.reset(),
            });
        },
    },
    mounted() {
        if (this.configuration) {
            this.form.mail_mailer = this.configuration.mail_mailer;
            this.form.mail_host = this.configuration.mail_host;
            this.form.email = this.configuration.email;
            this.form.mail_password = this.configuration.mail_password;
            this.form.mail_port = this.configuration.mail_port;
            this.form.mail_from_name = this.configuration.mail_from_name;
        }
    },
});
</script>

<style src="@vueform/multiselect/themes/default.css"></style>
