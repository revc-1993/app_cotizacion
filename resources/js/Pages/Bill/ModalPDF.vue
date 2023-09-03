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
                    <iframe
                        ref="pdfIframe"
                        title="PDF preview"
                        width="100%"
                        height="500px"
                    />
                </h1>
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
        preview: {
            type: Boolean,
            default: true,
        },
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
            const docDefinition = {
                content: [
                    { text: "TransAgency S.A.", style: "header" },
                    { text: "RUC: 1234567890001", style: "header" },
                    {
                        text: "Dirección: Calle Principal 123, Ciudad",
                        style: "header",
                    },
                    { text: "Teléfono: (01) 234-5678", style: "header" },
                    { text: "Email: info@tuempresa.com", style: "header" },
                    { text: "Cotización", style: "title" },
                    {
                        text: `Fecha de cotización: ${this.quote.registration_date}`,
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
                        text: `RUC / C.I.: ${
                            this.preview
                                ? this.client.ruc
                                : this.quote.customer.ruc
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
                    { text: "Detalles de la Cotización", style: "subTitle" },
                    {
                        table: {
                            widths: [
                                "auto",
                                "*",
                                "auto",
                                "auto",
                                "auto",
                                "auto",
                                "auto",
                            ],
                            body: [
                                [
                                    "N.",
                                    "Descripción",
                                    "Cantidad",
                                    "PVP Proveedor",
                                    "Utilidad (%)",
                                    "Utilidad (USD)",
                                    "Subtotal (USD)",
                                ],
                                ...(this.preview
                                    ? this.quote.details_service.map(
                                          (detail, i) => [
                                              i + 1,
                                              detail.service,
                                              detail.amount_of_service,
                                              detail.pvp_provider.toFixed(2),
                                              detail.utility,
                                              detail.utility_usd.toFixed(2),
                                              detail.subtotal.toFixed(2),
                                          ]
                                      )
                                    : this.quote.service_details.map(
                                          (detail, i) => [
                                              i + 1,
                                              detail.service,
                                              detail.amount_of_service,
                                              detail.pvp_provider.toFixed(2),
                                              detail.utility,
                                              detail.utility_usd.toFixed(2),
                                              detail.subtotal.toFixed(2),
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
                        text: `Tiempo de tránsito: ${this.quote.transit_time} días`,
                        style: "customerInfo",
                    },
                    {
                        text: `Validez de cotización: ${this.quote.quote_validity} días`,
                        style: "customerInfo",
                    },
                    { text: "", margin: [0, 10] }, // Empty space for separation
                    {
                        text: "Documento generado por www.transagency.net - Página 1/1",
                        style: "footer",
                    },
                ],
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

            // Generar el PDF y mostrarlo en el iframe
            const pdfElement = this.$refs.pdfIframe;
            const pdf = pdfMake.createPdf(docDefinition);
            pdf.getDataUrl((dataUrl) => {
                pdfElement.src = dataUrl;
            });
        },
    },
});
</script>

<style src="@vueform/multiselect/themes/default.css"></style>
