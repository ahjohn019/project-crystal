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
            <q-expansion-item v-model="expanded" class="relative">
                <template v-slot:header>
                    <span class="font-bold flex items-center">This Week</span>
                </template>
                <q-linear-progress
                    :value="progress"
                    size="20px"
                    style="border-radius: 24px; color: #5541d7"
                    class="custom-progress"
                />
                <div
                    class="bar-performace-fade-in-icons"
                    :class="barPerformanceClass"
                >
                    <div class="flex justify-center items-center h-10">
                        <div
                            class="absolute bottom-10 flex justify-center font-bold"
                            style="width: 350px; color: #5541d7"
                        >
                            {{ barPerformanceCheckpointText }}
                        </div>
                        <q-icon
                            :name="barPerformanceIcons"
                            size="32px"
                        ></q-icon>
                        <div
                            class="bar-performance-pulse-effect"
                            :class="barPerformanceColorEffect"
                        ></div>
                    </div>
                </div>
                <div
                    class="bar-performace-fade-in-icons"
                    :class="barPerformanceClassTwo"
                >
                    <div class="flex justify-center items-center h-10">
                        <div
                            class="absolute bottom-10 flex justify-center font-bold"
                            style="width: 350px; color: #5541d7"
                        >
                            100%
                        </div>
                        <q-icon
                            :name="barPerformanceIcons"
                            size="32px"
                        ></q-icon>
                        <div
                            class="bar-performance-pulse-effect"
                            :class="barPerformanceColorEffect"
                        ></div>
                    </div>
                </div>
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
        let barPerformanceClass = 'bar-checkpoint-one-invalid';
        let barPerformanceIcons = 'close';
        let barPerformanceColorEffect = 'bar-performance-red-effect';
        let barPerformanceCheckpointText = '';
        let barPerformanceClassTwo = 'hidden';
        const targetProgress = 1;

        // Start the progress animation
        const animateProgress = () => {
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

        if (targetProgress >= 0.5) {
            barPerformanceClass = 'bar-checkpoint-one';
            barPerformanceIcons = 'check';
            barPerformanceColorEffect = 'bar-performance-green-effect';
            barPerformanceCheckpointText = "You've Achieved the 50% Milestone";

            if (targetProgress === 1) {
                barPerformanceClassTwo = 'bar-checkpoint-two';
            }
        }

        onMounted(() => {
            animateProgress();
        });

        return {
            progress,
            expanded,
            barPerformanceClass,
            barPerformanceIcons,
            barPerformanceColorEffect,
            barPerformanceCheckpointText,
            barPerformanceClassTwo,
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

.bar-checkpoint-one,
.bar-checkpoint-one-invalid,
.bar-checkpoint-two {
    display: none;
}

@media (min-width: 768px) {
    .bar-checkpoint-one,
    .bar-checkpoint-one-invalid,
    .bar-checkpoint-two {
        width: 40px;
        height: 40px;
        border-radius: 24px;
        position: absolute;
        bottom: -50%;
        color: white;
        display: block;
    }

    .bar-checkpoint-one,
    .bar-checkpoint-one-invalid {
        left: 49.5%;
    }

    .bar-checkpoint-two {
        left: 97.5%;
    }

    .bar-checkpoint-one,
    .bar-checkpoint-two,
    .bar-performance-green-effect {
        background: #26a69a;
    }

    .bar-checkpoint-one-invalid,
    .bar-performance-red-effect {
        background: red;
    }

    .bar-performace-fade-in-icons {
        animation: fadeIn 1.5s;
        opacity: 1;
    }

    .bar-performance-pulse-effect {
        border-radius: 50%;
        width: 100px;
        height: 100px;
        position: absolute;
        opacity: 1;
        animation: scaleIn 1.25s infinite cubic-bezier(0.36, 0.11, 0.89, 0.32);
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
        }
    }

    @keyframes scaleIn {
        from {
            transform: scale(0.5, 0.5);
            opacity: 0.5;
        }
        to {
            transform: scale(1, 1);
            opacity: 0;
        }
    }
}
</style>
