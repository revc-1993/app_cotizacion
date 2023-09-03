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
                        <th class="border border-slate-200 px-3 py-2 uppercase">
                            {{ __("invoiced") }}
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
                            <SpanState
                                v-if="
                                    quote.registration_date &&
                                    quote.quote_validity
                                "
                                :state="quote.state"
                            />
                            <div v-else>-</div>
                        </td>
                        <td
                            class="border border-slate-200 px-3 py-1 uppercase items-center text-center"
                        >
                            <input
                                type="checkbox"
                                v-model="isBilled[i]"
                                disabled
                                class="disabled:text-gray-600"
                            />
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

                                <button
                                    @click.prevent="viewModalQuote(quote.id)"
                                    class="bg-green-600 border border-green-700 rounded shadow px-3 py-1 m-[1px] text-xs uppercase disabled:text-gray-400"
                                    :disabled="quote.state === 'aceptada'"
                                >
                                    <div class="flex items-center space-x-2">
                                        <Icon
                                            src="check"
                                            class="text-white flex-none w-3 h-3"
                                        />

                                        <div class="flex-wrap pr-1">
                                            <span
                                                class="text-white font-semibold"
                                                >{{
                                                    __("mark as billed")
                                                }}</span
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
            @close="showPdf = false"
            ref="modalPDF"
        />
    </transition>
    <transition name="fade">
        <ModalQuote
            v-if="showModalQuote"
            :id="idQuote"
            @close="closeModal"
            ref="modalQuote"
        />
    </transition>
</template>

<script>
import { defineComponent } from "vue";
import { Link } from "@inertiajs/inertia-vue3";
import ModalPDF from "./ModalPDF";
import ModalQuote from "./ModalQuote";
import Icon from "@/Components/Icon";
import SpanState from "@/Components/SpanState";
import axios from "axios";
import Toggle from "@vueform/toggle";

export default defineComponent({
    props: {
        quotes: Array,
    },

    components: {
        Link,
        Icon,
        ModalPDF,
        ModalQuote,
        SpanState,
        Toggle,
    },

    data() {
        return {
            search: new String(),
            showPdf: false,
            showModalQuote: false,
            quote: Object,
            factured: Array,
            idQuote: new Number(),
            isBilled: Array,
        };
    },
    computed: {
        // isBilled: function (state) {
        //     return state == "aceptada";
        // },
    },

    methods: {
        viewPdf(id) {
            axios.get(route("quotes.show", { id: id })).then((response) => {
                this.quote = response.data.quote;
                this.showPdf = true;
            });
        },
        viewModalQuote(id) {
            this.idQuote = id;
            this.showModalQuote = true;
        },
        closeModal() {
            this.showModalQuote = false;
            this.isBilled = this.quotes.map(
                (quote) => quote.state === "aceptada"
            );
        },
        // isBilled(state) {
        //     return state == "aceptada";
        // },
    },
    mounted() {
        this.isBilled = this.quotes.map((quote) => quote.state === "aceptada");
    },
});
</script>

<style src="@vueform/toggle/themes/default.css"></style>
