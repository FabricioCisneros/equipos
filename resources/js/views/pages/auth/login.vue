<template>
    <form @submit.prevent="submit">
        <div class="mb-4 relative rounded-md shadow-sm">
            <label class="block text-sm font-medium leading-5 text-gray-700" for="email">{{ $t('Nombre de usuario') }}</label>
            <input
                id="username"
                v-model="user.username"
                :placeholder="$t('Nombre de usuario')"
                class="form-input block w-full mt-1 sm:text-sm sm:leading-5"
                required
                type="text"
            />
        </div>
        <div class="mb-4 relative rounded-md shadow-sm">
            <label class="block text-sm font-medium leading-5 text-gray-700" for="password">Contraseña</label>
            <input
                id="password"
                v-model="user.password"
                class="form-input block w-full mt-1 sm:text-sm sm:leading-5"
                placeholder="******************"
                required
                type="password"
            />
        </div>
        <div class="mb-4 text-right">
            <button id="submit-login" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-8 rounded focus:outline-none focus:shadow-outline" data-style="zoom-in" type="submit">
                {{ $t('Sign In') }}
            </button>
        </div>

    </form>
</template>

<script>
import Cookies from 'js-cookie';

export default {
    name: "login",
    metaInfo() {
        return {
            title: this.$i18n.t('Inicio de sesion')
        }
    },
    data() {
        return {
            user: {
                username:null,
                password: null,
                captcha: null
            }
        }
    },
    methods: {
        submit() {
            const self = this;
            if (self.$store.state.settings.recaptcha_enabled) {
                self.$recaptcha('login').then(function (token) {
                    self.user.captcha = token;
                    self.login();
                });
            } else {
                self.login();
            }
        },
        login() {
            const self = this;
            const ladda = Ladda.create(document.querySelector('#submit-login'));
            ladda.start();
            axios.post('api/auth/login', this.user).then(function (response) {
                self.$store.commit('login', response.data);
                const intendedUrl = Cookies.get('intended_url')
                if (intendedUrl) {
                    Cookies.remove('intended_url')
                    self.$router.push(intendedUrl);
                } else {
                    if (response.data.user.role.dashboard_access) {
                        self.$router.push('/dashboard/equipos');
                    } else {
                        self.$router.push('/dashboard/equipos');
                    }
                }
            }).catch(function () {
                self.user.password = null;
            });
        }
    }
}
</script>
