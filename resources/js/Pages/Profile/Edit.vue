<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import DeleteUserForm from './Partials/DeleteUserForm.vue';
import UpdatePasswordForm from './Partials/UpdatePasswordForm.vue';
import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm.vue';
import { Link } from '@inertiajs/vue3';
import Header from '@/Components/Header.vue';
import "../../../css/Forms.css";
import "../../../css/Profile.css";

defineProps({
    auth: Object,
    amountConfectioneries: Number,
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

document.title = "Meu Perfil";

</script>

<template>

    <AuthenticatedLayout>

        <Header :auth="auth" />

        <div class="profile-container">

            <div class="card-grid">

                <div class="container_profile">

                    <div>
                        <Link href="/confectionery/create" class="primary_button">Cadastrar Confeitaria</Link>
                    </div>

                    <h1>Confeitarias</h1>
                    <strong><span>Total de confeitarias:</span></strong>
                    <p>{{ amountConfectioneries }}</p>
                </div>
                <div>
                    <UpdatePasswordForm />
                </div>

                <div class="m-88">
                    <UpdateProfileInformationForm :must-verify-email="mustVerifyEmail" :status="status" />
                </div>
                <div class="container_profile" style="height: 200px;">
                    <h3>⚠ Aviso Importante</h3>
                    <br>
                    <p>
                        Ao clicar em <strong>“Deletar conta”</strong>, você iniciará o processo de exclusão permanente
                        da
                        sua conta.
                        Todos os seus dados, histórico e informações pessoais serão <span class="highlight">removidos
                            definitivamente</span> do sistema.
                    </p>
                    <br>
                    <DeleteUserForm />
                </div>
            </div>
        </div>

    </AuthenticatedLayout>
</template>