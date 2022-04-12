<template>
    <div>
        <nav class="navbar top" style="background-color: rgba(61, 57, 108, 1);">
            <div class="container">
                <div >
                    <a class="navbar-brand" style="font-family: 'Irish Grover', cursive; color: white; font-size: 2em">Kanban</a>
                </div>
                <div>
                    <a class="nav-link" aria-current="page" href="#" style="color: white">Выйти</a>
                </div>
            </div>
        </nav>

        <div class="d-flex flex-row">
            <div class="navbar navbar-expand-lg align-items-start" style="background-color: rgba(78, 153, 148, 1); width: 15%; min-height: 100vh;">
                <div class="d-flex row align-items-start">
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

}

</script>