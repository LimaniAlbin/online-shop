<template>
    <div class="loader-wrapper m-auto my-auto">
        <div class="loader">
            <div></div>
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'Loader'
}
</script>

<style scoped>

.loader-wrapper {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}


.loader div {
    box-sizing: border-box;
    display: block;
    position: absolute;
    width: 64px;
    height: 64px;
    top: 50vh;
    border: 8px solid;
    border-radius: 50%;
    animation: loader 1.2s cubic-bezier(0.5, 0, 0.5, 1) infinite;
    border-color: #1f3bb3 transparent transparent transparent;
}

.loader div:nth-child(1) {
    animation-delay: -0.45s;
}

.loader div:nth-child(2) {
    animation-delay: -0.3s;
}

.loader div:nth-child(3) {
    animation-delay: -0.15s;
}

@keyframes loader {
    0% {
        transform: rotate(0deg);
    }
    100% {
        transform: rotate(360deg);
    }
}


</style>
