<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Header from '@/Components/Header.vue';
import { Link } from '@inertiajs/vue3';
import "../../css/Dashboard.css";

defineProps({
    auth: Object
})

document.title = "Dashboard";

</script>

<template>
    
    <Header :auth="auth"/>

    <AuthenticatedLayout>
        
        <section>

            <!-- Container sobre confeitarias -->
            <div class="container_dashboard">

                <div>
                    <Link href="/confectionery/create" class="primary_button">Cadastrar Confeitaria</Link>
                </div>

                <h1>Confeitarias</h1>
                <strong><span>Total de confeitarias:</span></strong>
                <p>0</p>
            </div>

        </section>
        
    </AuthenticatedLayout>
</template>
