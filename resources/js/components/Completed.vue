<template>
    <div>
        <div class="d-flex justify-content-center">
            <h1>Завершенные</h1>
        </div>
        <div class='container d-flex flex-wrap'>
            <div class="card text-center m-4" v-for="task in inprocess" style='width: 46%'>
                <div class="card-header">
                    Задача: {{ task.id }}
                </div>
                <div class="card-body ">
                    <h5 class="card-title" style="text-align: left !important;">{{ task.taskName }}</h5>
                    <p class="card-text" style="text-align: left !important;"><strong>Описание: </strong>{{ task.description }}</p>
                    <p class="card-text" style="text-align: left !important;"><strong>Дедлайн: </strong>{{ task.deadline }}</p>
                    <p class="card-text" style="text-align: left !important;"><strong>Ответственный: </strong>{{ task.inprocess[0].responsible }}</p>
                    <p class="card-text" style="text-align: left !important;"><strong>Завершенный: </strong>{{ task.inprocess[0].completed[0].dateCompletion }}</p>
                    <a href="#" class="btn btn-warning" v-on:click="showModalAndGetTask( task.id )">Изменить</a>
                    <a href="#" class="btn btn-danger" v-on:click="deleteTask( task.id )">Удалить</a>
                </div>
                <div class="card-footer text-muted">
                   Создано: {{ task.created_at }}
                </div>
            </div>
        </div>

        <div class="alert alert-danger" role="alert" v-if="errored">
            Ошибка загрузки данных!
        </div>

        <div class="d-flex align-items-center" v-if="loading">
            <strong>Loading...</strong>
            <div class="spinner-border ms-auto" role="status" aria-hidden="true"></div>
        </div>

        <div class="my-modal" v-if="modal" :id="id">
            <div>
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header edit-header">
                            <h5 class="modal-title">Редактирование</h5>
                        </div>
                        <div class="p-3">
                            <label for="task" class="form-label mt-3">Задача:</label>
                            <div class="input-group mb-3">
                                <input id="task" v-model="task" type="text" class="form-control" :class="{'is-invalid': $v.task.$error}" aria-label="Задача" aria-describedby="basic-addon1">
                                <div class="invalid-feedback" v-if="!$v.task.required">
                                    Поле обязательное.
                                </div> 
                            </div>
                            <label for="description" class="form-label">Описание:</label>
                            <div class="input-group mb-3">
                                <textarea id="description" v-model="description" class="form-control" :class="{'is-invalid': $v.description.$error}" aria-label="With textarea"></textarea>
                                <div class="invalid-feedback" v-if="!$v.description.required">
                                    Поле обязательное.
                                </div> 
                            </div>
                            <label for="deadline" class="form-label">Дедлайн:</label>
                            <div class="input-group mb-3">
                                <input id="deadline" v-model="deadline" type="date" class="form-control" :class="{'is-invalid': $v.deadline.$error}" aria-label="Дедлайн" aria-describedby="basic-addon1">
                                <div class="invalid-feedback" v-if="!$v.deadline.required">
                                    Поле обязательное.
                                </div> 
                            </div>
                            <label for="responsible" class="form-label">Ответственный:</label>
                            <div class="input-group mb-3">
                                <input id="responsible" v-model="responsible" type="text" class="form-control" :class="{'is-invalid': $v.responsible.$error}" aria-describedby="basic-addon1">
                                <div class="invalid-feedback" v-if="!$v.responsible.required">
                                    Поле обязательное.
                                </div> 
                            </div>
                            <label for="dateCompletion" class="form-label">Дата завершения:</label>
                            <div class="input-group mb-3">
                                <input id="dateCompletion" v-model="dateCompletion" type="date" class="form-control" :class="{'is-invalid': $v.dateCompletion.$error}" aria-describedby="basic-addon1">
                                <div class="invalid-feedback" v-if="!$v.dateCompletion.required">
                                    Поле обязательное.
                                </div> 
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn button-purple" v-on:click="closeEditModal()">Закрыть</button>
                                <button type="button" class="btn button-green" v-on:click="saveTasks(id)">Сохранить</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>


