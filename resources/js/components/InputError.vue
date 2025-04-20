<script setup>
defineProps({
    message: {
        type: String,
    },
});
</script>

<template>
    <div v-show="message">
        <p class="msg_error">
            {{ message }}
        </p>
    </div>
</template>
