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
            <q-expansion-item
                v-model="progressAnimation.expanded.value"
                class="relative"
            >
                <template v-slot:header>
                    <span class="font-bold flex items-center">This Week</span>
                </template>
                <q-linear-progress
                    :value="progressAnimation.progress.value"
                    size="12px"
                    color="primary"
                    class="custom-progress q-table-custom-progress-bar"
                />
                <div
                    class="bar-performace-fade-in-icons"
                    :class="progressAnimation.barPerformanceClass"
                >
                    <div class="flex justify-center items-center h-10">
                        <div
                            class="absolute bottom-10 flex justify-center font-bold text-primary"
                            style="width: 350px"
                        >
                            {{ progressAnimation.barPerformanceCheckpointText }}
                        </div>
                        <q-icon
                            :name="progressAnimation.barPerformanceIcons"
                            size="32px"
                        ></q-icon>
                        <div
                            class="bar-performance-pulse-effect"
                            :class="progressAnimation.barPerformanceColorEffect"
                        ></div>
                    </div>
                </div>
                <div
                    class="bar-performace-fade-in-icons"
                    :class="progressAnimation.barPerformanceClassTwo"
                >
                    <div class="flex justify-center items-center h-10">
                        <div
                            class="absolute bottom-10 flex justify-center font-bold text-primary"
                            style="width: 350px"
                        >
                            100%
                        </div>
                        <q-icon
                            :name="progressAnimation.barPerformanceIcons"
                            size="32px"
                        ></q-icon>
                        <div
                            class="bar-performance-pulse-effect"
                            :class="progressAnimation.barPerformanceColorEffect"
                        ></div>
                    </div>
                </div>
            </q-expansion-item>

            <div class="col-12 py-4 font-bold">Indicators</div>
            <div class="flex flex-col md:flex-row md:space-x-4">
                <div class="p-3 mb-2 rounded indicator-details">
                    Total Blogs
                    <span class="text-white px-2 py-1 rounded bg-primary">{{
                        totalPostInit.counts
                    }}</span>
                </div>
                <div class="p-3 mb-2 rounded indicator-details">
                    Total Likes
                    <span
                        class="text-white px-2 py-1 rounded total-likes-indicators"
                        >{{ totalLikesInit }}</span
                    >
                </div>
                <div class="p-3 mb-2 rounded indicator-details">
                    Total Users
                    <span
                        class="text-white px-2 py-1 rounded total-users-indicators"
                        >{{ totalUserInit.total }}</span
                    >
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { ref, onMounted } from 'vue';
import { useBarChartsPerformanceAdminStore } from '@shared_admin/dashboard/barChartPerformance.js';
import { useAdminAuthStore } from '@shared_admin/base/auth.js';
import { useBaseProgressAnimationStore } from '@shared_admin/base/progressAnimation.js';
import { useCardDetailsAdminStore } from '@shared_admin/dashboard/cardDetails.js';

export default {
    setup() {
        const progressAnimationStore = useBaseProgressAnimationStore();
        const adminAuthStore = useAdminAuthStore();
        const cardDetailsStore = useCardDetailsAdminStore();
        const getAuthToken = adminAuthStore.fetchSessionToken();
        const barChartsPerformanceAdminStore =
            useBarChartsPerformanceAdminStore();
        const progressAnimation = progressAnimationStore.progressAnimation();

        const totalPostInit = ref([]);
        const totalLikesInit = ref([]);
        const totalUserInit = ref([]);

        const fetchAllPost = async () => {
            try {
                totalPostInit.value =
                    await barChartsPerformanceAdminStore.fetchAllPost(
                        getAuthToken
                    );

                const getAllLikes = totalPostInit.value.posts.map(
                    function (value) {
                        return parseInt(value.likes);
                    }
                );

                const totalAllLikes = getAllLikes.reduce(
                    (accumulator, currentValue) => accumulator + currentValue,
                    0
                );

                totalLikesInit.value = totalAllLikes;
            } catch (error) {
                console.error(error);
            }
        };

        const fetchUserList = async () => {
            try {
                totalUserInit.value = await cardDetailsStore.fetchUserList(
                    getAuthToken
                );
            } catch (error) {
                console.error(error);
            }
        };

        onMounted(() => {
            fetchAllPost();
            fetchUserList();
        });

        return {
            progressAnimation,
            totalPostInit,
            totalLikesInit,
            totalUserInit,
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

.indicator-details {
    background-color: var(--background);
}

.total-likes-indicators {
    background-color: var(--indicator-primary);
}

.total-users-indicators {
    background-color: var(--indicator-secondary);
}

@media (min-width: 768px) {
    .bar-checkpoint-one,
    .bar-checkpoint-one-invalid,
    .bar-checkpoint-two {
        width: 40px;
        height: 40px;
        border-radius: 24px;
        position: absolute;
        bottom: -0.75rem;
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
        background: var(--bar-primary);
    }

    .bar-checkpoint-one-invalid,
    .bar-performance-red-effect {
        background: var(--bar-warning);
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
