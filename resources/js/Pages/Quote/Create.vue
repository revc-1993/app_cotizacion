<template>
    <DashboardLayout title="Crear cotización">
        <Toast v-if="toast" v-model="toast" :message="messageResource" />

        <h1>Crear cotización</h1>

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
                    <b> {{ __("registration date") }}: </b>
                    {{ new Date().toLocaleDateString() }}
                </label>
            </div>
            <div class="flex flex-col space-y-2 p-4">
                <div
                    class="grid grid-cols-1 gap-x-3 lg:grid-cols-2 mb-2 lg:mb-0 last:mb-0"
                >
                    <div class="mb-2 last:mb-0 first-letter:capitalize">
                        <label
                            for="ruc"
                            class="first-letter:capitalize lowercase text-sm"
                            >{{ __("ruc") }}</label
                        >
                        <form @submit.prevent="searchCustomerByRuc('alert')">
                            <div class="relative">
                                <div class="w-full">
                                    <div class="flex">
                                        <input
                                            v-model="formSearchCustomer.ruc"
                                            type="text"
                                            name="ruc"
                                            class="flex w-full bg-white text-sm border border-slate-300 rounded-tl-md rounded-bl-md shadow placeholder:capitalize"
                                            :placeholder="__('ruc')"
                                            autofocus
                                            autocomplete="off"
                                        />

                                        <button
                                            type="submit"
                                            class="inline-flex bg-blue-600 border border-blue-700 shadow px-3 py-1 text-xs uppercase"
                                        >
                                            <div
                                                class="flex items-center content-center space-x-2"
                                            >
                                                <Icon
                                                    src="search"
                                                    class="text-white pt-1 w-3 h-3"
                                                />
                                            </div>
                                        </button>
                                        <button
                                            type="submit"
                                            class="inline-flex rounded-tr-md rounded-br-md bg-green-600 border border-green-700 shadow px-3 py-1 text-xs uppercase"
                                        >
                                            <div
                                                class="flex items-center content-center space-x-2"
                                            >
                                                <Icon
                                                    src="add"
                                                    class="text-white pt-1 w-3 h-3"
                                                />
                                            </div>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <ul
                            class="flex-wrap text-xs text-slate-400 mt-2 list-disc list-inside"
                        >
                            <li class="first-letter:capitalize lowercase">
                                {{
                                    __(
                                        "enter the name you give to the quotation"
                                    )
                                }}
                            </li>
                        </ul>
                    </div>

                    <div class="mb-2 last:mb-0 first-letter:capitalize">
                        <label
                            for="name"
                            class="first-letter:capitalize lowercase text-sm"
                            >{{ __("name") }}</label
                        >

                        <input
                            v-model="form.name"
                            type="text"
                            name="name"
                            class="w-full bg-white text-sm border border-slate-300 rounded-md shadow placeholder:capitalize"
                            :placeholder="__('name')"
                            autofocus
                            disabled
                        />
                        <transition name="fade">
                            <p
                                v-if="form.errors.customer_id"
                                class="text-xs text-red-500"
                            >
                                {{ form.errors.customer_id }}
                            </p>
                        </transition>
                    </div>
                </div>

                <label
                    for="product"
                    class="first-letter:capitalize lowercase text-sm"
                    >{{ __("product") }}</label
                >

                <input
                    v-model="form.product"
                    type="text"
                    name="product"
                    class="w-full bg-white text-sm border border-slate-300 rounded-md shadow placeholder:capitalize"
                    :placeholder="__('product')"
                    autofocus
                    autocomplete="off"
                />

                <transition name="fade">
                    <p v-if="form.errors.product" class="text-xs text-red-500">
                        {{ form.errors.product }}
                    </p>
                </transition>

                <ul
                    class="flex-wrap text-xs text-slate-400 mt-2 list-disc list-inside"
                >
                    <li class="first-letter:capitalize lowercase">
                        {{ __("detail the product to be mobilized") }}
                    </li>
                </ul>

                <div
                    class="grid grid-cols-1 gap-x-3 lg:grid-cols-2 mb-2 lg:mb-0 last:mb-0"
                >
                    <div class="mb-2 last:mb-0 first-letter:capitalize">
                        <label
                            for="type_of_transport"
                            class="lowercase text-sm"
                            >{{ __("type of transport") }}</label
                        >

                        <div class="w-full">
                            <Multiselect
                                v-model="form.type_of_transport"
                                :options="type_of_transport"
                                :clearOnSearch="false"
                                :clearOnSelect="false"
                                :searchable="true"
                                :createTag="true"
                                class="capitalize placeholder:capitalize"
                                :placeholder="__('choose an option')"
                            />

                            <transition name="fade">
                                <p
                                    v-if="form.errors.type_of_transport"
                                    class="text-xs text-red-500"
                                >
                                    {{ form.errors.type_of_transport }}
                                </p>
                            </transition>

                            <ul
                                class="flex-wrap text-xs text-slate-400 mt-2 list-disc list-inside"
                            >
                                <li class="first-letter:capitalize lowercase">
                                    {{
                                        __(
                                            "choose a route name or write your own url if the route doesn't have a name / the route leads to an external link"
                                        )
                                    }}
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="mb-2 last:mb-0 first-letter:capitalize">
                        <label for="cargo_type" class="lowercase text-sm">{{
                            __("cargo type")
                        }}</label>

                        <div class="w-full">
                            <Multiselect
                                v-model="form.cargo_type"
                                :options="cargo_type"
                                :clearOnSearch="false"
                                :clearOnSelect="false"
                                :searchable="true"
                                :createTag="true"
                                class="capitalize placeholder:capitalize"
                                :placeholder="__('choose an option')"
                            />

                            <transition name="fade">
                                <p
                                    v-if="form.errors.cargo_type"
                                    class="text-xs text-red-500"
                                >
                                    {{ form.errors.cargo_type }}
                                </p>
                            </transition>

                            <ul
                                class="flex-wrap text-xs text-slate-400 mt-2 list-disc list-inside"
                            >
                                <li class="first-letter:capitalize lowercase">
                                    {{ __("choose the type of cargo") }}
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div
                    class="grid grid-cols-1 gap-x-3 lg:grid-cols-2 mb-2 lg:mb-0 last:mb-0"
                >
                    <div class="mb-2 last:mb-0 first-letter:capitalize">
                        <label
                            for="number_of_containers"
                            class="first-letter:capitalize lowercase text-sm"
                            >{{ __("amount of charge") }}</label
                        >

                        <input
                            v-model="form.number_of_containers"
                            type="number"
                            name="number_of_containers"
                            class="w-full bg-white text-sm border border-slate-300 rounded-md shadow placeholder:capitalize"
                            :placeholder="__('amount of charge')"
                            autofocus
                            min="0"
                            autocomplete="off"
                        />

                        <transition name="fade">
                            <p
                                v-if="form.errors.number_of_containers"
                                class="text-xs text-red-500"
                            >
                                {{ form.errors.number_of_containers }}
                            </p>
                        </transition>

                        <ul
                            class="flex-wrap text-xs text-slate-400 mt-2 list-disc list-inside"
                        >
                            <li class="first-letter:capitalize lowercase">
                                {{
                                    __(
                                        "enter the number of load(s) or package(s)"
                                    )
                                }}
                            </li>
                        </ul>
                    </div>
                    <div class="mb-2 last:mb-0 first-letter:capitalize">
                        <label
                            for="single_cargo_name"
                            class="first-letter:capitalize lowercase text-sm"
                            >{{ __("single cargo name") }}</label
                        >

                        <input
                            v-model="form.single_cargo_name"
                            type="text"
                            name="single_cargo_name"
                            class="w-full bg-white text-sm border border-slate-300 rounded-md shadow placeholder:capitalize"
                            :placeholder="__('single cargo name')"
                            autofocus
                            autocomplete="off"
                        />

                        <transition name="fade">
                            <p
                                v-if="form.errors.single_cargo_name"
                                class="text-xs text-red-500"
                            >
                                {{ form.errors.single_cargo_name }}
                            </p>
                        </transition>

                        <ul
                            class="flex-wrap text-xs text-slate-400 mt-2 list-disc list-inside"
                        >
                            <li class="first-letter:capitalize lowercase">
                                {{ __("choose the cargo name") }}
                            </li>
                        </ul>
                    </div>
                </div>

                <div
                    class="grid grid-cols-2 gap-x-3 lg:grid-cols-4 space-y-2 p-4 w-full"
                >
                    <div>
                        <label
                            for="weight"
                            class="first-letter:capitalize lowercase text-sm"
                            >{{ __("weight") }}</label
                        >

                        <input
                            v-model="form.weight"
                            type="number"
                            name="weight"
                            class="w-full bg-white text-sm border border-slate-300 rounded-md shadow placeholder:capitalize"
                            :placeholder="__('weight')"
                            autofocus
                            autocomplete="off"
                            min="0"
                            :disabled="form.cargo_type !== 'Suelta'"
                        />

                        <transition name="fade">
                            <p
                                v-if="form.errors.weight"
                                class="text-xs text-red-500"
                            >
                                {{ form.errors.weight }}
                            </p>
                        </transition>
                    </div>

                    <div>
                        <label
                            for="unit_of_weight_measurement"
                            class="first-letter:capitalize lowercase text-sm"
                            >{{ __("unit of measurement") }}</label
                        >

                        <div class="w-full">
                            <Multiselect
                                v-model="form.unit_of_weight_measurement"
                                :options="unit_of_weight_measurement"
                                :clearOnSearch="false"
                                :clearOnSelect="false"
                                :searchable="true"
                                :createTag="true"
                                class="capitalize placeholder:capitalize"
                                :disabled="form.cargo_type !== 'Suelta'"
                            />
                        </div>
                        <transition name="fade">
                            <p
                                v-if="form.errors.unit_of_weight_measurement"
                                class="text-xs text-red-500"
                            >
                                {{ form.errors.unit_of_weight_measurement }}
                            </p>
                        </transition>
                    </div>
                    <div>
                        <label
                            for="length"
                            class="first-letter:capitalize lowercase text-sm"
                            >{{ __("length") }}</label
                        >

                        <input
                            v-model="form.length"
                            type="number"
                            name="length"
                            class="w-full bg-white text-sm border border-slate-300 rounded-md shadow placeholder:capitalize"
                            :placeholder="__('length')"
                            autofocus
                            autocomplete="off"
                            min="0"
                            :disabled="form.cargo_type !== 'Suelta'"
                        />

                        <transition name="fade">
                            <p
                                v-if="form.errors.length"
                                class="text-xs text-red-500"
                            >
                                {{ form.errors.length }}
                            </p>
                        </transition>
                    </div>
                    <div>
                        <label
                            for="unit_of_length_measurement"
                            class="first-letter:capitalize lowercase text-sm"
                            >{{ __("unit of measurement") }}</label
                        >

                        <div class="w-full">
                            <Multiselect
                                v-model="form.unit_of_length_measurement"
                                :options="unit_of_length_measurement"
                                :clearOnSearch="false"
                                :clearOnSelect="false"
                                :searchable="true"
                                :createTag="true"
                                class="capitalize placeholder:capitalize"
                                :disabled="form.cargo_type !== 'Suelta'"
                            />

                            <transition name="fade">
                                <p
                                    v-if="
                                        form.errors.unit_of_length_measurement
                                    "
                                    class="text-xs text-red-500"
                                >
                                    {{ form.errors.unit_of_length_measurement }}
                                </p>
                            </transition>
                        </div>
                    </div>
                </div>

                <label
                    for="containerized_cargo_type"
                    class="first-letter:capitalize lowercase text-sm"
                    >{{ __("containerized cargo type") }}</label
                >

                <div class="w-full">
                    <Multiselect
                        v-model="form.containerized_cargo_type"
                        :options="containerized_cargo_type"
                        :clearOnSearch="false"
                        :clearOnSelect="false"
                        :searchable="true"
                        :createTag="true"
                        class="capitalize placeholder:capitalize"
                        :disabled="form.cargo_type !== 'Contenerizada'"
                    />

                    <transition name="fade">
                        <p
                            v-if="form.errors.containerized_cargo_type"
                            class="text-xs text-red-500"
                        >
                            {{ form.errors.containerized_cargo_type }}
                        </p>
                    </transition>

                    <ul
                        class="flex-wrap text-xs text-slate-400 mt-2 list-disc list-inside"
                    >
                        <li class="first-letter:capitalize lowercase">
                            {{
                                __(
                                    "if you chose the type of containerized cargo, choose the type that corresponds to the containerized cargo"
                                )
                            }}
                        </li>
                    </ul>
                </div>
            </div>

            <div
                class="flex items-center justify-end bg-slate-200 px-4 py-2 space-x-2 text-xs"
            >
                <button
                    class="bg-slate-700 text-slate-200 border border-slate-800 rounded-md shadow px-3 py-2 uppercase font-bold"
                >
                    {{ __("create") }}
                </button>

                <Link
                    :href="route('quotes.index')"
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
import DataTable from "./DataTable";
import Multiselect from "@vueform/multiselect";
import Card from "./Card";
import Icon from "@/Components/Icon";
import axios from "axios";
import Toast from "@/Components/Toast.vue";

