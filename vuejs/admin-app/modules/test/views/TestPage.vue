<template>
    <div>
        <div class="bg-red h-screen to-animate test-first">
            asdasdasdasdasasd
        </div>
        <div class="bg-green h-screen to-animate test-two">asdasdasd</div>
    </div>
</template>

<script setup>
import { useBaseScrollAnimationStore } from '@shared_admin/base/scrollAnimation.js';

const baseScrollAnimationStore = useBaseScrollAnimationStore();
const animateClassList = [
    { name: 'test-first', animation: 'animate__fadeInRight' },
    { name: 'test-two', animation: 'animate__fadeInLeft' },
];

baseScrollAnimationStore.scrollAnimation(animateClassList);
</script>
