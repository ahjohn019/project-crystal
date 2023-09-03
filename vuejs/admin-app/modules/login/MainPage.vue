<template>
    <div
        class="grid place-items-center h-screen"
        style="background-color: #f7f7fc"
    >
        <div class="row mx-auto admin-login-page px-6">
            <div
                class="col-12 text-center text-uppercase text-3xl"
                style="height: 5.25rem"
            >
                admin panel
            </div>
            <div class="col-12 my-4">
                <q-input outlined dense v-model="text" label="Login">
                    <template v-slot:prepend>
                        <q-icon name="person" />
                    </template>
                </q-input>
            </div>
            <div class="col-12 my-4">
                <q-input outlined dense v-model="text" label="Password">
                    <template v-slot:prepend>
                        <q-icon name="lock" />
                    </template>
                </q-input>
            </div>
            <div class="col-12 my-4">
                <q-btn
                    label="login"
                    class="text-white"
                    rounded
                    style="width: 100%; background-color: #5541d7"
                />
            </div>
            <div class="col-12 my-4 flex items-center justify-between">
                <div class="admin-login-checkbox">
                    <q-checkbox v-model="val" label="Remember Me" />
                </div>
                <div>
                    <a href="#" target="_blank">Forgot Password?</a>
                </div>
            </div>
        </div>

        <div class="ocean">
            <div class="wave"></div>
            <div class="wave"></div>
            <div class="wave"></div>
        </div>
    </div>
</template>

<script>
import { ref } from 'vue';

export default {
    setup() {
        return {
            val: ref(true),
        };
    },
};
</script>

<style>
.admin-login-page {
    max-width: 640px;
}

.admin-login-checkbox .q-checkbox .q-checkbox__inner--truthy {
    color: #5541d7;
}

/* waves */
.ocean {
    height: 80px;
    width: 100%;
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    overflow-x: hidden;
}

.wave {
    background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 800 88.7'%3E%3Cpath d='M800 56.9c-155.5 0-204.9-50-405.5-49.9-200 0-250 49.9-394.5 49.9v31.8h800v-.2-31.6z' fill='%23003F7C'/%3E%3C/svg%3E");
    position: absolute;
    width: 200%;
    height: 100%;
    animation: wave 10s -3s linear infinite;
    transform: translate3d(0, 0, 0);
    opacity: 0.8;
}

.wave:nth-of-type(2) {
    bottom: 0;
    animation: wave 18s linear reverse infinite;
    opacity: 0.5;
}

.wave:nth-of-type(3) {
    bottom: 0;
    animation: wave 20s -1s linear infinite;
    opacity: 0.5;
}

@keyframes wave {
    0% {
        transform: translateX(0);
    }
    50% {
        transform: translateX(-25%);
    }
    100% {
        transform: translateX(-50%);
    }
}
</style>
