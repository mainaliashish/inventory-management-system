<template lang="en">
    <div>
        <div class="row">
            <router-link to="/expenses" class="btn btn-primary">All Expenses</router-link>

        </div>
        <div class="row justify-content-center">
            <div class="col-xl-12 col-lg-12 col-md-12">
                <div class="card shadow-sm my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="login-form">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Update Expense</h1>
                                    </div>
                                    <form class="user" @submit.prevent="handleExpenseUpdate">

                                        <div class="form-group">

                                            <div class="form-group">
                                                <div class="form-row">
                                                    <div class="col-md-6">
                                                        <label for="exampleFormControlDate">Expense Date</label>

                                                        <input type="date" v-model="form.expense_date"
                                                            class="form-control" id="inputexpense_date"
                                                            placeholder="Enter Your expense_date">
                                                        <small class="text-danger"
                                                            v-if="errors.expense_date">{{ errors.expense_date[0] }}</small>

                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="exampleFormControlAmount">Expense Amount</label>
                                                        <input type="text" v-model="form.amount" class="form-control"
                                                            id="inputAmount" placeholder="Enter expenses amount">
                                                        <small class="text-danger"
                                                            v-if="errors.amount">{{ errors.amount[0] }}</small>

                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="exampleFormControlTextarea1">Expense Details</label>
                                                <textarea class="form-control" v-model="form.details"
                                                    id="exampleFormControlTextarea1" rows="3"></textarea>
                                                <small class="text-danger"
                                                    v-if="errors.details">{{ errors.details[0] }}</small>

                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary">Save Changes</button>
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
  created(){
    if(!User.loggedIn()){
      this.$router.push({ name: '/' })
    }
  },
  data(){
    return {
      form: {
        details: '',
        expense_date: '',
        amount: ''
      },
      errors: {},
    }
  },
  created() {
      let id = this.$route.params.id
      axios.get('/api/expense/'+id)
      .then(({data}) => (this.form = data))
      .catch(({error}) => (console.log(error)))
  },
  methods: {
    handleExpenseUpdate() {
        let id = this.$route.params.id
        axios.put('/api/expense/'+id, this.form)
        .then(() => {
          this.$router.push({ name: 'expenses'})
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