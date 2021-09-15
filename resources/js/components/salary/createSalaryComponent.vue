<template lang="en">
    <div>
        <div class="row">
            <router-link to="/salaries" class="btn btn-primary">All Salaries</router-link>

        </div>
        <div class="row justify-content-center">
            <div class="col-xl-12 col-lg-12 col-md-12">
                <div class="card shadow-sm my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="login-form">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Pay Salary</h1>
                                    </div>
                                    <form class="user" @submit.prevent="handlePaySalary">

                                        <div class="form-group">

                                            <div class="form-group">
                                                <div class="form-row">
                                                    <div class="col-md-6">
                                                        <label for="exampleFormControlSelect1"><b>
                                                                Employee Name</b></label>
                                                        <input type="text" v-model="form.name" class="form-control" />
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="exampleFormControlSelect1"><b>Email</b></label>

                                                        <input type="email" v-model="form.email" class="form-control"
                                                            id="inputEmail" placeholder="Enter Your email">
                                                        <small class="text-danger"
                                                            v-if="errors.email">{{ errors.email[0] }}</small>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="form-row">
                                                    <div class="col-md-4">
                                                        <label for="exampleFormControlSelect1"><b>Select
                                                                Month</b></label>
                                                        <select class="form-control" id="exampleFormControlSelect1"
                                                            v-model="form.salary_month">
                                                            <option value="January">January</option>
                                                            <option value="February">February</option>
                                                            <option value="March">March</option>
                                                            <option value="April">April</option>
                                                            <option value="May">May</option>
                                                            <option value="June">June</option>
                                                            <option value="July">July</option>
                                                            <option value="August">August</option>
                                                            <option value="September">September</option>
                                                            <option value="October">October</option>
                                                            <option value="November">November</option>
                                                            <option value="December">December</option>
                                                        </select>
                                                        <small class="text-danger"
                                                            v-if="errors.salary_date">{{ errors.salary_month[0] }}</small>
                                                    </div>
                                                    
                                                  
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="form-row">
                                                    <div class="col-md-6">
                                                        <label for="exampleFormControlSelect1"><b>
                                                                Salary</b></label>
                                                        <input type="text" v-model="form.amount" class="form-control" placeholder="Enter salary amount"/>
                                                         <small class="text-danger"
                                                             v-if="errors.amount">{{ errors.amount[0] }}</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary">Pay Salary</button>
                                        </div>
                                        <hr>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
                form: {
                    name: '',
                    email: '',
                    amount: '',
                    salary_month: '',
                    
                },
                errors: {}
            }
        },
        created() {
            let id = this.$route.params.id
            axios.get('/api/employee/' + id)
                .then(({
                    data
                }) => (this.form = data))
                .catch(({
                    error
                }) => (console.log(error)))
        },
        methods: {

            handlePaySalary() {
                let id = this.$route.params.id
                axios.post('/api/salary/paid/'+id, this.form)
                    .then(() => {
                        this.$router.push({
                            name: 'salaries'
                        })
                     
                        Notification.success();
                    })
                    .catch(
                        error => this.errors = error.response.data.errors
                    );
            },
        }
    }

</script>

<style lang="en">

</style>
