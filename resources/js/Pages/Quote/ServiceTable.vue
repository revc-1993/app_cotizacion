<template>
    <div class="grid grid-cols-1 gap-x-3 lg:grid-cols-2 mb-2 lg:mb-0 last:mb-0">
        <div class="mb-2 last:mb-0 first-letter:capitalize">
            <Multiselect
                v-model="newDetailServiceData.typeOfService"
                :options="type_of_service"
                :clearOnSearch="false"
                :clearOnSelect="false"
                :searchable="true"
                :createTag="true"
                class="capitalize placeholder:capitalize"
                :placeholder="__('choose an option')"
            />
            <transition name="fade">
                <p
                    v-if="newDetailServiceErrors.typeOfService.alert"
                    class="text-xs text-red-500"
                >
                    {{ newDetailServiceErrors.typeOfService.message }}
                </p>
            </transition>
        </div>
        <div class="mb-2 last:mb-0 first-letter:capitalize" />
    </div>

    <!-- <transition name="fade">
        <p v-if="form.errors.type_of_service" class="text-xs text-red-500">
            {{ form.errors.type_of_service }}
        </p>
    </transition> -->

    <!-- <div class="overflow-auto border border-slate-200 rounded my-4"> -->
    <table class="border-collapse w-full text-sm">
        <thead class="bg-slate-200">
            <tr>
                <th class="border border-slate-200 px-3 py-2 uppercase">
                    {{ __("no") }}
                </th>
                <th class="border border-slate-200 px-3 py-2 uppercase">
                    {{ __("count") }}
                </th>
                <th class="border border-slate-200 px-3 py-2 uppercase">
                    {{ __("detail service") }}
                </th>
                <th class="border border-slate-200 px-3 py-2 uppercase">
                    {{ __("pvp provider") }}
                </th>
                <th class="border border-slate-200 px-3 py-2 uppercase">
                    {{ __("utility") }} %
                </th>
                <th class="border border-slate-200 px-3 py-2 uppercase">
                    {{ __("utility") }} USD
                </th>
                <th class="border border-slate-200 px-3 py-2 uppercase">
                    {{ __("subtotal") }}
                </th>
                <th></th>
            </tr>
        </thead>

        <tbody class="bg-white">
            <tr>
                <td class="border border-slate-200 px-3 py-1 text-center"></td>
                <td class="border border-slate-200 px-3 py-1 text-center">
                    <input
                        v-model="newDetailServiceData.amountOfService"
                        type="number"
                        name="amount_of_service"
                        class="flex w-full bg-white text-xs border border-slate-300 rounded-md shadow placeholder:capitalize text-center"
                        :placeholder="__('amount of service')"
                        autofocus
                        autocomplete="off"
                    />
                </td>
                <td class="border border-slate-200 px-3 py-1 text-center w-1/4">
                    <Multiselect
                        v-model="newDetailServiceData.service"
                        :options="
                            getServiceByType(newDetailServiceData.typeOfService)
                        "
                        :clearOnSearch="false"
                        :clearOnSelect="false"
                        :searchable="true"
                        :createTag="true"
                        :disabled="newDetailServiceData.typeOfService === ''"
                        class="text-xs capitalize placeholder:capitalize selected:text-xs text-center"
                    >
                        <template v-slot:singleLabel="{ option }">
                            <span class="text-xs">{{ option }}</span>
                        </template>
                    </Multiselect>
                </td>
                <td class="border border-slate-200 px-3 py-1 text-center">
                    <div class="flex">
                        <div class="relative w-full">
                            <input
                                v-model="newDetailServiceData.pvpProvider"
                                type="number"
                                name="pvp_provider"
                                class="w-full bg-white text-xs border border-slate-300 rounded-md shadow placeholder:capitalize text-center"
                                :placeholder="__('pvp provider')"
                                autofocus
                                autocomplete="off"
                            />
                            <span
                                class="absolute inset-y-0 left-0 flex items-center pl-6 text-md text-gray-500"
                                >$</span
                            >
                        </div>
                    </div>
                </td>
                <td class="border border-slate-200 px-3 py-1 text-center">
                    <div class="flex">
                        <div class="relative w-full">
                            <input
                                v-model="newDetailServiceData.utility"
                                type="number"
                                name="utility"
                                class="w-full bg-white text-xs border border-slate-300 rounded-md shadow placeholder:capitalize text-center"
                                :placeholder="__('utility')"
                                autofocus
                                autocomplete="off"
                            />
                            <span
                                class="absolute inset-y-0 right-0 flex items-center pr-10 text-md text-gray-500"
                                >%</span
                            >
                        </div>
                    </div>
                </td>
                <td class="border border-slate-200 px-3 py-1 text-center">
                    <b> $ {{ utility }} </b>
                </td>
                <td class="border border-slate-200 px-3 py-1 text-center">
                    <b> $ {{ subtotal }} </b>
                </td>
                <td class="border border-slate-200 px-3 py-1 text-center">
                    <button
                        class="bg-green-600 border border-green-700 shadow rounded-md px-2 py-1 text-xs"
                        @click.prevent="addDetailService()"
                    >
                        <Icon src="add" class="text-white py-1 w-3 h-3" />
                    </button>
                </td>
            </tr>

            <tr v-for="(row, index) in detailsService" :key="index">
                <td class="border border-slate-200 px-3 py-1 text-center">
                    {{ index + 1 }}
                </td>
                <td class="border border-slate-200 px-3 py-1 text-center">
                    {{ row.amount_of_service }}
                </td>
                <td class="border border-slate-200 px-3 py-1 text-center">
                    {{ row.service }}
                </td>
                <td class="border border-slate-200 px-3 py-1 text-center">
                    {{ formattedNumber(row.pvp_provider) }}
                </td>
                <td class="border border-slate-200 px-3 py-1 text-center">
                    {{ row.utility }}%
                </td>
                <td class="border border-slate-200 px-3 py-1 text-center">
                    {{ formattedNumber(row.utility_usd) }}
                </td>
                <td class="border border-slate-200 px-3 py-1 text-center">
                    {{ formattedNumber(row.subtotal) }}
                </td>
                <td class="border border-slate-200 px-3 py-1 text-center">
                    <button
                        class="bg-red-600 border border-red-700 shadow rounded-md px-2 py-1 text-xs"
                        @click.prevent="removeDetailService(index)"
                    >
                        <Icon src="trash" class="text-white py-1 w-3 h-3" />
                    </button>
                </td>
            </tr>
        </tbody>
    </table>
    <!-- </div> -->
    <transition name="fade">
        <p
            v-if="newDetailServiceErrors.amountOfService.alert"
            class="text-xs text-red-500"
        >
            {{ newDetailServiceErrors.amountOfService.message }}
        </p>
    </transition>
    <transition name="fade">
        <p
            v-if="newDetailServiceErrors.service.alert"
            class="text-xs text-red-500"
        >
            {{ newDetailServiceErrors.service.message }}
        </p>
    </transition>
    <transition name="fade">
        <p
            v-if="newDetailServiceErrors.pvpProvider.alert"
            class="text-xs text-red-500"
        >
            {{ newDetailServiceErrors.pvpProvider.message }}
        </p>
    </transition>
    <transition name="fade">
        <p
            v-if="newDetailServiceErrors.utility.alert"
            class="text-xs text-red-500"
        >
            {{ newDetailServiceErrors.utility.message }}
        </p>
    </transition>
