<template>
    <div>
        <div
            class="col col-12 rounded-tl-lg rounded-tr-lg p-4 font-bold border-b bg-white"
        >
            Blog Progress
        </div>

        <div
            class="col bg-white px-4 rounded-bl-lg md:rounded-bl-none rounded-br-lg"
        >
            <q-expansion-item v-model="expanded">
                <template v-slot:header>
                    <span class="font-bold flex items-center">This Week</span>
                </template>
                <q-linear-progress
                    :value="progress"
                    size="20px"
                    style="border-radius: 24px; color: #5541d7"
                    class="custom-progress"
                />
            </q-expansion-item>

            <div class="col-12 py-4 font-bold">Indicators</div>
            <div class="flex flex-col md:flex-row md:space-x-4">
                <div class="p-3 mb-2 rounded" style="background-color: #f7f7fc">
                    Total Blogs
                    <span
                        class="text-white px-2 py-1 rounded"
                        style="background-color: #5541d7"
                        >10</span
                    >
                </div>
                <div class="p-3 mb-2 rounded" style="background-color: #f7f7fc">
                    Total Likes
                    <span
                        class="text-white px-2 py-1 rounded"
                        style="background-color: #2d96ee"
                        >10</span
                    >
                </div>
                <div class="p-3 mb-2 rounded" style="background-color: #f7f7fc">
                    Total Users
                    <span
                        class="text-white px-2 py-1 rounded"
                        style="background-color: #42bda1"
                        >10</span
                    >
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { ref, onMounted } from 'vue';

export default {
    setup() {
        const progress = ref(0);
        const expanded = ref(true);

        // Start the progress animation
        const animateProgress = () => {
            const targetProgress = 0.8;
            const animationDuration = 1000;
            const interval = 10;

            const steps = animationDuration / interval;
            const increment = targetProgress / steps;

            let currentProgress = 0;
            const progressInterval = setInterval(() => {
                currentProgress += increment;
                progress.value = currentProgress;

                if (currentProgress >= targetProgress) {
                    clearInterval(progressInterval);
                }
            }, interval);
        };

        onMounted(() => {
            animateProgress();
        });

        return {
            progress,
            expanded,
        };
    },
};
</script>

<style>
.custom-progress {
    /* Apply the transition effect */
    transition:
        width 0.3s ease-in-out,
        opacity 0.3s ease-in-out;
}

.q-expansion-item .q-expansion-item__container .q-item {
    padding: 0;
}
</style>
