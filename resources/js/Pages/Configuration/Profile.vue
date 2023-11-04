<template>
    <DashboardLayout title="Datos de la empresa">
        <h1>Datos de la empresa</h1>

        <form
            @submit.prevent="submit"
            class="w-full bg-white border border-slate-200 rounded-md shadow-xl"
        >
            <div
                class="flex items-center justify-start bg-slate-200 px-4 py-2 space-x-2 text-xs"
            >
                <label
                    for="registration_date"
                    class="first-letter:capitalize lowercase text-sm"
                >
                    <b> Datos de la empresa </b>
                </label>
            </div>
            <div class="flex flex-col space-y-2 p-4">
                <div
                    class="grid grid-cols-1 gap-x-3 lg:grid-cols-2 mb-2 lg:mb-0 last:mb-0"
                >
                    <div class="mb-2 last:mb-0 first-letter:capitalize">
                        <label
                            for="company_name"
                            class="first-letter:capitalize lowercase text-sm"
                            >{{ __("company name") }}
                            <b class="text-red-500">*</b>
                        </label>

                        <input
                            v-model="form.company_name"
                            type="text"
                            name="name"
                            class="w-full bg-white text-sm border border-slate-300 rounded-md shadow placeholder:capitalize"
                            :placeholder="__('company name')"
                            autofocus
                            autocomplete="off"
                        />

                        <transition name="fade">
                            <p
                                v-if="form.errors.company_name"
                                class="text-xs text-red-500"
                            >
                                {{ form.errors.company_name }}
                            </p>
                        </transition>

                        <ul
                            class="flex-wrap text-xs text-slate-400 mt-2 list-disc list-inside"
                        >
                            <li class="first-letter:capitalize lowercase">
                                {{ __("enter company name") }}
                            </li>
                        </ul>
                    </div>
                    <div class="mb-2 last:mb-0 first-letter:capitalize">
                        <label
                            for="ruc"
                            class="first-letter:capitalize lowercase text-sm"
                            >{{ __("ruc") }}
                            <b class="text-red-500">*</b></label
                        >

                        <input
                            v-model="form.ruc"
                            type="text"
                            name="ruc"
                            class="w-full bg-white text-sm border border-slate-300 rounded-md shadow placeholder:capitalize"
                            :placeholder="__('ruc')"
                            autofocus
                            autocomplete="off"
                        />

                        <transition name="fade">
                            <p
                                v-if="form.errors.ruc"
                                class="text-xs text-red-500"
                            >
                                {{ form.errors.ruc }}
                            </p>
                        </transition>

                        <ul
                            class="flex-wrap text-xs text-slate-400 mt-2 list-disc list-inside"
                        >
                            <li class="first-letter:capitalize lowercase">
                                {{ __("enter company ruc") }}
                            </li>
                        </ul>
                    </div>
                </div>

                <div
                    class="grid grid-cols-1 gap-x-3 lg:grid-cols-2 mb-2 lg:mb-0 last:mb-0"
                >
                    <div class="mb-2 last:mb-0 first-letter:capitalize">
                        <label
                            for="ruc"
                            class="first-letter:capitalize lowercase text-sm"
                            >{{ __("contact number") }}
                            <b class="text-red-500">*</b></label
                        >

                        <input
                            v-model="form.contact_number"
                            type="text"
                            name="contact_number"
                            class="w-full bg-white text-sm border border-slate-300 rounded-md shadow placeholder:capitalize"
                            :placeholder="__('contact number')"
                            autofocus
                            autocomplete="off"
                        />

                        <transition name="fade">
                            <p
                                v-if="form.errors.contact_number"
                                class="text-xs text-red-500"
                            >
                                {{ form.errors.contact_number }}
                            </p>
                        </transition>

                        <ul
                            class="flex-wrap text-xs text-slate-400 mt-2 list-disc list-inside"
                        >
                            <li class="first-letter:capitalize lowercase">
                                {{ __("enter contact number of the company") }}
                            </li>
                        </ul>
                    </div>
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
                                {{ __("enter the company's email address") }}
                            </li>
                        </ul>
                    </div>
                </div>

                <div
                    class="grid grid-cols-1 gap-x-3 lg:grid-cols-2 mb-2 lg:mb-0 last:mb-0"
                >
                    <div class="mb-2 last:mb-0 first-letter:capitalize">
                        <label
                            for="address"
                            class="first-letter:capitalize lowercase text-sm"
                            >{{ __("address") }}
                            <b class="text-red-500">*</b></label
                        >

                        <input
                            v-model="form.address"
                            type="text"
                            name="address"
                            class="w-full bg-white text-sm border border-slate-300 rounded-md shadow placeholder:capitalize"
                            :placeholder="__('example of address')"
                            autofocus
                            autocomplete="off"
                        />

                        <transition name="fade">
                            <p
                                v-if="form.errors.address"
                                class="text-xs text-red-500"
                            >
                                {{ form.errors.address }}
                            </p>
                        </transition>

                        <ul
                            class="flex-wrap text-xs text-slate-400 mt-2 list-disc list-inside"
                        >
                            <li class="first-letter:capitalize lowercase">
                                {{ __("enter the customer's address") }}
                            </li>
                        </ul>
                    </div>
                    <div class="mb-2 last:mb-0 first-letter:capitalize">
                        <label
                            for="regime_category"
                            class="first-letter:capitalize lowercase text-sm"
                            >{{ __("regime category") }}
                            <b class="text-red-500">*</b></label
                        >

                        <input
                            v-model="form.regime_category"
                            type="text"
                            name="regime_category"
                            class="w-full bg-white text-sm border border-slate-300 rounded-md shadow placeholder:capitalize"
                            :placeholder="__('regime category')"
                            autofocus
                            autocomplete="off"
                        />

                        <transition name="fade">
                            <p
                                v-if="form.errors.regime_category"
                                class="text-xs text-red-500"
                            >
                                {{ form.errors.regime_category }}
                            </p>
                        </transition>

                        <ul
                            class="flex-wrap text-xs text-slate-400 mt-2 list-disc list-inside"
                        >
                            <li class="first-letter:capitalize lowercase">
                                {{ __("enter the regime category") }}
                            </li>
                        </ul>
                    </div>
                </div>
                <div
                    class="grid grid-cols-1 gap-x-3 lg:grid-cols-2 mb-2 lg:mb-0 last:mb-0"
                >
                    <div class="mb-2 last:mb-0 first-letter:capitalize">
                        <label
                            for="logo"
                            class="first-letter:capitalize lowercase text-sm"
                            >{{ __("company logo") }}</label
                        >

                        <input
                            type="file"
                            name="logo"
                            @change="handleLogoChange"
                            class="w-full bg-white text-sm border border-slate-300 rounded-md shadow placeholder:capitalize"
                            autofocus
                        />

                        <transition name="fade">
                            <p
                                v-if="form.errors.logo"
                                class="text-xs text-red-500"
                            >
                                {{ form.errors.logo }}
                            </p>
                        </transition>
                    </div>
                    <div class="mb-2 last:mb-0 first-letter:capitalize">
                        <img
                            :src="form.logoUrl"
                            alt="Logo de la empresa"
                            style="max-width: 100px; max-height: 100px"
                            accept="image/jpeg, image/png, image/jpg, image/gif"
                        />
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
                    :href="route('customers.index')"
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
                company_name: new String(),
                ruc: new String(),
                address: new String(),
                contact_number: new String(),
                regime_category: new String(),
                email: new String(),
                logoUrl: new String(),
                logo: null,
            }),
        };
    },
    methods: {
        handleLogoChange(event) {
            this.form.logo = event.target.files[0];
            this.form.logoUrl = URL.createObjectURL(event.target.files[0]);
            console.log(this.form.logo);
        },
        submit() {
            this.form.post(route("superuser.configuration.submit"), {
                onSuccess: () => {
                    this.form.reset();
                    this.form.logo = null;
                },
            });
        },
    },
    mounted() {
        if (this.configuration) {
            this.form.company_name = this.configuration.company_name;
            this.form.ruc = this.configuration.ruc;
            this.form.address = this.configuration.address;
            this.form.contact_number = this.configuration.contact_number;
            this.form.regime_category = this.configuration.regime_category;
            this.form.email = this.configuration.email;
            this.form.logoUrl = this.configuration.logoUrl;
        }
    },
});
</script>

<style src="@vueform/multiselect/themes/default.css"></style>
