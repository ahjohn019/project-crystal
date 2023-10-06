import { defineStore } from 'pinia';
import axios from 'axios';
import { useRouter } from 'vue-router';
import Swal from 'sweetalert2';

const prefix = '/api/auth/';

export const useAdminAuthStore = defineStore('auth_admin', {
    state: () => ({
        admin: null,
        config: { headers: { Authorization: '' } },
        router: useRouter(),
    }),

    actions: {
        async fetchProfile(payload) {
            this.config.headers.Authorization = `Bearer ${payload}`;

            try {
                const response = await axios.post(
                    prefix + 'profile',
                    null,
                    this.config
                );

                return response.data.data;
            } catch (error) {
                console.error('Error:', error);
                throw error;
            }
        },

        async handleLogin(payload) {
            try {
                const response = await axios
                    .post(prefix + 'login', payload)
                    .then((response) => {
                        window.sessionStorage.setItem(
                            '_token',
                            response.data.data.token
                        );
                        this.router.push('/');
                    })
                    .catch((error) => {
                        Swal.fire({
                            text: error.response.data.message,
                            icon: 'error',
                        });
                    });

                return response;
            } catch (error) {
                console.error('Error:', error);
                throw error;
            }
        },

        async handleLogout(payload) {
            this.config.headers.Authorization = `Bearer ${payload}`;

            try {
                const response = await axios
                    .post(prefix + 'logout', null, this.config)
                    .then((response) => {
                        Swal.fire({
                            text: response.data.message,
                            icon: 'success',
                        });

                        window.sessionStorage.removeItem('_token');

                        this.router.push('/login');
                    });
                return response;
            } catch (error) {
                console.error('Error:', error);
                throw error;
            }
        },

        fetchSessionToken() {
            const sessionStorage = window.sessionStorage;
            const getAuthToken = sessionStorage.getItem('_token');

            return getAuthToken;
        },
    },
});
