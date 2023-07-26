<template>
    <div class="overflow-auto border border-slate-200 rounded my-4">
        <table class="border-collapse w-full text-sm">
            <caption
                class="text-lg font-semibold text-center items-center mb-2 first-letter:capitalize lowercase"
            >
                {{
                    __("table title")
                }}
            </caption>
            <thead class="bg-slate-200">
                <tr>
                    <th class="border border-slate-200 px-3 py-2 uppercase">
                        {{ __("no") }}
                    </th>
                    <th class="border border-slate-200 px-3 py-2 uppercase">
                        {{ __("cargo type") }}
                    </th>
                    <th class="border border-slate-200 px-3 py-2 uppercase">
                        {{ __("product name") }}
                    </th>
                    <th class="border border-slate-200 px-3 py-2 uppercase">
                        {{ __("count") }}
                    </th>
                    <th
                        v-if="looseCargo"
                        class="border border-slate-200 px-3 py-2 uppercase"
                    >
                        {{ __("weight in tons") }}
                    </th>
                    <th
                        v-if="looseCargo"
                        class="border border-slate-200 px-3 py-2 uppercase"
                    >
                        {{ __("volume in mt") }}
                    </th>
                    <th></th>
                </tr>
            </thead>

            <tbody class="bg-white">
                <tr v-for="(row, index) in detailsCharge" :key="index">
                    <td class="border border-slate-200 px-3 py-1 text-center">
                        {{ index + 1 }}
                    </td>
                    <td class="border border-slate-200 px-3 py-1 text-center">
                        {{ cargoType }}
                    </td>
                    <td class="border border-slate-200 px-3 py-1 text-center">
                        {{ row.cargo_name }}
                    </td>
                    <td class="border border-slate-200 px-3 py-1 text-center">
                        {{ row.amount_of_charge }}
                    </td>
                    <td
                        v-if="looseCargo"
                        class="border border-slate-200 px-3 py-1 text-center"
                    >
                        {{ row.weight_calculated }}
                    </td>
                    <td
                        v-if="looseCargo"
                        class="border border-slate-200 px-3 py-1 text-center"
                    >
                        {{ row.volumen }}
                    </td>
                    <td class="border border-slate-200 px-3 py-1 text-center">
                        <button
                            class="bg-red-600 border border-red-700 shadow rounded-md px-2 py-1 text-xs"
                            @click.prevent="removeDetailCharge(index)"
                        >
                            <Icon src="trash" class="text-white py-1 w-3 h-3" />
                        </button>
                    </td>
                </tr>
                <tr v-if="detailsCharge.length > 0">
                    <td
                        colspan="3"
                        class="border border-slate-200 px-3 py-1 text-center first-letter:uppercase lowercase"
                    >
                        <b>
                            {{ __("total") }}
                        </b>
                    </td>
                    <td class="border border-slate-200 px-3 py-1 text-center">
                        <b>
                            {{ totalCharge }}
                        </b>
                    </td>
                    <td
                        v-if="looseCargo"
                        class="border border-slate-200 px-3 py-1 text-center"
                    >
                        <b>
                            {{ totalWeight }}
                        </b>
                    </td>
                    <td
                        v-if="looseCargo"
                        class="border border-slate-200 px-3 py-1 text-center"
                    >
                        <b>
                            {{ totalVolumen }}
                        </b>
                    </td>
                    <td
                        class="border border-slate-200 px-3 py-1 text-center"
                    ></td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
import { defineComponent } from "vue";
import { Link } from "@inertiajs/inertia-vue3";
import { Inertia } from "@inertiajs/inertia";
import Swal from "sweetalert2";
import Icon from "@/Components/Icon";
import { computed } from "vue";

export default defineComponent({
    props: {
        looseCargo: Boolean,
        detailsCharge: Array,
        cargoType: String,
    },

    components: {
        Link,
        Icon,
    },

    data() {
        return {
            search: new String(),
        };
    },
    computed: {
        totalCharge: function () {
            return this.detailsCharge.reduce(
                (sum, item) => sum + item.amount_of_charge,
                0
            );
        },
        totalWeight: function () {
            return this.detailsCharge.reduce(
                (sum, item) => sum + item.weight_calculated,
                0
            );
        },
        totalVolumen: function () {
            return this.detailsCharge.reduce(
                (sum, item) => sum + item.volumen,
                0
            );
        },
    },
    methods: {
        addDetailCharge() {
            this.detailsCharge.push({
                cargo_name: "",
                amount_of_charge: "",
                cargo_type: "",
                product_name: "",
                unit_of_weight_measurement: "",
                weight_calculated: "",
                volumen: "",
                unit_of_weight_measurement: "",
                weight: "",
                unit_of_length_measurement: "",
                length: "",
                width: "",
                high: "",
            });
        },
        removeDetailCharge(index) {
            this.detailsCharge.splice(index, 1);
        },
    },
});
</script>
