<template>
    <DashboardLayout title="Facturas">
        <div class="flex-none w-full">
            <h1
                class="first-letter:capitalize lowercase text-xl text-slate-800 font-semibold"
            >
                {{ __("bills") }}
            </h1>
        </div>

        <DataTable :quotes="quotes" :company="company" />
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
import DashboardLayout from "@/Layouts/DashboardLayout";
import DataTable from "./DataTable";
import Icon from "@/Components/Icon";

export default defineComponent({
    props: {
        quotes: Object,
        company: Object,
        count: Object,
        perPage: Number,
        search: String,
    },

    components: {
        DashboardLayout,
        Link,
        DataTable,
        Icon,
    },
});
</script>
