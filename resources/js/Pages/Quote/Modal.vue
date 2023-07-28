<template>
    <div
        class="fixed top-0 left-0 w-full h-screen flex items-center justify-center z-10"
    >
        <div
            class="flex flex-col space-y-2 w-full max-w-6xl bg-white rounded-md shadow-xl"
        >
            <div
                class="flex-none w-full bg-slate-200 rounded-t-md flex items-center justify-between p-2"
            >
                <p
                    class="lowercase first-letter:capitalize font-semibold text-slate-800"
                >
                    {{ __("new customer") }}
                </p>

                <div class="flex items-center space-x-2">
                    <Icon
                        @click.prevent="$emit('close')"
                        src="times"
                        class="border border-slate-700 rounded-md px-1"
                    />
                </div>
            </div>

            <!-- CONTENIDO -->
            <form @submit.prevent="submit" class="w-full bg-white">
                <div class="flex flex-col space-y-2 p-4">
                    <div
                        class="grid grid-cols-1 gap-x-3 lg:grid-cols-2 mb-2 lg:mb-0 last:mb-0"
                    >
                        <div class="mb-2 last:mb-0 first-letter:capitalize">
                            <label
                                for="name"
                                class="first-letter:capitalize lowercase text-sm"
                                >{{ __("name") }}</label
                            >

                            <input
                                v-model="formCustomer.name"
                                type="text"
                                name="name"
                                class="w-full bg-white text-sm border border-slate-300 rounded-md shadow placeholder:capitalize"
                                :placeholder="__('name')"
                                autofocus
                                autocomplete="off"
                            />

                            <transition name="fade">
                                <p
                                    v-if="formCustomer.errors.name"
                                    class="text-xs text-red-500"
                                >
                                    {{ formCustomer.errors.name }}
                                </p>
                            </transition>

                            <ul
                                class="flex-wrap text-xs text-slate-400 mt-2 list-disc list-inside"
                            >
                                <li class="first-letter:capitalize lowercase">
                                    {{ __("enter customer name") }}
                                </li>
                            </ul>
                        </div>
                        <div class="mb-2 last:mb-0 first-letter:capitalize">
                            <label
                                for="last_name"
                                class="first-letter:capitalize lowercase text-sm"
                                >{{ __("last name") }}</label
                            >

                            <input
                                v-model="formCustomer.last_name"
                                type="text"
                                name="last_name"
                                class="w-full bg-white text-sm border border-slate-300 rounded-md shadow placeholder:capitalize"
                                :placeholder="__('last name')"
                                autofocus
                                autocomplete="off"
                            />

                            <transition name="fade">
                                <p
                                    v-if="formCustomer.errors.last_name"
                                    class="text-xs text-red-500"
                                >
                                    {{ formCustomer.errors.last_name }}
                                </p>
                            </transition>

                            <ul
                                class="flex-wrap text-xs text-slate-400 mt-2 list-disc list-inside"
                            >
                                <li class="first-letter:capitalize lowercase">
                                    {{ __("enter the customer's last name") }}
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
                                >{{ __("ruc") }}</label
                            >

                            <input
                                v-model="formCustomer.ruc"
                                type="text"
                                name="ruc"
                                class="w-full bg-white text-sm border border-slate-300 rounded-md shadow placeholder:capitalize"
                                :placeholder="__('example of ruc')"
                                autofocus
                                autocomplete="off"
                            />

                            <transition name="fade">
                                <p
                                    v-if="formCustomer.errors.ruc"
                                    class="text-xs text-red-500"
                                >
                                    {{ formCustomer.errors.ruc }}
                                </p>
                            </transition>

                            <ul
                                class="flex-wrap text-xs text-slate-400 mt-2 list-disc list-inside"
                            >
                                <li class="first-letter:capitalize lowercase">
                                    {{
                                        __(
                                            "enter the customer's registered ruc number"
                                        )
                                    }}
                                </li>
                            </ul>
                        </div>
                        <div class="mb-2 last:mb-0 first-letter:capitalize">
                            <label
                                for="email"
                                class="first-letter:capitalize lowercase text-sm"
                                >{{ __("email") }}</label
                            >

                            <input
                                v-model="formCustomer.email"
                                type="text"
                                name="email"
                                class="w-full bg-white text-sm border border-slate-300 rounded-md shadow placeholder:capitalize"
                                :placeholder="__('example of email')"
                                autofocus
                                autocomplete="off"
                            />

                            <transition name="fade">
                                <p
                                    v-if="formCustomer.errors.email"
                                    class="text-xs text-red-500"
                                >
                                    {{ formCustomer.errors.email }}
                                </p>
                            </transition>

                            <ul
                                class="flex-wrap text-xs text-slate-400 mt-2 list-disc list-inside"
                            >
                                <li class="first-letter:capitalize lowercase">
                                    {{
                                        __("enter the customer's email address")
                                    }}
                                </li>
                            </ul>
                        </div>
                    </div>

                    <label
                        for="address"
                        class="first-letter:capitalize lowercase text-sm"
                        >{{ __("address") }}</label
                    >

                    <input
                        v-model="formCustomer.address"
                        type="text"
                        name="address"
                        class="w-full bg-white text-sm border border-slate-300 rounded-md shadow placeholder:capitalize"
                        :placeholder="__('example of address')"
                        autofocus
                        autocomplete="off"
                    />

                    <transition name="fade">
                        <p
                            v-if="formCustomer.errors.address"
                            class="text-xs text-red-500"
                        >
                            {{ formCustomer.errors.address }}
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

                <div
                    class="flex items-center justify-end bg-slate-200 px-4 py-2 space-x-2 text-xs"
                >
                    <button
                        type="submit"
                        class="bg-slate-700 text-slate-200 border border-slate-800 rounded-md shadow px-3 py-2 uppercase font-bold"
                    >
                        {{ __("save") }}
                    </button>

                    <button
                        @click.prevent="$emit('close')"
                        class="bg-slate-50 border border-slate-300 rounded-md shadow px-3 py-2 uppercase font-bold"
                    >
                        {{ __("back") }}
                    </button>
                </div>
            </form>
        </div>
    </div>
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
import DataTable from "./DataTable";
import Multiselect from "@vueform/multiselect";
import Icon from "@/Components/Icon";

export default defineComponent({
    props: {
        newCustomer: Object,
    },
    components: {
        DashboardLayout,
        Link,
        DataTable,
        Multiselect,
        Icon,
    },

    data() {
        return {
            formCustomer: useForm({
                name: new String(),
                last_name: new String(),
                ruc: new String(),
                email: new String(),
                address: new String(),
            }),
        };
    },
    methods: {
        submit() {
            this.formCustomer.post("/customers/storeWithModal", {
                onSuccess: () => {
                    this.newCustomer.ruc = this.formCustomer.ruc;

                    this.formCustomer.reset();
                    this.$emit("close");
                },
                onError: (error) => {
                    console.log(error);
                },
            });
        },
    },
});
</script>

<style src="@vueform/multiselect/themes/default.css"></style>
