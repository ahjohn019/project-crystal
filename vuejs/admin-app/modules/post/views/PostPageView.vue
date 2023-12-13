<template>
  <div class="dashboard-container-page m-4 px-4">
      <div class="q-pa-md">
        <div class="q-gutter-y-md">
          <q-card>
            <q-tabs
              v-model="tab"
              dense
              class="bg-grey-2 text-grey-7"
              active-color="primary"
              align="justify"
            >
              <q-tab name="information" label="Information" />
              <q-tab name="category" label="Category" />
              <q-tab name="user" label="User" />
            </q-tabs>
            <q-tab-panels v-model="tab" animated class="bg-white">
              <q-tab-panel name="information">
                <div class="text-h6 py-4">Information</div>
                <div class="row" v-for="(value, key, idx) in payload.info" :key="idx">
                    <div class="col-3 py-2">
                        {{ key.toUpperCase() }}
                    </div>
                    <div class="col-9 py-2" :class="getCustomClass(key, value)">
                        {{ value }}
                    </div>
                </div>
              </q-tab-panel>
              <q-tab-panel name="category">
                <div class="text-h6">Category</div>
                <div class="row" v-for="(value, key, idx) in payload.category" :key="idx">
                    <div class="col-3 py-2">
                        {{ key.toUpperCase() }}
                    </div>
                    <div class="col-9 py-2" :class="getCustomClass(key, value)">
                        {{ value }}
                    </div>
                </div>
              </q-tab-panel>
              <q-tab-panel name="user">
                <div class="text-h6">User</div>
                <div class="row" v-for="(value, key, idx) in payload.user" :key="idx">
                    <div class="col-3 py-2">
                        {{ key.toUpperCase() }}
                    </div>
                    <div class="col-9 py-2" :class="getCustomClass(key, value)">
                        {{ value }}
                    </div>
                </div>
              </q-tab-panel>
            </q-tab-panels>
          </q-card>
        </div>
      </div>
  </div>
</template>

<script>
import { ref, onMounted } from 'vue';
import { usePostTablePageAdminStore } from '@shared_admin/post/postTablePage.js';
import { useAdminAuthStore } from '@shared_admin/base/auth.js';
import { useRoute } from 'vue-router'
import dayjs from 'dayjs';

export default {
  setup () {
    const postTablePageAdminStore = usePostTablePageAdminStore();
    const adminAuthStore = useAdminAuthStore();
    const getAuthToken = adminAuthStore.fetchSessionToken();
    const tab = ref('information');
    const route = useRoute();
    const payload = ref({});

    const postView = async () => {
        const paramId = route.params.id;
        const response = await postTablePageAdminStore.fetchPostView(getAuthToken, paramId);
        const {id, title, content, likes, category, user} = response

        const popularity = response.popularity * 100 + '%';
        const status = response.status === "1" ? "Active" : "Inactive"

        payload.value.info = {
            ...payload.value.info,
            id,
            title,
            content,
            likes,
            popularity,
            status,
            'Created At' : convertCreatedAt(response.created_at)
        };

        payload.value.category = {
            ...payload.value.category,
            id : category.id,
            name: category.name,
            'Created At' : convertCreatedAt(response.category.created_at)
        };

        payload.value.user = {
            ...payload.value.user,
            id : user.id,
            name: user.name,
            email: user.email
        };
    };
    
    const getCustomClass = (key, value) => {
        if(key === 'status'){
            return value === 'Active' ? 'text-green font-bold' : 'text-red font-bold';
        }
    }

    const convertCreatedAt = (createdAt) => {
        return dayjs(createdAt).format('YYYY-MM-DD HH:mm:ss');
    }

    onMounted(() => {
        postView();
    });

    return {
        tab,
        payload,
        getCustomClass,
        convertCreatedAt
    }
  }
}
</script>