</template>

<script>
import { defineComponent } from "vue";
import { Link } from "@inertiajs/inertia-vue3";
import Multiselect from "@vueform/multiselect";
import { Inertia } from "@inertiajs/inertia";
import Swal from "sweetalert2";
import Icon from "@/Components/Icon";
import { computed } from "vue";

export default defineComponent({
    props: {
        detailsService: Array,
    },

    components: {
        Link,
        Icon,
        Multiselect,
    },

    data() {
        return {
            search: new String(),
            newDetailServiceData: {
                typeOfService: new String(),
                amountOfService: new Number(),
                service: new String(),
                pvpProvider: new Number(),
                utility: new Number(),
            },
            newDetailServiceErrors: {
                typeOfService: {
                    alert: false,
                    message: "",
                },
                amountOfService: {
                    alert: false,
                    message: "",
                },
                service: {
                    alert: false,
                    message: "",
                },
                pvpProvider: {
                    alert: false,
                    message: "",
                },
                utility: {
                    alert: false,
                    message: "",
                },
            },
            type_of_service: ["Generales", "Locales", "Sin IVA"],
            general_services: [
                "AIR WAY BILL - AWB",
                "PICKUP",
                "HANDLING",
                "MESSENGER",
                "DOCUMENTATION",
                "TRANSFER & ISD",
                "WAREHOUSE FEE",
            ],
            local_services: [
                "CUSTODIA",
                "ESTIBA",
                "HONORARIOS AGENTE/ADUANA",
                "DOCUMENTACION",
                "BODEGAJE (APROX)",
                "TRANSPORTE",
            ],
            without_iva_services: ["FLETE INTERNACIONAL"],
        };
    },
    computed: {
        utility: function () {
            return (
                (this.newDetailServiceData.amountOfService *
                    this.newDetailServiceData.pvpProvider *
                    this.newDetailServiceData.utility) /
                100
            );
        },
        subtotal: function () {
            return (
                this.newDetailServiceData.amountOfService *
                    this.newDetailServiceData.pvpProvider +
                this.utility
            );
        },
    },
    methods: {
        addDetailService() {
            if (this.validateDetailService()) {
                this.detailsService.push({
                    type_of_service: this.newDetailServiceData.typeOfService,
                    amount_of_service:
                        this.newDetailServiceData.amountOfService,
                    service: this.newDetailServiceData.service,
                    pvp_provider: this.newDetailServiceData.pvpProvider,
                    utility: this.newDetailServiceData.utility,
                    utility_usd: this.utility,
                    subtotal: this.subtotal,
                });

                this.emptyInputsDetailService();
            }
        },

        emptyInputsDetailService() {
            this.newDetailServiceData.typeOfService = "";
            this.newDetailServiceData.amountOfService = 0;
            this.newDetailServiceData.service = "";
            this.newDetailServiceData.pvpProvider = 0;
            this.newDetailServiceData.utility = 0;
        },

        validateDetailService() {
            this.resetInputServiceErrors();

            let count = 0;

            // count++;

            // Tipo de servicios
            if (this.newDetailServiceData.typeOfService === "") {
                this.newDetailServiceErrors.typeOfService.alert = true;
                this.newDetailServiceErrors.typeOfService.message =
                    "El campo Categoría de servicio no puede ser vacío";
                count++;
            }
            // Cantidad de servicios
            if (!this.newDetailServiceData.amountOfService > 0) {
                this.newDetailServiceErrors.amountOfService.alert = true;
                this.newDetailServiceErrors.amountOfService.message =
                    "El campo Cantidad de servicios no puede ser cero (0)";
                count++;
            }
            // Detalle de servicios
            if (this.newDetailServiceData.service === "") {
                this.newDetailServiceErrors.service.alert = true;
                this.newDetailServiceErrors.service.message =
                    "El campo Detalle de servicio no puede ser vacío";
                count++;
            }
            // PVP Proveedor
            if (!this.newDetailServiceData.pvpProvider > 0) {
                this.newDetailServiceErrors.pvpProvider.alert = true;
                this.newDetailServiceErrors.pvpProvider.message =
                    "El campo PVP Proveedor no puede ser cero (0)";
                count++;
            }
            // Utilidad %
            if (!this.newDetailServiceData.utility > 0) {
                this.newDetailServiceErrors.utility.alert = true;
                this.newDetailServiceErrors.utility.message =
                    "El campo Utilidad no puede ser cero (0)";
                count++;
            }

            return count === 0;
        },

        resetInputServiceErrors() {
            this.newDetailServiceErrors.typeOfService.alert = false;
            this.newDetailServiceErrors.amountOfService.alert = false;
            this.newDetailServiceErrors.service.alert = false;
            this.newDetailServiceErrors.pvpProvider.alert = false;
            this.newDetailServiceErrors.utility.alert = false;

            this.newDetailServiceErrors.typeOfService.message = "";
            this.newDetailServiceErrors.amountOfService.message = "";
            this.newDetailServiceErrors.service.message = "";
            this.newDetailServiceErrors.pvpProvider.message = "";
            this.newDetailServiceErrors.utility.message = "";
        },

        removeDetailService(index) {
            this.detailsService.splice(index, 1);
        },

        getServiceByType(type) {
            return type === "Generales"
                ? this.general_services
                : type === "Locales"
                ? this.local_services
                : type === "Sin IVA"
                ? this.without_iva_services
                : [];
        },
        formattedNumber(number) {
            const f = new Intl.NumberFormat("eng-US", {
                style: "currency",
                currency: "USD",
                minimumFractionDigits: 2,
                maximumFractionDigits: 2,
            });

            return f.format(number);
        },
    },
    mounted() {
        this.newDetailServiceData.typeOfService = "";
        this.newDetailServiceData.amountOfService = 1;
        this.newDetailServiceData.service = "";
        this.newDetailServiceData.pvpProvider = 0;
        this.newDetailServiceData.utility = 0;
    },
});
</script>
