<template>
    <div class="container">
        <p>
            <router-link :to="{name: 'tasks'}">Задачи</router-link>
            <router-link :to="{name: 'inprocess'}">В процессе</router-link>
            <router-link :to="{name: 'completed'}">Завершенные</router-link>
        </p>
        <div>
            <router-view></router-view>
        </div>
    </div>
</template>


<script>

export default {

}

</script>