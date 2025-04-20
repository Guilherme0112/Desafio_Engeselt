<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import Header from '@/components/Header.vue';

defineProps({
    auth: Object
})
</script>

<template>
    <Head title="Dashboard" />
    
    <Header :auth="auth"/>

    <AuthenticatedLayout>
        

        
    </AuthenticatedLayout>
</template>
