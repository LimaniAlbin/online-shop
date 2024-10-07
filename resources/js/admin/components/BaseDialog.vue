<template>
    <teleport to="body">
        <div class="backdrop"></div>
        <transition name="dialog">
            <dialog open class="dialog-container">
                <header>
                    <slot name="header">
                        <h4 class="card-title text-primary text-center mt-5 fs-4">{{ title }}</h4>
                    </slot>
                </header>
                <div class="dialog-content">

                    <form class="form-border" @submit.prevent="handleSubmit" enctype="multipart/form-data">
                        <section>
                            <slot></slot>
                        </section>
                        <menu class="d-flex justify-content-center">
                            <slot name="actions">
                                <button type="submit" class="btn btn-primary me-2" :disabled="approveSubmit"
                                        @click="$emit('handle-submit');">Submit
                                </button>
                                <button @click="close" class="btn btn-danger">Cancel</button>
                            </slot>
                        </menu>
                    </form>
                </div>
            </dialog>
        </transition>
    </teleport>
</template>

<script>
export default {
    props: {
        title: {
            type: String,
            required: false,
        },
        actionDescription: {
            type: String,
            required: false,
        },
        approveSubmit: {
            type: Boolean,
            default: false
        }
    },
    emits: ['close','handle-submit'],
    methods: {
        close() {
            this.$emit('close');
        },
        handleSubmit() {
            this.$emit('handle-submit')
        }
    },
};
</script>

<style scoped>

.backdrop {
    position: fixed;
    top: 0;
    left: 0;
    height: 100%;
    width: 100%;
    background-color: rgba(0, 0, 0, 0.75);
    z-index: 10000;
}
body {
    overflow: hidden!important;;
}
dialog {
    position: fixed;
    top: 3vh;
    left: 10%;
    width: 80%;
    z-index: 100000;
    border-radius: 12px;
    border: none;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.30);
    padding: 0;
    margin: 0;
    overflow: hidden;
    background-color: white;
}

.dialog-container {
    position: fixed;
    top: 3vh;
    left: 10%;
    width: 40%;
    z-index: 100000;
    border-radius: 12px;
    border: none;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.30);
    padding: 0;
    margin: 0 auto;
    overflow: hidden;
    background-color: white;
    max-height: 90vh;
    display: flex;
    flex-direction: column;
}

.dialog-content {
    flex-grow: 1;
    overflow-y: auto;
    padding: 1rem;
}
header {
    width: 100%;
    padding: 1rem;
}

header h2 {
    margin: 0;
}

header p {
    padding: 15px 0 0 0;
}

section {
    padding: 1rem;
}

menu {
    padding: 1rem;
    display: flex;
    justify-content: flex-end;
    margin: 0;
}

.dialog-enter-from,
.dialog-leave-to {
    opacity: 0;
    transform: scale(0.8);
}

.dialog-enter-active {
    transition: all 0.3s ease-out;
}

.dialog-leave-active {
    transition: all 0.3s ease-in;
}

.dialog-enter-to,
.dialog-leave-from {
    opacity: 1;
    transform: scale(1);
}

@media (min-width: 768px) {
    dialog {
        left: calc(50% - 20rem);
        width: 40rem;
    }
}
</style>
