<template lang="en">
    <div>
        <div class="row ml-1">
            <router-link to="/salaries" class="btn btn-primary">Go back</router-link>
        </div>
        <input type="text" v-model="searchTerm" class="form-control mt-2" placeholder="Search Here.."
            style="width:300px;" />
        <div class="row mt-3">
            <div class="col-lg-12 mb-4">
                <!-- Simple Tables -->
                <div class="card">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Employees Salary Details</h6>
                    </div>
                    <div class="table-responsive">
                        <table class="table align-items-center table-flush">
                            <thead class="thead-light">
                                <tr>
                                    <th>Name</th>
                                    <th>Month</th>
                                    <th>Amount</th>
                                    <th>Date</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>

                                <tr v-for="salary in filterSearch" :key="salary.id">
                                    <td>{{ salary.name }}</td>
                                    <td>{{ salary.salary_month }}</td>
                                    <td>{{ salary.amount }}</td>
                                    <td>{{ salary.salary_date }}</td>
                                    <td class="text-center">
                                        <router-link :to="{ name: 'edit-salary', params:{id: salary.id}}"
                                            class="btn btn-sm btn-primary">Edit Salary</router-link>
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer"></div>
                </div>
            </div>
        </div>
        <!--Row-->

    </div>
</template>

<script>
    export default {
        created() {
            if (!User.loggedIn()) {
                this.$router.push({
                    name: '/'
                })
            }
        },
        data() {
            return {
                salaries: [],
                searchTerm: '',
                response: null,
            }
        },
        computed: {
            filterSearch() {
                return this.salaries.filter(salary => {
                    return salary.name.match(this.searchTerm)
                })
            }
        },
        methods: {
            getAllSalary() {
             let id = this.$route.params.id
             axios.get('/api/salary/view/'+id)
             .then(({data}) => this.salaries = data)
             .catch(
             error => this.errors = error.response.data.errors
             );
            }
        },
        // Update employees after adding new employee
        created() {
            this.getAllSalary();
        },

    }
</script>

<style type="text/css">
    #emp_photo {
        height: 60px;
        width: 60px;
        border: 1px solid black;
        box-shadow: 1px 1px cyan;
        border-radius: 6px 5px;
    }
</style>