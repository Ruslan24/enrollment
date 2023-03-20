<template>
    <div>
        <div class="form-enrollment">
            <h1> {{ newRecord ? 'Create enrollment' : 'Update enrollment ID: ' + selectEnrollmentId }}</h1>
            <label for="course">Course Name:</label>
            <select2
                v-model="selectCourse"
                id="course"
                class="vue-select"
                name="selectCourse"
                :options="optionsCourse"
                :model.sync="selectCourse"
                :searchable="true"
                :disabled="!newRecord"
            >
            </select2>
            <label for="user">User Name:</label>
            <select2
                v-model="selectUser"
                id="user"
                class="vue-select"
                name="selectUser"
                :options="optionsUser"
                :model.sync="selectUser"
                :searchable="true"
                :disabled="!newRecord"
            >
            </select2>
            <label for="user">Status:</label>
            <select2
                v-model="selectStatus"
                id="status"
                class="vue-select"
                name="selectStatus"
                :options="optionsStatus"
                :model.sync="selectStatus"
            >
            </select2>
            <br>
            <button
                @click="submitEnrollment()"
                type="button"
            >
                {{ newRecord ? 'Enroll User' : 'Update enroll User' }}
            </button>
            <br>
            <span class="error-message" v-if="errors">{{ errors }}</span>
            <span class="success-message" v-if="message">{{ message }}</span>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import Select2 from 'v-select2-component';

export default {
    /**
     * List of components that are used in this one.
     */
    components: {
        Select2
    },

    /**
     * Props.
     */
    props: {
        newRecord: {
            type: Boolean,
            default() {
                return true;
            },
        },
        enrollmentUpdate: {
            type: Array,
            default() {
                return [];
            },
        },
    },

    /**
     * Data of the component.
     */
    data() {
        return {
            optionsCourse: [],
            optionsUser: [],
            optionsStatus: [],
            selectCourse: '',
            selectUser: '',
            selectStatus: '',
            searchCourse: '',
            searchUser: '',
            selectEnrollmentId: '',
            message: '',
            errors: ''
        };
    },

    /**
     * Methods.
     */
    methods: {

        /**
         * Submit form to api.
         */
        submitEnrollment() {
            if (this.selectCourse !== '' && this.selectUser !== '' && this.selectStatus !== '') {
                const data = {
                    'course_id': this.selectCourse,
                    'user_id': this.selectUser,
                    'status': this.selectStatus,
                    'id': this.selectEnrollmentId,
                };
                if (this.newRecord) {
                    axios.post('/api/enrollment', data).then((response) => {
                            this.clearSelects();
                            this.message = 'Saved successfully!'
                        }).catch((error) => {
                            this.errors = 'An error occurred, try again later!'
                            console.log(error);
                        });
                } else {
                    axios.put('/api/enrollment', data).then((response) => {
                            this.clearSelects();
                            this.message = 'Saved successfully!'
                        }).catch((error) => {
                            this.errors = 'An error occurred, try again later!'
                            console.log(error);
                        });
                }
            } else {
                this.errors = 'All fields are mandatory!';
            }
        },

        /**
         * Clear selects.
         */
        clearSelects() {
            this.selectCourse = '';
            this.selectUser = '';
            this.selectStatus = '';
            this.selectEnrollmentId = '';
            this.$emit('clear-selected');
        },

        /**
         * Load curses select.
         */
        loadCursesSelect() {
            axios.get('/api/courses').then((response) => {
                let option = [];
                response.data.items = response.data.filter(function (item) {
                    return option.push({id: item.id, text: item.title, selected: false})
                })
                this.optionsCourse = option;
            });
        },

        /**
         * Load users select.
         */
        loadUsersSelect() {
            axios.get('/api/users').then((response) => {
                let option = [];
                response.data.items = response.data.filter(function (item) {
                    return option.push({id: item.id, text: item.name, selected: false})
                })
                this.optionsUser = option;
            });
        },

        /**
         * Load status select title.
         */
        loadStatusSelect() {
            this.optionsStatus = [
                {id: 1, text: 'In progress', selected: this.newRecord},
                {id: 2, text: 'Complete', selected: false},
            ]
        },
    },

    /**
     * Watch changes.
     */
    watch: {
        enrollmentUpdate() {
            if(this.enrollmentUpdate.length > 0) {
                let courseId, userId, status, enrollmentId;
                this.enrollmentUpdate.filter(function (item) {
                    courseId = item.courseId;
                    userId = item.userId;
                    status = item.status;
                    enrollmentId = item.id;
                })
                this.selectCourse = courseId;
                this.selectUser = userId;
                this.selectStatus = status;
                this.selectEnrollmentId = enrollmentId;
            }
        },
        errors() {
            this.message = '';
        },
        message() {
            this.errors = '';
        }
    },

    /**
     * Mounted hook.
     */
    mounted() {
        this.loadCursesSelect();
        this.loadUsersSelect();
        this.loadStatusSelect();
    },
};
</script>
