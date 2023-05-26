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
                            {{ __("name") }}
                        </th>
                        <th class="border border-slate-200 px-3 py-2 uppercase">
                            {{ __("number_of_containers") }}
                        </th>
                        <th class="border border-slate-200 px-3 py-2 uppercase">
                            {{ __("single_cargo_name") }}
                        </th>
                        <th class="border border-slate-200 px-3 py-2 uppercase">
                            {{ __("type_of_transport") }}
                        </th>
                        <th class="border border-slate-200 px-3 py-2 uppercase">
                            {{ __("product") }}
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
                                ? quote.name.includes(search.trim()) ||
                                  quote.product.includes(search.trim())
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
                            {{ __(quote.name) }}
                        </td>
                        <td class="border border-slate-200 px-3 py-1 uppercase">
                            {{ __(quote.number_of_containers) }}
                        </td>
                        <td class="border border-slate-200 px-3 py-1 uppercase">
                            {{ __(quote.single_cargo_name) }}
                        </td>
                        <td class="border border-slate-200 px-3 py-1 uppercase">
                            {{ __(quote.type_of_transport) }}
                        </td>
                        <td class="border border-slate-200 px-3 py-1 uppercase">
                            {{ __(quote.product) }}
                        </td>
                        <td class="border border-inherit px-3 py-1">
                            <div class="flex-wrap">
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

                <!-- <tfoot class="bg-slate-200">
                    <tr>
                        <th class="border border-slate-200 px-3 py-1 uppercase">
                            {{ __("no") }}
                        </th>
                        <th class="border border-slate-200 px-3 py-1 uppercase">
                            {{ __("name") }}
                        </th>
                        <th class="border border-slate-200 px-3 py-1 uppercase">
                            {{ __("number_of_containers") }}
                        </th>
                        <th class="border border-slate-200 px-3 py-1 uppercase">
                            {{ __("single_cargo_name") }}
                        </th>
                        <th class="border border-slate-200 px-3 py-1 uppercase">
                            {{ __("type_of_transport") }}
                        </th>
                        <th class="border border-slate-200 px-3 py-1 uppercase">
                            {{ __("product") }}
                        </th>
                        <th class="border border-slate-200 px-3 py-1 uppercase">
                            {{ __("action") }}
                        </th>
                    </tr>
                </tfoot> -->
            </table>
        </div>
    </div>
</template>

<script>
import { defineComponent } from "vue";
import { Link } from "@inertiajs/inertia-vue3";
import { Inertia } from "@inertiajs/inertia";
import Swal from "sweetalert2";
import Icon from "@/Components/Icon";

export default defineComponent({
    props: {
        quotes: Array,
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
    },
});
</script>
