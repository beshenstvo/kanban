<template>
    <div>
        <div class="d-flex justify-content-center">
            <div><a href="#"  v-on:click="addTask()"><i class="fa-solid fa-plus add-button"></i></a></div>
        </div>
        <div class='container d-flex flex-wrap justify-content-between'>
            <div class="card text-center m-4" v-for="task in tasks" style='width: 31em'>
                <div class="card-header">
                    Задача: {{ task.id }}
                </div>
                <div class="card-body ">
                    <h5 class="card-title" style="text-align: left !important;">{{ task.taskName }}</h5>
                    <p class="card-text" style="text-align: left !important;"><strong>Описание: </strong>{{ task.description }}</p>
                    <p class="card-text" style="text-align: left !important;"><strong>Дедлайн: </strong>{{ task.deadline }}</p>
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
                            <div class="input-group mb-3">
                                <select class="form-select" v-model="statusAdd" @change="onChange()" id="inputGroupSelect02">
                                    <option value="1" selected>Задачи</option>
                                    <option value="2">В процессе</option>
                                </select>
                                <label class="input-group-text" for="inputGroupSelect02">Статус</label>
                            </div>
                            <label for="responsible" class="form-label" v-if="responsibleBool">Ответственный:</label>
                            <div class="input-group mb-3" v-if="responsibleBool">
                                <input id="responsible" v-model="responsible" type="text" class="form-control" :class="{'is-invalid': $v.responsible.$error}" aria-describedby="basic-addon1">
                                <div class="invalid-feedback" v-if="!$v.responsible.required">
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

        <div class="my-modal" v-if="modalAdd" :id="id">
            <div>
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header edit-header">
                            <h5 class="modal-title">Добавление</h5>
                        </div>
                        <div class="p-3">
                            <label for="task" class="form-label mt-3">Задача:</label>
                            <div class="input-group mb-3">
                                <input id="task" v-model="taskAdd" type="text" class="form-control" :class="{'is-invalid': $v.taskAdd.$error}"  aria-describedby="basic-addon1">
                                <div class="invalid-feedback" v-if="!$v.taskAdd.required">
                                    Поле обязательное.
                                </div>  
                            </div>
                            <label for="description" class="form-label">Описание:</label>
                            <div class="input-group mb-3">
                                <textarea id="description" v-model="descriptionAdd" class="form-control" :class="{'is-invalid': $v.descriptionAdd.$error}" aria-label="With textarea"></textarea>
                                <div class="invalid-feedback" v-if="!$v.descriptionAdd.required">
                                    Поле обязательное.
                                </div> 
                            </div>
                            <label for="deadline" class="form-label">Дедлайн:</label>
                            <div class="input-group mb-3">
                                <input id="deadline" v-model="deadlineAdd" type="date" class="form-control" :class="{'is-invalid': $v.deadlineAdd.$error}" aria-describedby="basic-addon1">
                                <div class="invalid-feedback" v-if="!$v.deadlineAdd.required">
                                    Поле обязательное.
                                </div> 
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn button-purple" v-on:click="closeEditModal()">Закрыть</button>
                                <button type="button" class="btn button-green" v-on:click="saveNewTask()">Сохранить</button>
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
import { $userId } from '../app';
export default {
    data() {
        return {
            tasks: [],
            errored: false,
            loading: true,
            modal: false,
            id: '',
            task: '',
            description: '',
            deadline: '',
            user_id: '',
            modalAdd: false,
            taskAdd: '',
            descriptionAdd: '',
            deadlineAdd: '',
            statusAdd: 1,
            dateCompletionBool: false,
            responsibleBool: false,
            responsible: '', 
            dateCompletion: '',
            process_id: '',
        }
    },
    mounted() {
        console.log(this.$userId);
        if(typeof(this.$userId) != "undefined" && this.$userId !== null) {
            this.user_id = this.$userId;
        }
        axios.get('/api/tasks')
        .then( response => {
            console.log(response.data.data);
            // this.tasks = response.data.data;
            response.data.data.forEach(element => {
                if(element.inprocess.length == 0 && element.user_id == this.user_id) {
                    console.log('is empty');
                    this.tasks.push(element);
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
        addTask() {
            console.log('add');
            this.modalAdd = true;
        },
        saveNewTask() {
            this.$v.$touch();
            if(this.$v.deadlineAdd.$error || this.$v.descriptionAdd.$error || this.$v.deadlineAdd.$error || this.$v.taskAdd.$error) {
                return;
            }
            axios.post('/api/tasks',{
                taskName: this.taskAdd,
                description: this.descriptionAdd,
                deadline: this.deadlineAdd,
                user_id: this.user_id
            })
            .catch( error => {
                console.log(error);
                this.errored = true;
            })
            this.modalAdd = false;
            document.location.reload()
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
            console.log('saving' + id);
            axios.post('/api/tasks/'+id, {
                _method: 'PUT',
                taskName: this.task,
                description: this.description,
                deadline: this.deadline,
                user_id: this.user_id,
            })
            .catch( error => {
                console.log(error);
                this.errored = true;
            })
            this.modal = false;
            if(this.statusAdd == 2) { //сохранить в таблицу inprocess
                console.log('saving new inprocess '+id+' '+this.responsible);
                axios.post('/api/inprocess', {
                    responsible: this.responsible,
                    tasks_id: id
                })
                .catch( error => {
                    console.log(error);
                    this.errored = true;
                })
            }
            document.location.reload();
        },
        closeEditModal() {
            this.modal = false;
            this.modalAdd = false;
            console.log(this);
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
            required: requiredIf(function() {
                return this.responsibleBool;
            })
        },
        deadlineAdd: {
            required: requiredIf(function() {
                return this.modalAdd;
            })
        },
        taskAdd: {
            required: requiredIf(function() {
                return this.modalAdd;
            })
        },
        descriptionAdd: {
            required: requiredIf(function() {
                return this.modalAdd;
            })
        }
    },
}

</script>