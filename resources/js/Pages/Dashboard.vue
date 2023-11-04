<template>
    <DashboardLayout title="Dashboard">
        <div class="centered-image">
            <img
                v-if="company && company.logoUrl"
                :src="company.logoUrl"
                alt="Logo"
            />
        </div>
    </DashboardLayout>
</template>

<script>
import { defineComponent } from "vue";
import DashboardLayout from "@/Layouts/DashboardLayout.vue";

export default defineComponent({
    components: {
        DashboardLayout,
    },
    props: {
        company: Object,
    },
});
</script>

<style>
.centered-image {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100%;
}
</style>
