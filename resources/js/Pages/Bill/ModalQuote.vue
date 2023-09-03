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
                    {{ __("mark as billed") }}
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
                    <div class="mb-2 last:mb-0 first-letter:capitalize">
                        <label
                            for="invoice_number"
                            class="first-letter:capitalize lowercase text-sm"
                            >{{ __("invoice number") }}</label
                        >

                        <input
                            v-model="form.invoice_number"
                            type="text"
                            name="ruc"
                            class="w-full bg-white text-sm border border-slate-300 rounded-md shadow placeholder:capitalize"
                            :placeholder="__('example of ruc')"
                            autofocus
                            autocomplete="off"
                        />

                        <transition name="fade">
                            <p
                                v-if="form.errors.invoice_number"
                                class="text-xs text-red-500"
                            >
                                {{ form.errors.invoice_number }}
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
                </div>
                <div
                    class="flex items-center justify-end bg-slate-200 px-4 py-2 space-x-2 text-xs"
                >
                    <button
                        type="submit"
                        class="bg-slate-700 text-slate-200 border border-slate-800 rounded-md shadow px-3 py-2 uppercase font-bold"
                    >
                        {{ __("mark as billed") }}
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
import DashboardLayout from "@/Layouts/DashboardLayout";
import Multiselect from "@vueform/multiselect";
import Swal from "sweetalert2";
import Icon from "@/Components/Icon";
import pdfMake from "pdfmake/build/pdfmake";
import pdfFonts from "pdfmake/build/vfs_fonts";
import { useForm, usePage } from "@inertiajs/inertia-vue3";
pdfMake.vfs = pdfFonts.pdfMake.vfs;

export default defineComponent({
    props: {
        id: Number,
    },
    components: {
        DashboardLayout,
        Multiselect,
        Icon,
    },
    data() {
        return {
            form: useForm({
                invoice_number: new String(),
            }),
        };
    },
    mounted() {},
    methods: {
        submit() {
            return Swal.fire({
                text: __("are you sure to mark this quote as invoiced") + "?",
                icon: "question",
                showCancelButton: true,
            }).then((response) => {
                if (response.isConfirmed) {
                    return this.form.patch(
                        route("quotes.markAsBilled", this.id),
                        {
                            onSuccess: () => {
                                this.form.reset();
                                this.$emit("close");
                                const { data } = this.$inertia.visit(
                                    this.$page.url,
                                    { preserveState: true }
                                );
                                usePage().replace(data);
                            },
                            onError: (error) => {
                                console.log(error);
                            },
                        }
                    );
                }
            });
        },
    },
});
</script>

<style src="@vueform/multiselect/themes/default.css"></style>