export default defineComponent({
    props: {
        quotes: Object,
        count: Object,
        perPage: Number,
        search: String,
    },

    components: {
        DashboardLayout,
        Link,
        DataTable,
        Multiselect,
        Card,
        Icon,
        Toast,
    },

    data() {
        return {
            form: useForm({
                name: new String(),
                type_of_transport: new String(),
                product: new String(),
                cargo_type: new String(),
                weight: new Number(),
                unit_of_weight_measurement: new String(),
                length: new Number(),
                unit_of_length_measurement: new String(),
                containerized_cargo_type: new String(),
                number_of_containers: new Number(),
                single_cargo_name: new String(),
                customer_id: new String(),
            }),
            formSearchCustomer: useForm({
                ruc: new String(),
            }),
            modal: {
                show: false,
                type: new String(),
            },
            type_of_transport: ["Marítimo", "Aéreo", "Terrestre"],
            cargo_type: ["Suelta", "Granel", "Contenerizada"],
            containerized_cargo_type: [
                "DRY-VAN 20",
                "DRY-VAN 40 HC",
                "BREAKBULK",
                "REEFER 20",
                "REEFER 40",
                "OPEN SIDE",
                "OPEN TOP",
                "FLAT RACK",
                "CISTERNA",
            ],
            unit_of_weight_measurement: ["KG", "LB", "TON"],
            unit_of_length_measurement: ["M", "CM"],
            toast: false,
            messageResource: "",
        };
    },
    methods: {
        submit() {
            this.form.post(route("quotes.store"), {
                onSuccess: () => this.form.reset(),
            });
        },
        searchCustomerByRuc(alert = "alert") {
            axios
                .get(
                    "/customers/getCustomerByRuc?ruc=" +
                        this.formSearchCustomer.ruc
                )
                .then((response) => {
                    if (response) {
                        this.form.clearErrors("customer_id");
                        this.form.customer_id = response.data.customer.id;
                        this.formSearchCustomer.ruc =
                            response.data.customer.ruc;
                        this.form.name =
                            response.data.customer.name +
                            " " +
                            response.data.customer.last_name;

                        this.toast = true;
                        this.messageResource = {
                            response:
                                "Se encontró el cliente con RUC " +
                                response.data.customer.ruc,
                            operation: 1,
                        };
                    }
                })
                .catch((error) => {
                    if (this.form.customer_id !== null)
                        this.form.customer_id = null;
                    this.form.name = "";
                    console.log(error);

                    this.toast = true;
                    this.messageResource = {
                        response: "No se encontró un cliente con este RUC",
                        operation: 4,
                    };
                });
        },
    },
});
</script>

<style src="@vueform/multiselect/themes/default.css"></style>
