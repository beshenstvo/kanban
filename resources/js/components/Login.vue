<template>
    <div>
        <div class="container" style="width: 40%">
            <form>
                <span v-if="loggedIn">Successfully logged in</span><br>
                <div class="mb-3">
                    <label class="form-label"><strong>Email address</strong></label>
                    <input type="email" class="form-control" aria-describedby="emailHelp" v-model="form.email" placeholder="example@gmail.com">
                    <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
                </div>
                <div class="mb-3">
                    <label class="form-label"><strong>Password</strong></label>
                    <input type="password" class="form-control" v-model="form.password" placeholder="**********">
                </div>
                <button @click="sendForm" :disabled="pending" class="btn btn-primary">Login</button>
            </form>
        </div>
    </div>
</template>
 
<script>
import axios from 'axios';
 
export default {
    name: 'Login',
    data() {
        return {
            pending: false,
            loggedIn: false,
            form: {
                email: null,
                password: null
            },
            user_id_login: null,
        }
    },
    methods: {
        sendForm() {
            if (this.pending === false) {
                this.pending = true;
                axios.get('/sanctum/csrf-cookie').then(response => {
                    axios.post('login', this.form)
                    .then(response => {
                        this.loggedIn = true;
                        console.log(response);
                        localStorage.setItem('x_xsrf_token', response.config.headers['X-XSRF-TOKEN']);
                        //запрос axios на получение id user по email = email.input
                        // axios.get('/api/users').then(response =>{
                        //     response.data.data.forEach(element => {
                        //         if( element.email === this.form.email) {
                        //             this.user_id_login = element.id;
                        //             // console.log('finded email '+ element.email + 'id ' + element.id);
                        //         }
                        //     })
                        // })
                        this.$router.push({ name: 'tasks'});
                        document.location.reload();
                    })
                    .catch(errors => {
                        console.log(errors);
                    })
                    .then(() => {
                        this.pending = false;
                    });
                    if(this.loggedIn) {
                        window.location.replace('http://127.0.0.1:8000/tasks')
                    }
                });
            }
        }
    }
}
</script>