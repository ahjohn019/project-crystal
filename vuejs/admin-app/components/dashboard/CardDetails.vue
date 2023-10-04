<template>
    <div class="card-details-container text-white row pb-2 justify-between">
        <div
            v-for="cardDetail in cardDetailsList"
            :key="cardDetail"
            class="col-12 col-md-2 my-2 rounded p-6 row justify-between animate__animated animate__bounce"
            :style="'background-color:' + cardDetail.backgroundColor"
        >
            <div>
                <q-icon name="question_answer" size="32px" />
                <div class="pt-4 text-lg font-bold">{{ cardDetail.label }}</div>
            </div>
            <div class="flex items-center text-5xl">
                {{ cardDetail.totalCount }}
            </div>
        </div>
    </div>
</template>

<script>
import { useCardDetailsAdminStore } from '@shared_admin/dashboard/cardDetails.js';
import { useAdminAuthStore } from '@shared_admin/base/auth.js';
import { onMounted, ref, watchEffect } from 'vue';

export default {
    setup() {
        const cardDetailsStore = useCardDetailsAdminStore();
        const adminAuthStore = useAdminAuthStore();
        const getAuthToken = adminAuthStore.fetchSessionToken();

        const totalCurrentPosts = ref([]);
        const totalUserList = ref([]);
        const totalCommentsList = ref([]);

        const CURRENT_POSTS_INDEX = 0;
        const TOTAL_USERS_INDEX = 1;
        const TODAY_LIKES_INDEX = 2;
        const TOTAL_REVIEWS_INDEX = 3;

        const fetchCurrentPosts = async () => {
            try {
                totalCurrentPosts.value =
                    await cardDetailsStore.fetchCurrentPosts(getAuthToken);
            } catch (error) {
                console.error(error);
            }
        };

        const fetchUserList = async () => {
            try {
                totalUserList.value = await cardDetailsStore.fetchUserList(
                    getAuthToken
                );
            } catch (error) {
                console.error(error);
            }
        };

        const fetchCurrentCommentList = async () => {
            try {
                totalCommentsList.value =
                    await cardDetailsStore.fetchCurrentCommentList(
                        getAuthToken
                    );
            } catch (error) {
                console.error(error);
            }
        };

        onMounted(async () => {
            await Promise.all([
                fetchCurrentPosts(),
                fetchUserList(),
                fetchCurrentCommentList(),
            ]);
        });

        const cardDetailsList = ref([
            {
                label: 'Current Posts',
                backgroundColor: '#55aaf1',
                totalCount: null,
            },
            {
                label: 'Total User',
                backgroundColor: '#f5a851',
                totalCount: null,
            },
            {
                label: 'Today Likes',
                backgroundColor: '#77cfbb',
                totalCount: null,
            },
            {
                label: 'Total Reviews',
                backgroundColor: '#766eda',
                totalCount: null,
            },
        ]);

        watchEffect(() => {
            cardDetailsList.value[CURRENT_POSTS_INDEX].totalCount =
                totalCurrentPosts.value.total || 0;
            cardDetailsList.value[TOTAL_USERS_INDEX].totalCount =
                totalUserList.value.total;
            cardDetailsList.value[TODAY_LIKES_INDEX].totalCount =
                totalCurrentPosts.value.total_likes || 0;
            cardDetailsList.value[TOTAL_REVIEWS_INDEX].totalCount =
                totalCommentsList.value.total_comments || 0;
        });

        return {
            cardDetailsList,
        };
    },
};
</script>

<style>
.animate__animated.animate__bounce {
    --animate-duration: 2s;
}

@media (min-width: 1024px) {
    .card-details-container .col-md-2 {
        width: 23.5% !important;
    }
}
</style>
