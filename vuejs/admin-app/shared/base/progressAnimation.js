import { defineStore } from 'pinia';
import { ref, onMounted } from 'vue';

export const useBaseProgressAnimationStore = defineStore(
    'base_progress_animation_admin',
    {
        state: () => ({}),

        actions: {
            progressAnimation() {
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
                    barPerformanceCheckpointText =
                        "You've Achieved the 50% Milestone";

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
        },
    }
);
