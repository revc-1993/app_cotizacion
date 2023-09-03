<template>
    <div
        :class="componentClass"
        class="border rounded-full py-1 px-3 font-semibold inline-flex items-center capitalize leading-none"
    >
        {{ state }}
    </div>
</template>

<script>
import { defineComponent } from "vue";

export default defineComponent({
    props: {
        state: String,
    },

    computed: {
        componentClass: function () {
            return {
                denegada: "bg-orange-600 text-white border-orange-800",
                pendiente: "bg-yellow-600 text-white border-yellow-800",
                aceptada: "bg-teal-600 text-white border-teal-800",
            }[this.state];
        },
    },
});
</script>
