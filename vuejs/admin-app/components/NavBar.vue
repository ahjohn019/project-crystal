<template>
    <q-header elevated class="bg-white text-black py-2">
        <div class="row items-center mx-4 md:mx-10">
            <div class="col col-lg-2 text-sm md:text-2xl lg:text-center ml-4">
                Admin Panel
            </div>
            <div class="col col-lg-8 col-md-5 nav-profile-details">
                <q-input outlined dense label="Label">
                    <template v-slot:append>
                        <q-icon name="search" />
                    </template>
                </q-input>
            </div>
            <div class="col nav-profile-details">
                <div class="row items-center">
                    <div class="col col-md-3 flex justify-end">
                        <q-avatar>
                            <img src="https://cdn.quasar.dev/img/avatar.png" />
                        </q-avatar>
                    </div>
                    <div class="col">
                        <q-btn-dropdown
                            class="text-black"
                            color="white"
                            dropdown-icon="expand_more"
                        >
                            <template v-slot:label>
                                <div class="row items-center no-wrap">
                                    <div class="col text-center">
                                        <div class="font-bold ">
                                            Shoo Bro Thoo
                                        </div>
                                        <div
                                            class="lowercase  text-gray-500"
                                        >
                                            shoobro@email.com
                                        </div>
                                    </div>
                                </div>
                            </template>
                            <q-list>
                                <q-item clickable v-close-popup>
                                    <q-item-section>
                                        <q-item-label>Photos</q-item-label>
                                    </q-item-section>
                                </q-item>
                                <q-item clickable v-close-popup>
                                    <q-item-section>
                                        <q-item-label>Videos</q-item-label>
                                    </q-item-section>
                                </q-item>
                            </q-list>
                        </q-btn-dropdown>
                    </div>
                </div>
            </div>
            <div class="col nav-profile-sidebar">
                <q-toolbar class="justify-end">
                    <q-btn flat @click="drawer = !drawer" round dense icon="menu" />
                </q-toolbar>
            </div>
        </div>
    </q-header>

    <q-drawer
        v-model="drawer"
        :width="200"
        :breakpoint="500"
        overlay
        bordered
        side="right"
        :class="$q.dark.isActive ? 'bg-grey-9' : 'bg-grey-3'"
    >
        <q-scroll-area class="fit">
        <q-list>

            <template v-for="(menuItem, index) in menuList" :key="index">
            <q-item clickable :active="menuItem.label === 'Outbox'" v-ripple>
                <q-item-section avatar>
                <q-icon :name="menuItem.icon" />
                </q-item-section>
                <q-item-section>
                {{ menuItem.label }}
                </q-item-section>
            </q-item>
            <q-separator :key="'sep' + index" v-if="menuItem.separator" />
            </template>

        </q-list>
        </q-scroll-area>
    </q-drawer>
</template>

<script>
import { ref } from 'vue'

const menuList = [
  {
    icon: 'inbox',
    label: 'Inbox',
    separator: true
  },
  {
    icon: 'send',
    label: 'Outbox',
    separator: false
  },
  {
    icon: 'delete',
    label: 'Trash',
    separator: false
  },
  {
    icon: 'error',
    label: 'Spam',
    separator: true
  },
  {
    icon: 'settings',
    label: 'Settings',
    separator: false
  },
  {
    icon: 'feedback',
    label: 'Send Feedback',
    separator: false
  },
  {
    icon: 'help',
    iconColor: 'primary',
    label: 'Help',
    separator: false
  }
]

export default {
  setup () {
    return {
      drawer: ref(false),
      menuList
    }
  }
}
</script>

<style>
.q-btn:before {
    box-shadow: none !important;
}

.q-btn-dropdown__arrow-container {
    font-size: 32px !important;
}

@media (max-width: 768px) {
    .nav-profile-details {
        display: none;
    }

    .nav-profile-sidebar{
        display: block;
    }
}

@media (min-width: 769px) {
    .nav-profile-details {
        display: block;
    }

    .nav-profile-sidebar{
        display: none;
    }
}
</style>
