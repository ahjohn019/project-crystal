import { ref } from 'vue';

export default {
    install: (app) => {
        const sortIconElements = ref([]);

        app.config.globalProperties.$sortIconElements = sortIconElements;

        app.mixin({
            mounted() {
                sortIconElements.value = document.querySelectorAll(
                    '.q-table__sort-icon'
                );
                sortIconElements.value.forEach((element) => {
                    element.innerHTML = 'expand_more';
                    element.style.fontSize = '24px';
                });
            },
        });
    },
};
