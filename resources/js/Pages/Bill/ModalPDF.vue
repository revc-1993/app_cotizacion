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
                    {{ __("preview") }}
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
            <div class="w-full bg-white">
                <h1>
                    <!-- <b>EJEMPLO:</b>
                    {{ quote.cargo_type }} -->
                    <!-- <img :src="company.logoUrl" alt="Logo" /> -->
                    <iframe
                        ref="pdfIframe"
                        title="PDF preview"
                        width="100%"
                        height="500px"
                    />
                </h1>
            </div>
            <!-- Botón "ENVIAR" -->
            <div class="flex items-center justify-end bg-slate-200 p-2">
                <button
                    v-if="preview"
                    @click="executeSubmit"
                    class="px-3 py-1 bg-slate-800 text-slate-100 text-sm border border-slate-700 rounded-md shadow-md uppercase"
                >
                    {{ __("save and send") }}
                </button>
            </div>
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
import Icon from "@/Components/Icon";
import pdfMake from "pdfmake/build/pdfmake";
import pdfFonts from "pdfmake/build/vfs_fonts";
pdfMake.vfs = pdfFonts.pdfMake.vfs;

export default defineComponent({
    props: {
        quote: Object,
        client: Object,
        company: Object,
        preview: {
            type: Boolean,
            default: true,
        },
        company: Object,
    },
    components: {
        DashboardLayout,
        Multiselect,
        Icon,
    },
    mounted() {
        this.generatePDF();
    },
    methods: {
        generatePDF() {
            // Crear el contenido del PDF
            const docDefinition = this.getContent;

            // pdfMake.addImage(this.company.logoUrl, 10, 10);

            // Generar el PDF y mostrarlo en el iframe
            const pdf = pdfMake.createPdf(docDefinition);
            const pdfElement = this.$refs.pdfIframe;
            pdf.getDataUrl((dataUrl) => {
                pdfElement.src = dataUrl;
            });
        },
        transitTime: function (registration_date, transit_time) {
            if (registration_date && transit_time) {
                const start = new Date(registration_date);
                const end = new Date(transit_time);
                const timeDiff = Math.abs(end - start);
                const days = Math.ceil(timeDiff / (1000 * 60 * 60 * 24));
                return days;
            }
            return 0;
        },
        quoteValidity: function (registration_date, quote_validity) {
            if (registration_date && quote_validity) {
                const start = new Date(registration_date);
                const end = new Date(quote_validity);
                const timeDiff = Math.abs(end - start);
                const days = Math.ceil(timeDiff / (1000 * 60 * 60 * 24));
                return days;
            }
            return 0;
        },
        executeSubmit: function () {
            this.$emit("submit");
        },
    },
    computed: {
        getContent: function () {
            return {
                content: [
                    {
                        image: "logoImage",
                        width: 50,
                        height: 50,
                        alignment: "right",
                    },
                    {
                        text: `${this.company?.company_name ?? ""}`,
                        style: "header",
                    },
                    {
                        text: `RUC: ${this.company?.ruc ?? ""}`,
                        style: "header",
                    },
                    {
                        text: `Dirección: ${this.company?.address ?? ""}`,
                        style: "header",
                    },
                    {
                        text: `Teléfono: ${this.company?.contact_number ?? ""}`,
                        style: "header",
                    },
                    {
                        text: `Email: ${this.company?.email ?? ""}`,
                        style: "header",
                    },
                    {
                        text: `Categoría regimen: ${
                            this.company?.regime_category ?? ""
                        }`,
                        style: "header",
                    },
                    { text: "Cotización", style: "title" },
                    {
                        text: `Fecha de cotización: ${this.quote.registration_date}`,
                        style: "customerInfo",
                    },
                    {
                        text: `RUC / C.I.: ${
                            this.preview
                                ? this.client.ruc
                                : this.quote.customer.ruc
                        }`,
                        style: "customerInfo",
                    },
                    {
                        text: `Cliente: ${
                            this.preview
                                ? this.client.name
                                : this.quote.customer.name +
                                  " " +
                                  this.quote.customer.last_name
                        }`,
                        style: "customerInfo",
                    },
                    {
                        text: `Dirección: ${
                            this.preview
                                ? this.client.address
                                : this.quote.customer.address
                        }`,
                        style: "customerInfo",
                    },
                    { text: "", margin: [0, 10] }, // Empty space for separation
                    { text: "Detalle de carga", style: "subTitle" },
                    {
                        table: {
                            widths: [
                                "auto",
                                "auto",
                                "auto",
                                "auto",
                                "auto",
                                "auto",
                            ],
                            body: [
                                [
                                    "N.",
                                    "Cantidad",
                                    "Tipo de carga",
                                    "Nombre de Producto",
                                    "Peso (ton)",
                                    "Volumen (m3)",
                                ],
                                ...(this.preview
                                    ? this.quote.details_charge.map(
                                          (detail, i) => [
                                              i + 1,
                                              {
                                                  text: detail.amount_of_charge,
                                                  alignment: "center",
                                              },
                                              this.quote.cargo_type,
                                              detail.cargo_name,
                                              {
                                                  text:
                                                      detail.weight_calculated ??
                                                      "",
                                                  alignment: "center",
                                              },
                                              {
                                                  text: detail.volumen ?? "",
                                                  alignment: "center",
                                              },
                                          ]
                                      )
                                    : this.quote.product_details.map(
                                          (detail, i) => [
                                              i + 1,
                                              {
                                                  text: detail.amount_of_charge,
                                                  alignment: "center",
                                              },
                                              this.quote.cargo_type,
                                              detail.cargo_name,
                                              {
                                                  text: detail.weight_calculated,
                                                  alignment: "center",
                                              },
                                              {
                                                  text: detail.volumen,
                                                  alignment: "center",
                                              },
                                          ]
                                      )),
                            ],
                        },
                        layout: "lightHorizontalLines",
                    },
                    { text: "", margin: [0, 10] }, // Empty space for separation
                    { text: "Detalles de la Cotización", style: "subTitle" },
                    {
                        table: {
                            widths: ["auto", "auto", "*", "auto"],
                            body: [
                                [
                                    "N.",
                                    "Cantidad",
                                    "Descripción",
                                    "Subtotal (USD)",
                                ],
                                ...(this.preview
                                    ? this.quote.details_service.map(
                                          (detail, i) => [
                                              i + 1,
                                              {
                                                  text: detail.amount_of_service,
                                                  alignment: "right",
                                              },
                                              detail.service,
                                              {
                                                  text: `$${detail.subtotal.toFixed(
                                                      2
                                                  )}`,
                                                  alignment: "right",
                                              },
                                          ]
                                      )
                                    : this.quote.service_details.map(
                                          (detail, i) => [
                                              i + 1,
                                              {
                                                  text: detail.amount_of_service,
                                                  alignment: "right",
                                              },
                                              detail.service,
                                              {
                                                  text: `$${detail.subtotal.toFixed(
                                                      2
                                                  )}`,
                                                  alignment: "right",
                                              },
                                          ]
                                      )),
                            ],
                        },
                        layout: "lightHorizontalLines",
                    },
                    { text: "", margin: [0, 10] }, // Empty space for separation
                    {
                        table: {
                            widths: ["*", "auto"],
                            body: [
                                [
                                    "Subtotal 0%",
                                    {
                                        text: `$${this.quote.subtotal_0.toFixed(
                                            2
                                        )}`,
                                        alignment: "right",
                                    },
                                ],
                                [
                                    "Subtotal 12%",
                                    {
                                        text: `$${this.quote.subtotal_12.toFixed(
                                            2
                                        )}`,
                                        alignment: "right",
                                    },
                                ],
                                [
                                    "IVA (12%)",
                                    {
                                        text: `$${this.quote.iva.toFixed(2)}`,
                                        alignment: "right",
                                    },
                                ],
                                [
                                    "Total",
                                    {
                                        text: `$${this.quote.total.toFixed(2)}`,
                                        alignment: "right",
                                    },
                                ],
                            ],
                        },
                        layout: "noBorders",
                    },
                    { text: "", margin: [0, 10] }, // Empty space for separation
                    { text: "Información adicional:", style: "subTitle" },
                    {
                        text: `Flete internacional: ${this.quote.international_freight_information}`,
                        style: "customerInfo",
                    },
                    {
                        text: `Más detalles: ${this.quote.additional_information}`,
                        style: "customerInfo",
                    },
                    {
                        text: `Tiempo de tránsito: ${this.transitTime(
                            this.quote.registration_date,
                            this.quote.transit_time
                        )} días`,
                        style: "customerInfo",
                    },
                    {
                        text: `Validez de cotización: ${this.quoteValidity(
                            this.quote.registration_date,
                            this.quote.quote_validity
                        )} días`,
                        style: "customerInfo",
                    },
                    {
                        text: `Usuario: ${
                            this.preview
                                ? this.quote.user
                                : this.quote.user?.name
                        }`,
                        style: "customerInfo",
                    },
                    { text: "", margin: [0, 10] }, // Empty space for separation
                    {
                        text: `${this.quote.comments}`,
                        style: "footer",
                    },
                ],
                images: {
                    logoImage: {
                        url: this.company.logoUrl,
                    },
                },
                styles: {
                    header: { bold: true, fontSize: 11, margin: [0, 2] },
                    title: {
                        bold: true,
                        fontSize: 12,
                        alignment: "center",
                        margin: [0, 10],
                    },
                    subTitle: { bold: true, fontSize: 10, margin: [0, 5] },
                    customerInfo: { fontSize: 8, margin: [0, 2] },
                    footer: {
                        fontSize: 6,
                        alignment: "center",
                        margin: [0, 5],
                    },
                },
            };
        },
    },
});
</script>

<style src="@vueform/multiselect/themes/default.css"></style>
