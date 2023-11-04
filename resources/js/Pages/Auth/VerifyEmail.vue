<template>
    <Head title="Verificación de correo electrónico" />

    <jet-authentication-card>
        <template #logo>
            <jet-authentication-card-logo :logo="logo" />
        </template>

        <div class="mb-4 text-sm text-gray-600">
            ¡Gracias por registrarse! Antes de comenzar, ¿podría verificar su
            dirección de correo electrónico haciendo clic en el enlace que le
            acabamos de enviar por correo electrónico? Si usted Si no recibiste
            el correo electrónico, con gusto te enviaremos otro.
        </div>

        <div
            class="mb-4 font-medium text-sm text-green-600"
            v-if="verificationLinkSent"
        >
            Se ha enviado un nuevo enlace de verificación a la dirección de
            correo electrónico que registró.
        </div>

        <form @submit.prevent="submit">
            <div class="mt-4 flex items-center justify-between">
                <jet-button
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    Reenviar correo electrónico de verificación
                </jet-button>

                <Link
                    :href="route('logout')"
                    method="post"
                    as="button"
                    class="underline text-sm text-gray-600 hover:text-gray-900"
                    >Log Out</Link
                >
            </div>
        </form>
    </jet-authentication-card>
</template>

<script>
import { defineComponent } from "vue";
import JetAuthenticationCard from "@/Jetstream/AuthenticationCard.vue";
import JetAuthenticationCardLogo from "@/Jetstream/AuthenticationCardLogo.vue";
import JetButton from "@/Jetstream/Button.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";

export default defineComponent({
    components: {
        Head,
        JetAuthenticationCard,
        JetAuthenticationCardLogo,
        JetButton,
        Link,
    },

    props: {
        status: String,
    },

    data() {
        return {
            form: this.$inertia.form(),
            logo: "",
        };
    },

    methods: {
        submit() {
            this.form.post(this.route("verification.send"));
        },
    },

    computed: {
        verificationLinkSent() {
            return this.status === "verification-link-sent";
        },
    },

    mounted() {
        this.logo = this.$page.props.$logo;
    },
});
</script>
