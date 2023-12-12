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

                for (const element of Object.keys(iconElements.value)) {
                    const iconElement = getObjectIconElement[element];
                    if (iconElement.length > 0) {
                        iconElement.forEach(item => {
                            item.innerHTML = 'expand_more';
                            item.style.fontSize = '24px';
                        });
                    }
                }                
            },
        });
    },
};
