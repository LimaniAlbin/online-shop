<template>
    <div id="app">
        <router-view></router-view>
        <div v-if="message" class="message">{{ message }}</div>
    </div>
</template>

<script setup>
import { ref, watch } from 'vue';

const message = ref('');

watch(message, (newMessage) => {
    if (newMessage) {
        showMessage(newMessage);
    }
});

function showMessage(messageText) {
    // Display the message using your preferred method (e.g., toast, alert, etc.)
    console.log('Message:', messageText);
}
</script>

<style>
.message {
    background-color: #eaeaea;
    padding: 10px;
    margin-top: 10px;
}
</style>

