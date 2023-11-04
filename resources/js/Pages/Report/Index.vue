<template>
    <DashboardLayout title="Reportes">
        <div
            class="w-full bg-white border border-slate-200 rounded-md shadow-xl"
        >
            <div
                class="flex items-center justify-start bg-slate-200 px-4 py-2 space-x-2 text-xs"
            >
                <label class="capitalize text-sm">
                    <b> {{ __("reports") }} </b>
                </label>
            </div>
            <div class="flex flex-col space-y-2 p-4 mb-2 lg:mb-0 last:mb-0">
                <div
                    class="mb-2 last:mb-0 first-letter:capitalize lowercase text-sm"
                >
                    <div class="w-full flex space-x-2">
                        <Multiselect
                            v-model="customer"
                            :options="customerss"
                            :clearOnSearch="false"
                            :clearOnSelect="false"
                            :searchable="true"
                            :createTag="true"
                            class="capitalize placeholder:capitalize"
                            :placeholder="__('customer')"
                        />
                        <Multiselect
                            v-model="user"
                            :options="userss"
                            :clearOnSearch="false"
                            :clearOnSelect="false"
                            :searchable="true"
                            :createTag="true"
                            class="capitalize placeholder:capitalize"
                            :placeholder="__('user')"
                        />
                        <Multiselect
                            v-model="state"
                            :options="states"
                            :clearOnSearch="false"
                            :clearOnSelect="false"
                            :searchable="true"
                            :createTag="true"
                            class="capitalize placeholder:capitalize"
                            :placeholder="__('state')"
                        />
                        <input
                            v-model="startDate"
                            type="date"
                            name="startDate"
                            class="w-full bg-white text-sm border border-slate-300 rounded-md shadow placeholder:capitalize"
                        />
                        <input
                            v-model="endDate"
                            type="date"
                            name="startDate"
                            class="w-full bg-white text-sm border border-slate-300 rounded-md shadow placeholder:capitalize"
                        />
                        <button
                            @click.prevent="searchReport"
                            class="inline-flex rounded-tr-md bg-slate-700 text-slate-200 border border-slate-800 rounded-md shadow px-3 py-2 uppercase font-bold"
                        >
                            {{ __("search") }}
                        </button>
                        <!-- <ul
                                    class="flex-wrap text-xs text-slate-400 mt-2 list-disc list-inside"
                                >
                                    <li
                                        class="first-letter:capitalize lowercase"
                                    >
                                        {{ __("choose the type of transport") }}
                                    </li>
                                </ul> -->
                    </div>
                </div>
            </div>
        </div>
        <DataTable v-model:quotes="quotes" />
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
import { Link } from "@inertiajs/inertia-vue3";
import DashboardLayout from "@/Layouts/DashboardLayout";
import Multiselect from "@vueform/multiselect";
import DataTable from "./DataTable";
import Icon from "@/Components/Icon";
import axios from "axios";

export default defineComponent({
    props: {
        quotes: Array,
        users: Array,
        customers: Array,
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
            user: null,
            customer: null,
            userss: [],
            customerss: [],
            state: "",
            startDate: "",
            endDate: "",
            usersMapping: {},
            customersMapping: {},
            states: ["aceptada", "pendiente", "denegada"],
        };
    },

    computed: {
        selectedUserId() {
            return this.usersMapping[this.user];
        },
        selectedCustomerId() {
            return this.customersMapping[this.customer];
        },
    },

    methods: {
        searchReport() {
            const params = new URLSearchParams({
                customer: this.selectedCustomerId || null,
                user: this.selectedUserId || null,
                state: this.state || null,
                startDate: this.startDate || "",
                endDate: this.endDate || "",
            });

            const url = `/api/reports?${params.toString()}`;

            this.$inertia.get(url);
        },
    },

    mounted() {
        this.users?.forEach((item) => {
            this.usersMapping[item.name] = item.id;
            this.userss.push(item.name);
        });
        this.customers?.forEach((item) => {
            this.customersMapping[item.names] = item.id;
            this.customerss.push(item.names);
        });
    },
});
</script>

<style src="@vueform/multiselect/themes/default.css"></style>
