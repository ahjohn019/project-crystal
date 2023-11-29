import { ref } from 'vue';

export default {
    install: (app) => {
        const iconElements = ref({
            sortIconElements: [],
            selectIconElements: [],
        });

        app.mixin({
            mounted() {
                iconElements.value = {
                    ...iconElements.value,
                    sortIconElements: document.querySelectorAll(
                        '.q-table__sort-icon'
                    ),
                    selectIconElements: document.querySelectorAll(
                        '.q-select__dropdown-icon'
                    ),
                };

                const getObjectIconElement = { ...iconElements.value };

                for (const element in iconElements.value) {
                    if (getObjectIconElement[element].length > 0) {
                        getObjectIconElement[element][0].innerHTML =
                            'expand_more';
                        getObjectIconElement[element][0].style.fontSize =
                            '24px';
                    }
                }
            },
        });
    },
};
