import { defineStore } from 'pinia';
import { ref, onMounted } from 'vue';

export const useBaseScrollAnimationStore = defineStore('base_scroll_admin', {
    state: () => ({}),

    actions: {
        scrollAnimation(animateClassList = null) {
            const elements = ref([]);
            const defaultAnimated = 'animate__animated';

            // Define the Intersection Observer options and callback function
            const options = {
                root: null,
                rootMargin: '0px',
                threshold: 0.4,
            };

            const callbacks = (entries) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        animateClassList.forEach((value) => {
                            if (entry.target.classList.contains(value.name)) {
                                entry.target.classList.add(
                                    defaultAnimated,
                                    value.animation
                                );
                            }
                        });
                    }
                });
            };

            // Create the Intersection Observer instance
            const observer = new IntersectionObserver(callbacks, options);

            // Function to observe elements with the 'to-animate' class
            const observeElements = () => {
                const elementsToObserve =
                    document.querySelectorAll('.to-animate');
                elements.value = Array.from(elementsToObserve);

                elementsToObserve.forEach((element) => {
                    observer.observe(element);
                });
            };

            onMounted(() => {
                observeElements();
            });
        },
    },
});