<script>
import { required, maxLength, between, requiredIf } from 'vuelidate/lib/validators';
export default {
    data() {
        return {
            inprocess: [],
            errored: false,
            loading: true,
            modal: false,
            id: '',
            task: '',
            description: '',
            deadline: '',
            user_id: '',
            taskAdd: '',
            descriptionAdd: '',
            deadlineAdd: '',
            statusAdd: 3,
            dateCompletionBool: false,
            responsibleBool: false,
            responsible: '', 
            dateCompletion: '',
        }
    },
    mounted() {
        console.log(this.$userId);
        if(typeof(this.$userId) != "undefined" && this.$userId !== null) {
            this.user_id = this.$userId;
        }
        axios.get('/api/tasks')
        .then( response => {
            response.data.data.forEach(element => {
                if(element.inprocess.length != 0) {
                    if(element.inprocess[0].completed.length != 0 && element.user_id == this.user_id) {
                        this.inprocess.push(element);
                    }
                }
            })
        })
        .catch( error => {
            console.log(error);
            this.errored = true;
        })
        .finally( () => {
            this.loading = false;
        });
    },
    methods: {
        onChange() {
            console.log('select check '+ this.statusAdd);
            if(this.statusAdd == 2) {
                this.responsibleBool = true;
                this.dateCompletionBool = false;
            } else if(this.statusAdd == 3) {
                this.responsibleBool = true;
                this.dateCompletionBool = true;
            } else {
                this.responsibleBool = false;
                this.dateCompletionBool = false;
            }

        },
        deleteTask(id) {
            console.log(id);
            axios.post('/api/tasks/'+id, {
                _method: 'DELETE'
            })
            .catch( error => {
                console.log(error);
                this.errored = true;
            })
            document.location.reload();
        },
        showModalAndGetTask(id) {
            this.modal = true;
            this.id = id;
            axios.get('/api/tasks/'+id)
            .then( response => {
                console.log(response.data.data);
                this.task = response.data.data.taskName;
                this.description = response.data.data.description;
                this.deadline = response.data.data.deadline;
                this.user_id = response.data.data.user_id;
                this.responsible = response.data.data.inprocess[0].responsible;
                this.dateCompletion = response.data.data.inprocess[0].completed[0].dateCompletion;
            })
            .catch( error => {
                console.log(error);
                this.errored = true;
            })
            console.log('show '+ id);
        },
        saveTasks(id) {
            this.$v.$touch();
            if(this.$v.$anyError) {
                return;
            }
            axios.post('/api/tasks/'+id, {
                _method: 'PUT',
                taskName: this.task,
                description: this.description,
                deadline: this.deadline,
                user_id: this.user_id
            })
            .catch( error => {
                console.log(error);
                this.errored = true;
            })
            axios.get('/api/tasks/'+id)
            .then( response => {
                axios.post('/api/inprocess/'+response.data.data.inprocess[0].id, {
                    _method: 'PUT',
                    responsible: this.responsible,
                    tasks_id: id
                })
                .catch( error => {
                    console.log(error);
                    this.errored = true;
                })
                axios.post('/api/completed/' + response.data.data.inprocess[0].completed[0].id, {
                    _method: 'PUT',
                    dateCompletion: this.dateCompletion,
                    in_process_id: response.data.data.inprocess[0].id
                })
                .catch( error => {
                    console.log(error);
                    this.errored = true;
                })
    
                document.location.reload();
            });
            this.modal = false;
        },
        closeEditModal() {
            this.modal = false;
        }
    },
    validations: {
        task: {
            required
        },
        description: {
            required
        },
        deadline: {
            required
        },
        responsible: {
            required
        },
        dateCompletion: {
            required
        }
    }
}

</script>