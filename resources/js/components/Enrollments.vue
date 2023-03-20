<template>
    <div>
        <div class="filters">
            <label>Filter by course name:</label>
            <input type="text" v-model="courseNameFilter">
        </div>
        <div class="filters">
            <label>Filter by user email / name:</label>
            <input type="text" v-model="userNameFilter">
        </div>
        <div class="filters">
            <label>Filter by enrollment status:</label>
            <select v-model="enrollmentStatusFilter">
                <option value="">All</option>
                <option value="1">In Progress</option>
                <option value="2">Complete</option>
            </select>
        </div>
        <div class="filters">
            <label>Sort by:</label>
            <select v-model="sortField">
                <option value="">Default</option>
                <option value="updated_at">Completion Date</option>
                <option value="created_at">Join Date</option>
                <option value="course_title">Course Name</option>
            </select>
            <select v-model="sortOrder">
                <option value="asc">Ascending</option>
                <option value="desc">Descending</option>
            </select>
        </div>
        <table>
            <thead>
            <tr>
                <th>Course Name</th>
                <th>User Name</th>
                <th>Status</th>
                <th>Date of joining course</th>
                <th>Date of course completion</th>
                <th>Setting</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="enrollment in enrollments.data" :key="enrollment.id">
                <td>{{ enrollment.courseTitle }}</td>
                <td>{{ enrollment.userName }}</td>
                <td>{{ getStatus(enrollment.status) }}</td>
                <td>{{ formatDate(enrollment.created_at) }}</td>
                <td>{{ formatDate(enrollment.updated_at) }}</td>
                <td>
                    <button
                        class="update-enrollment"
                        @click="updateEnrollment(enrollment.id)"
                    >
                        Update
                    </button>
                    <button
                        class="delete-enrollment"
                        @click="deleteEnrollment(enrollment.id)"
                    >
                        Delete
                    </button>
                </td>
            </tr>
            </tbody>
        </table>
        <pagination
            v-model="linkPage"
            :data="enrollments.data"
            :value="currentPage"
            :records="total"
            :per-page="perPage"
            :current-page="currentPage"
            @paginate="pageChanged">
        </pagination>
        <enrollment-form
            :enrollment-update="enrollmentUpdate"
            :new-record="newRecord"
            @clear-selected="clearSelected"
        />
        <div ref="form-enrollment"></div>
    </div>
</template>

<script>
import axios from 'axios';
import Pagination from 'vue-pagination-2';
import Select2 from 'v-select2-component';
import EnrollmentForm from "./EnrollmentForm.vue";

export default {

    /**
     * List of components that are used in this one.
     */
    components: {
        EnrollmentForm,
        Pagination,
        Select2
    },

    /**
     * Data of the component.
     */
    data() {
        return {
            enrollments: [],
            params: {},
            perPage: 5,
            total: 0,
            currentPage: 1,
            defaultPage: 1,
            linkPage: 1,
            courseNameFilter: '',
            userNameFilter: '',
            enrollmentStatusFilter: '',
            sortField: '',
            sortOrder: 'asc',
            newRecord: true,
            enrollmentUpdate: []
        };
    },

    /**
     * Methods.
     */
    methods: {
        /**
         * Update enrollments from Api.
         */
        fetchData() {
            axios.get('/api/enrollments', this.params).then((response) => {
                this.enrollments = response.data;
                this.perPage = this.enrollments.per_page;
                this.total = this.enrollments.total;
            });
        },

        /**
         * Changed page.
         */
        pageChanged(page) {
            this.currentPage = page;
        },

        /**
         * Get Status Title.
         */
        getStatus(status) {
            return status === 1 ? 'In progress' : 'Complete';
        },

        /**
         * Format date.
         */
        formatDate(dateString) {
            if( dateString === '' || dateString === null){
                return '';
            }
            const date = new Date(dateString);
            const year = date.getFullYear();
            const month = ("0" + (date.getMonth() + 1)).slice(-2);
            const day = ("0" + date.getDate()).slice(-2);
            const hours = ("0" + date.getHours()).slice(-2);
            const minutes = ("0" + date.getMinutes()).slice(-2);
            const seconds = ("0" + date.getSeconds()).slice(-2);

            return `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`;
        },

        /**
         * Update data by filters on page.
         */
        updateDataByFilters(page) {
            this.linkPage = page;
            this.params = {
                'params': {
                    course_name: this.courseNameFilter,
                    user_name: this.userNameFilter,
                    status: this.enrollmentStatusFilter,
                    sort_by: this.sortField,
                    sort_order: this.sortOrder,
                    page: page,
                }
            }

            this.fetchData();
        },

        /**
         * Update enrollment, load in selects.
         */
        updateEnrollment(id) {
            this.enrollmentUpdate = this.enrollments.data.filter(function (item) {
                return item.id === id;
            });
            this.newRecord = false;
            this.$refs["form-enrollment"].scrollIntoView({behavior: "smooth"})
        },

        /**
         * Delete enrollment from api.
         */
        deleteEnrollment(id) {
            axios.delete('/api/enrollment').then((response) => {
                this.enrollments.data = this.enrollments.data.filter(function (item) {
                    return item.id !== id;
                });
            }).catch((error) => {
                console.log(error);
            });
        },

        /**
         * Clear selected.
         */
        clearSelected() {
            this.enrollmentUpdate = [];
            this.newRecord = true;
        }
    },

    /**
     * Watch changes.
     */
    watch: {
        currentPage() {
            this.updateDataByFilters(this.currentPage);
        },
        courseNameFilter() {
            this.updateDataByFilters(this.defaultPage);
        },
        userNameFilter() {
            this.updateDataByFilters(this.defaultPage);
        },
        enrollmentStatusFilter() {
            this.updateDataByFilters(this.currentPage);
        },
        sortField() {
            this.updateDataByFilters(this.currentPage);
        },
        sortOrder() {
            this.updateDataByFilters(this.currentPage);
        }
    },

    /**
     * Mounted hook.
     */
    mounted() {
        this.fetchData();
    },
};
</script>
