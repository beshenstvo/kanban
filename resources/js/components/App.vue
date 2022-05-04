<template>
    <div>
        <nav class="navbar top" style="background-color: rgba(61, 57, 108, 1);">
            <div class="d-flex justify-content-between align-items-center" style="width:100%; margin-left: 20px; margin-right: 20px">
                <div>
                    <a class="navbar-brand" style="font-family: 'Irish Grover', cursive; color: white; font-size: 2em">Kanban</a>
                </div>
                <div class="d-flex">
                    <div>
                        <router-link v-if="!token" to='login' class="nav-link " style="color: white">Войти</router-link>
                    </div>
                    <div>
                        <router-link v-if="!token" to='register' class="nav-link" style="color: white">Регистрация</router-link>
                    </div>
                    <div>
                        <a v-if="token" class="nav-link" style="color: white" href="#" @click.prevent="logout">Выйти</a>
                    </div>
                </div>
            </div>
        </nav>

        <div class="d-flex flex-row">
            <div v-if="token" class="d-flex justify-content-center navbar navbar-expand-lg align-items-start" style="background-color: rgba(78, 153, 148, 1); width: 15%; min-height: 100vh;">
                <div class="d-flex flex-column align-items-start">
                    <div style="text-align: center;">
                        <router-link :to="{name: 'tasks'}" class="nav-link  ms-4 me-4 mt-2" style="color: white">Задачи</router-link>
                    </div>
                    <div style="text-align: center;">
                        <router-link :to="{name: 'inprocess'}" class="nav-link ms-4 me-4 mt-2" style="color: white">В процессе</router-link>
                    </div>
                    <div style="text-align: center;">
                        <router-link :to="{name: 'completed'}" class="nav-link ms-4 me-4 mt-2" style="color: white">Завершенные</router-link>
                    </div>
                    <div style="text-align: center;" class="mt-auto">
                        <router-link :to="{name: 'profile'}" class="nav-link ms-4 me-4 mt-2" style="color: white">Профиль</router-link>
                    </div>
                </div>
            </div>

            <div class='p-2' style="width: 100%;">
                <router-view></router-view>
            </div>
        </div>
    </div>
</template>


<script>

export default {
    data() {
        return {
            token: null
        }
    },
    mounted() {
        this.getToken();
    },
    methods: {
        getToken() {
            this.token = localStorage.getItem('x_xsrf_token');
        },
        logout() {
            axios.post('logout')
            .then(response => {
                localStorage.removeItem('x_xsrf_token');
                this.$router.push({ name: 'login'});
                document.location.reload();
            })
            .catch(error => {
                console.log(error);
            })
        }
    }
}

</script>