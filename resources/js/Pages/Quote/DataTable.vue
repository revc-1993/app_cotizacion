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
            <Link
                :href="route('quotes.create')"
                as="button"
                class="px-3 py-1 bg-slate-800 text-slate-100 text-sm border border-slate-700 rounded-md shadow-md uppercase"
            >
                <div class="flex items-center space-x-2">
                    <Icon src="pen" class="text-white flex-none w-3 h-3" />

                    <div class="flex-wrap pr-1">
                        <span class="text-white font-semibold">{{
                            __("create")
                        }}</span>
                    </div>
                </div>
            </Link>
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
                            {{ __("client ruc") }}
                        </th>
                        <th class="border border-slate-200 px-3 py-2 uppercase">
                            {{ __("client name") }}
                        </th>
                        <th class="border border-slate-200 px-3 py-2 uppercase">
                            {{ __("amount") }} USD
                        </th>
                        <th class="border border-slate-200 px-3 py-2 uppercase">
                            {{ __("state") }}
                        </th>
                        <th class="border border-slate-200 px-3 py-2 uppercase">
                            {{ __("action") }}
                        </th>
                    </tr>
                </thead>

                <tbody class="bg-white">
                    <tr
                        v-for="(quote, i) in quotes.filter((quote) =>
                            search.trim()
                                ? quote.registration_date.includes(
                                      search.trim()
                                  ) || quote.total.includes(search.trim())
                                : true
                        )"
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
                            $ {{ quote.total }}
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
                        <td class="border border-inherit px-2 py-1">
                            <div class="flex-wrap">
                                <button
                                    @click.prevent="viewPdf(quote.id)"
                                    class="bg-slate-600 border border-slate-700 rounded shadow px-3 py-1 m-[1px] text-xs uppercase"
                                >
                                    <div class="flex items-center space-x-2">
                                        <Icon
                                            src="view"
                                            class="text-white flex-none w-3 h-3"
                                        />

                                        <div class="flex-wrap pr-1">
                                            <span
                                                class="text-white font-semibold"
                                                >{{ __("view pdf") }}</span
                                            >
                                        </div>
                                    </div>
                                </button>

                                <Link
                                    :href="route('quotes.edit', quote.id)"
                                    as="button"
                                    class="bg-blue-600 border border-blue-700 rounded shadow px-3 py-1 m-[1px] text-xs uppercase"
                                >
                                    <div class="flex items-center space-x-2">
                                        <Icon
                                            src="pen"
                                            class="text-white flex-none w-3 h-3"
                                        />

                                        <div class="flex-wrap pr-1">
                                            <span
                                                class="text-white font-semibold"
                                                >{{ __("edit") }}</span
                                            >
                                        </div>
                                    </div>
                                </Link>

                                <button
                                    @click.prevent="destroy(quote)"
                                    class="bg-red-600 border border-red-700 rounded shadow px-3 py-1 m-[1px] text-xs uppercase"
                                >
                                    <div class="flex items-center space-x-2">
                                        <Icon
                                            src="trash"
                                            class="text-white flex-none w-3 h-3"
                                        />

                                        <div class="flex-wrap pr-1">
                                            <span
                                                class="text-white font-semibold"
                                                >{{ __("delete") }}</span
                                            >
                                        </div>
                                    </div>
                                </button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <transition name="fade">
        <ModalPDF
            v-if="showPdf"
            :quote="quote"
            :preview="false"
            :client="quote.customer"
            :company="company"
            @close="showPdf = false"
            ref="modalPDF"
        />
    </transition>
</template>

<script>
import { defineComponent } from "vue";
import { Link } from "@inertiajs/inertia-vue3";
import ModalPDF from "./ModalPDF";
import { Inertia } from "@inertiajs/inertia";
import Swal from "sweetalert2";
import Icon from "@/Components/Icon";
import SpanState from "@/Components/SpanState";
import axios from "axios";

export default defineComponent({
    props: {
        quotes: Array,
        company: Object,
    },

    components: {
        Link,
        Icon,
        ModalPDF,
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
        destroy(quote) {
            return Swal.fire({
                text: __("are you sure want to delete") + "?",
                icon: "question",
                showCancelButton: true,
            }).then((response) => {
                if (response.isConfirmed) {
                    return Inertia.delete(
                        route("quotes.destroy", { id: quote.id })
                    );
                }
            });
        },
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
