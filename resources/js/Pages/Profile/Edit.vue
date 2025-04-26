<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import DeleteUserForm from './Partials/DeleteUserForm.vue';
import UpdatePasswordForm from './Partials/UpdatePasswordForm.vue';
import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm.vue';
import { Link } from '@inertiajs/vue3';
import Header from '@/Components/Header.vue';
import "../../../css/Forms.css";
import "../../../css/Profile.css";

// Props vindo do inertia
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

// Título da página
document.title = "Meu Perfil";

</script>

<template>

    <AuthenticatedLayout>

        <!-- Header -->
        <Header :auth="auth" />

        <!-- Container principal -->
        <div class="profile-container">

            <!-- Primeira div -->
            <div class="card-grid">

                <!-- Atualizar senha -->
                <div>
                    <UpdatePasswordForm />
                </div>
                <!-- Fim do container de atualizar senha -->

                <!-- Atualizar nome e email -->
                <div>
                    <UpdateProfileInformationForm :must-verify-email="mustVerifyEmail" :status="status" />
                </div>
                <!-- Fim do container de atualizar nome e email -->

                <!-- Informações sobre confeitarias  -->
                <div class="container_profile">

                    <!-- Link para cadastrar nova confeitaria -->
                    <div>
                        <Link href="/confectionery/create" class="primary_button">Cadastrar Confeitaria</Link>
                    </div>

                    <!-- Total de confeitarias -->
                    <h1>Confeitarias</h1>
                    <strong><span>Total de confeitarias:</span></strong>
                    <p>{{ amountConfectioneries }}</p>

                </div>
                <!-- Fim das informações sbre confeitarias -->

                <!-- Container para deletar conta -->
                <div class="container_profile" style="height: fit-content;">

                    <!-- Aviso sobre deletar conta -->
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

                    <!-- Botão para deletar conta -->
                    <DeleteUserForm />

                </div>
                <!-- Fim do container de deletar conta -->

            </div>
            <!-- Fim da primeira div -->

        </div>
        <!-- Fim do container principal -->

    </AuthenticatedLayout>
</template>