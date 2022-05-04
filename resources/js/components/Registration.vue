<template>
    <div>
        <div class="alert alert-danger m-3" role="alert" v-if="errored">
            Ошибка регистрации! Возможно пользователь с таким email уже существует.
        </div>
        <div class="container" style="width: 40%">
            <form>
                <span v-if="registered">Successfully registered</span><br>
                <div class="mb-3">
                    <label class="form-label"><strong>Name</strong></label>
                    <input type="text" class="form-control" aria-describedby="emailHelp" v-model="form.name" placeholder="Rufina">
                </div>
                <div class="mb-3">
                    <label class="form-label"><strong>Email address</strong></label>
                    <input type="email" class="form-control" aria-describedby="emailHelp" v-model="form.email" placeholder="example@gmail.com">
                </div>
                <div class="mb-3">
                    <label class="form-label"><strong>Password</strong></label>
                    <input type="password" class="form-control" v-model="form.password" placeholder="**********">
                </div>
                <div class="mb-3">
                    <label class="form-label"><strong>Password Confirmation</strong></label>
                    <input type="password" class="form-control" v-model="form.password_confirmation" placeholder="**********">
                </div>
                <button @click="sendForm" :disabled="pending" class="btn btn-primary">Registration</button>
            </form>
        </div>
    </div>
</template>
 
<script>
import axios from 'axios';
 
export default {
    name: 'Registration',
    data() {
        return {
            pending: false,
            registered: false,
            errored: false,
            form: {
                name: null,
                email: null,
                password: null,
                password_confirmation: null,
            }
        }
    },
    methods: {
        sendForm() {
            if (this.pending === false) {
                this.pending = true;
                axios.get('/sanctum/csrf-cookie').then(response => {
                    axios.post('register', this.form)
                    .then(response => {
                        this.registered = true;
                        console.log(response);
                        localStorage.setItem('x_xsrf_token', response.config.headers['X-XSRF-TOKEN']);
                        this.$router.push({ name: 'tasks'});
                        document.location.reload();
                    })
                    .catch(errors => {
                        this.registered = false;
                        this.errored = errors;
                        console.log(errors);
                    })
                    .then(() => {
                        this.pending = false;
                    });
                });
            }
        }
    }
}
</script>
