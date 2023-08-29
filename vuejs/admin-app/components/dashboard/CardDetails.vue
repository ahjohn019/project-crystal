<template>
    <div class="card-details-container text-white row py-4 justify-between">
        <div
            class="col-12 col-md-2 my-2 rounded p-6 row justify-between"
            style="background-color: #55aaf1"
        >
            <div>
                <q-icon name="description" size="32px" />
                <div class="pt-4 text-lg font-bold">Recent Blog</div>
            </div>
            <div class="flex items-center text-5xl">5</div>
        </div>
        <div
            class="col-12 col-md-2 my-2 rounded p-6 row justify-between"
            style="background-color: #f5a851"
        >
            <div>
                <q-icon name="person" size="32px" />
                <div class="pt-4 text-lg font-bold">Total User</div>
            </div>
            <div class="flex items-center text-5xl">5</div>
        </div>
        <div
            class="col-12 col-md-2 my-2 rounded p-6 row justify-between"
            style="background-color: #77cfbb"
        >
            <div>
                <q-icon name="thumb_up" size="32px" />
                <div class="pt-4 text-lg font-bold">Total Likes</div>
            </div>
            <div class="flex items-center text-5xl">5</div>
        </div>
        <div
            class="col-12 col-md-2 my-2 rounded p-6 row justify-between"
            style="background-color: #766eda"
        >
            <div>
                <q-icon name="question_answer" size="32px" />
                <div class="pt-4 text-lg font-bold">Total Reviews</div>
            </div>
            <div class="flex items-center text-5xl">5</div>
        </div>
    </div>
</template>

<style>
@media (min-width: 1024px) {
    .card-details-container .col-md-2 {
        width: 23.5% !important;
    }
}
</style>
