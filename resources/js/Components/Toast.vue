<script setup>
import { computed } from "vue";
import { useToast } from "vue-toastification";

const props = defineProps({
    message: {
        type: [Object, Number, String],
        default: "",
    },
    modelValue: {
        type: [Object, Number, String, Boolean],
        default: "",
    },
});

const colors = {
    1: "success-class",
    3: "warning-class",
    4: "danger-class",
};

const message = computed(() => {
    let message = "";
    if (Object.values(props.message)[0])
        return (message += Object.values(props.message)[0]);
    if (Object.values(props.message)[2])
        return (message += `\n${Object.values(props.message)[2]}`);
    return message + props.message;
});

const toast = useToast();
toast(message.value, {
    position: "top-center",
    timeout: 3500,
    toastClassName: [
        "height-class",
        colors[Object.values(props.message)[1]] || "blue-class",
    ],
    bodyClassName: "custom-class",
    hideProgressBar: true,
});

const emit = defineEmits(["update:modelValue", "setRef"]);

const value = computed({
    get: () => props.modelValue,
    set: (value) => {
        emit("update:modelValue", value);
    },
});

value.value = false;
</script>

<template></template>

<style>
.Vue-Toastification__toast--default.height-class {
    height: max-content;
}
.Vue-Toastification__toast--default.danger-class {
    background-color: rgb(220 38 38);
}
.Vue-Toastification__toast--default.warning-class {
    background-color: rgb(202 138 4);
}
.Vue-Toastification__toast--default.success-class {
    background-color: rgb(5 150 105);
}
.Vue-Toastification__toast--default.blue-class {
    background-color: rgb(37 99 235);
}

.Vue-Toastification__toast-body.custom-class {
    font-size: 0.875rem; /* 14px */
    line-height: 1.25rem; /* 20px */
}
</style>
