<template>
    <DashboardLayout title="Editar cotización">
        <h1>Editar cotización</h1>

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
                <label
                    for="name"
                    class="first-letter:capitalize lowercase text-sm"
                    >{{ __("quote name") }}</label
                >

                <input
                    v-model="form.name"
                    type="text"
                    name="name"
                    class="w-full bg-white text-sm border border-slate-300 rounded-md shadow placeholder:capitalize"
                    :placeholder="__('quote name')"
                    autofocus
                    autocomplete="off"
                />

                <transition name="fade">
                    <p v-if="form.errors.name" class="text-xs text-red-500">
                        {{ form.errors.name }}
                    </p>
                </transition>

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
                                    {{
                                        __(
                                            "choose a route name or write your own url if the route doesn't have a name / the route leads to an external link"
                                        )
                                    }}
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
                                    "choose a route name or write your own url if the route doesn't have a name / the route leads to an external link"
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
                    {{ __("edit") }}
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

export default defineComponent({
    props: {
        quote: Object,
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
        };
    },
    methods: {
        submit() {
            return this.form.patch(route("quotes.update", this.quote.id), {
                onSuccess: () => this.form.reset(),
            });
        },
    },

    mounted() {
        this.form.name = this.quote.name;
        this.form.type_of_transport = this.quote.type_of_transport;
        this.form.product = this.quote.product;
        this.form.cargo_type = this.quote.cargo_type;
        this.form.weight = this.quote.weight;
        this.form.unit_of_weight_measurement =
            this.quote.unit_of_weight_measurement;
        this.form.length = this.quote.length;
        this.form.unit_of_length_measurement =
            this.quote.unit_of_length_measurement;
        this.form.containerized_cargo_type =
            this.quote.containerized_cargo_type;
        this.form.number_of_containers = this.quote.number_of_containers;
        this.form.single_cargo_name = this.quote.single_cargo_name;
    },
});
</script>

<style src="@vueform/multiselect/themes/default.css"></style>
