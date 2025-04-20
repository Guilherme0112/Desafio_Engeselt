<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import DeleteUserForm from './Partials/DeleteUserForm.vue';
import UpdatePasswordForm from './Partials/UpdatePasswordForm.vue';
import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm.vue';
import Header from '@/Components/Header.vue';
import "../../../css/Forms.css";

defineProps({
    auth: Object,
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
        
        <Header :auth="auth"/>

        <div>
            <div style="display: flex; justify-content: space-around; width: 100%; flex-wrap: wrap;">
                <div>
                    <UpdateProfileInformationForm
                        :must-verify-email="mustVerifyEmail"
                        :status="status"
                    />
                </div>

                <div>
                    <UpdatePasswordForm />
                </div>

                <div style="width: 100%">
                    <DeleteUserForm  />
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
