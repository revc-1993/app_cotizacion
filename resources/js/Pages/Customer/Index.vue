<template>
    <DashboardLayout title="Clientes">
        <h1>Clientes</h1>
        <Toast
            v-if="$page.props.jetstream.flash.token"
            :message="$page.props.flash.message"
        />
        <DataTable :customers="customers" />
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
import { Link } from "@inertiajs/inertia-vue3";
import { Inertia } from "@inertiajs/inertia";
import DashboardLayout from "@/Layouts/DashboardLayout";
import DataTable from "./DataTable";
// import Card from "./Card";
import Icon from "@/Components/Icon";
import axios from "axios";
import Toast from "@/Components/Toast.vue";

export default defineComponent({
    props: {
        customers: Object,
        count: Object,
        perPage: Number,
        search: String,
    },

    components: {
        DashboardLayout,
        Link,
        DataTable,
        // Card,
        Icon,
        Toast,
    },

    data() {
        return {
            modal: {
                show: false,
                type: new String(),
            },
        };
    },
});
</script>
