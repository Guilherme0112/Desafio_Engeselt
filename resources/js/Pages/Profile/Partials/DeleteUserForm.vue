<script setup>
import DangerButton from '@/Components/DangerButton.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import Modal from '@/Components/Modal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { useForm } from '@inertiajs/vue3';
import { nextTick, ref } from 'vue';

const confirmingUserDeletion = ref(false);
const passwordInput = ref(null);

const form = useForm({
    password: '',
});

const confirmUserDeletion = () => {
    confirmingUserDeletion.value = true;

    nextTick(() => passwordInput.value.focus());
};

const deleteUser = () => {
    form.delete(route('profile.destroy'), {
        preserveScroll: true,
        onSuccess: () => closeModal(),
        onError: () => passwordInput.value.focus(),
        onFinish: () => form.reset(),
    });
};

const closeModal = () => {
    confirmingUserDeletion.value = false;

    form.clearErrors();
    form.reset();
};
</script>

<template>
    <section style="width: 100%;">

        <DangerButton @click="confirmUserDeletion">Deletar Conta</DangerButton>

        <Modal :show="confirmingUserDeletion" @close="closeModal">
            <div>
                <h2>
                    Você confirma que deseja deletar a conta?
                </h2>

                <p>
                    Após a exclusão da sua conta, todos os seus recursos e dados
                    serão excluídos permanentemente. Digite sua senha para
                    confirmar que deseja excluir sua conta permanentemente.
                </p>

                <div>
                    <InputLabel for="password" value="Password" />

                    <TextInput id="password" ref="passwordInput" v-model="form.password" type="password"
                        placeholder="Password" @keyup.enter="deleteUser" />

                    <InputError :message="form.errors.password" class="mt-2" />
                </div>

                <div>
                    <SecondaryButton @click="closeModal" class="primary_button">
                        Cancelar
                    </SecondaryButton>

                    <DangerButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing"
                        @click="deleteUser">
                        Deletar Conta
                    </DangerButton>
                </div>
            </div>
        </Modal>
    </section>
</template>
