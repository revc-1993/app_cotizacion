<template>
    <div class="bg-white border rounded-md shadow-xl p-4">
        <div class="flex items-center justify-between mb-2">
            <input
                v-model="search"
                type="text"
                name="search"
                class="bg-white text-xs border border-slate-200 rounded w-full sm:w-1/3 placeholder:capitalize"
                :placeholder="__('search something')"
            />
            <div class="w-full flex space-x-2">
                <button
                    @click.prevent="exportToExcel"
                    class="bg-green-600 border border-green-700 rounded shadow px-3 py-1 m-[1px] text-xs uppercase text-white font-semibold"
                >
                    {{ __("excel") }}
                </button>
                <button
                    @click.prevent="exportToPDF"
                    class="bg-red-600 border border-red-700 rounded shadow px-3 py-1 m-[1px] text-xs uppercase text-white font-semibold"
                >
                    {{ __("pdf") }}
                </button>
            </div>
        </div>

        <div class="overflow-auto border border-slate-200 rounded">
            <table class="border-collapse w-full">
                <thead class="bg-slate-200">
                    <tr>
                        <th class="border border-slate-200 px-3 py-2 uppercase">
                            {{ __("no") }}
                        </th>
                        <th class="border border-slate-200 px-3 py-2 uppercase">
                            {{ __("registration date") }}
                        </th>
                        <th class="border border-slate-200 px-3 py-2 uppercase">
                            {{ __("amount") }} USD
                        </th>
                        <th class="border border-slate-200 px-3 py-2 uppercase">
                            {{ __("client ruc") }}
                        </th>
                        <th class="border border-slate-200 px-3 py-2 uppercase">
                            {{ __("client name") }}
                        </th>
                        <th class="border border-slate-200 px-3 py-2 uppercase">
                            {{ __("state") }}
                        </th>
                    </tr>
                </thead>

                <tbody class="bg-white">
                    <tr
                        v-if="quotes"
                        v-for="(quote, i) in quotes"
                        :key="i"
                        class="hover:bg-slate-100"
                    >
                        <td
                            class="border border-slate-200 px-3 py-1 text-center"
                        >
                            {{ i + 1 }}
                        </td>
                        <td class="border border-slate-200 px-3 py-1 uppercase">
                            {{
                                new Date(quote.registration_date)
                                    .toISOString()
                                    .split("T")[0]
                            }}
                        </td>
                        <td class="border border-slate-200 px-3 py-1 uppercase">
                            $ {{ quote.total }}
                        </td>
                        <td class="border border-slate-200 px-3 py-1 uppercase">
                            {{ quote.customer.ruc }}
                        </td>
                        <td class="border border-slate-200 px-3 py-1 uppercase">
                            {{
                                quote.customer.name +
                                " " +
                                quote.customer.last_name
                            }}
                        </td>
                        <td class="border border-slate-200 px-3 py-1 uppercase">
                            <div
                                v-if="
                                    quote.registration_date &&
                                    quote.quote_validity
                                "
                            ></div>
                            <SpanState
                                v-if="
                                    quote.registration_date &&
                                    quote.quote_validity
                                "
                                :state="quote.state"
                            />
                            <div v-else>-</div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <!-- <transition name="fade">
        <ModalPDF
            v-if="showPdf"
            :quote="quote"
            :preview="false"
            :client="quote.customer"
            @close="showPdf = false"
            ref="modalPDF"
        />
    </transition> -->
</template>

<script>
import { defineComponent } from "vue";
import { Link } from "@inertiajs/inertia-vue3";
// import ModalPDF from "./ModalPDF";
import { Inertia } from "@inertiajs/inertia";
import Swal from "sweetalert2";
import Icon from "@/Components/Icon";
import SpanState from "@/Components/SpanState";
import axios from "axios";
import XLSX from "xlsx/dist/xlsx.full.min";
import { jsPDF } from "jspdf";
// import "jspdf-autotable";

export default defineComponent({
    props: {
        quotes: Array,
    },

    components: {
        Link,
        Icon,
        // ModalPDF,
        SpanState,
    },

    data() {
        return {
            search: new String(),
            showPdf: false,
            quote: Object,
        };
    },

    methods: {
        exportToExcel() {
            const quotesForExport = this.quotes.map((quote, i) => [
                i + 1,
                new Date(quote.registration_date).toISOString().split("T")[0],
                `$ ${quote.total}`,
                quote.customer.ruc,
                quote.customer.name + " " + quote.customer.last_name,
                this.state(quote.registration_date, quote.quote_validity),
            ]);

            const worksheet = XLSX.utils.aoa_to_sheet([
                [
                    "No",
                    "Fecha de Registro",
                    "Monto",
                    "RUC del Cliente",
                    "Nombre del Cliente",
                    "Estado",
                ],
                ...quotesForExport,
            ]);

            const workbook = XLSX.utils.book_new();
            XLSX.utils.book_append_sheet(workbook, worksheet, "Quotes");
            XLSX.writeFile(workbook, "quotes.xlsx");
        },

        exportToPDF() {},
        viewPdf(id) {
            axios.get(route("quotes.show", { id: id })).then((response) => {
                this.quote = response.data.quote;
                this.showPdf = true;
            });
        },
        state(registration_date, quote_validity) {
            // current date
            const currentDate = new Date();

            // registration date
            const effectiveDate = new Date(registration_date);
            // suma los días válidos
            effectiveDate.setDate(effectiveDate.getDate() + quote_validity);

            // compara fechas
            return currentDate <= effectiveDate ? "pendiente" : "denegada";
        },
    },
});
</script>
