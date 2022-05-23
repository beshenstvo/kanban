<template>
    <div class="container">
        <div class='container d-flex flex-wrap justify-content-center'>
            <div class="card m-4" style='width: 70%'>
                <div class="card-header" style='background-color: rgba(61, 57, 108, 0.2)'>
                    <strong>Профиль</strong>
                </div>

                <div class="alert alert-danger" role="alert" v-if="errored">
                    Ошибка сохранения данных!
                </div>

                <div class="card-body" style='background-color: rgba(78, 153, 149, 0.07);'>
                    <div style='width: 40%; margin-right: auto; margin-left: auto;'>
                        <div>
                            <label for="name" class="form-label">Имя</label>
                            <div class="input-group mb-3">
                                <input id="name" type="text" class="form-control" v-model="name" disabled>
                            </div>
                            <label for="email" class="form-label">Email</label>
                            <div class="input-group mb-3">
                                <input id="email" type="email" class="form-control" v-model="email" disabled>
                            </div>
                        </div>
                    </div>
                </div>
               
            </div>
        </div>
    </div>
</template>


<script>

import { $userId } from '../app';
export default {
//получение текущего пользователя
    name: 'Profile',
    data() {
        return {
            name: '', 
            email: '',
            user_id: '',
            errored: false,
        }
    },
    mounted() {
        console.log(this.$userId);
        if(typeof(this.$userId) != "undefined" && this.$userId !== null) {
            this.user_id = this.$userId;
        }
        axios.get('/api/users')
        .then( response => {
            console.log(response.data.data);
            response.data.data.forEach(element => {
                if(element.id == this.user_id) {
                    this.email = element.email;
                    this.name = element.name;
                }
            })
        })
        .catch( error => {
            console.log(error);
            this.errored = true;
        })
    }
}

</script>