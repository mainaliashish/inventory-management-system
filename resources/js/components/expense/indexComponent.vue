<template lang="en">
    <div>
      <div class="row ml-1">
        <router-link to="/expense/add" class="btn btn-primary">Add Expense</router-link>
      </div>
      <input type="text" v-model="searchTerm" class="form-control mt-2" placeholder="Search Here.." style="width:300px;" />
          <div class="row mt-3">
            <div class="col-lg-12 mb-4">
              <!-- Simple Tables -->
              <div class="card">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Expenses List</h6>
                </div>
                <div class="table-responsive">
                  <table class="table align-items-center table-flush">
                    <thead class="thead-light">
                      <tr>
                        <th>Amount</th>
                        <th>Expense Date</th>
                        <th>Details</th>
                        <th class="text-center">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                    
                      <tr v-for="expense in filterSearch" :key="expense.id">
                        <td>NPR. {{ expense.amount }}</td>
                        <td>{{ expense.expense_date }}</td>
                        <td>{{ expense.details }}</td>
                        <td class="text-center">
                          <router-link :to="{ name: 'edit-expense', params:{id: expense.id}}" class="btn btn-sm btn-primary">Edit</router-link>
                          <a href="#" @click="deleteExpense(expense.id)" class="btn btn-sm btn-danger">Delete</a>
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
  created(){
    if(!User.loggedIn()){
      this.$router.push({ name: '/' })
    }
  },
  data() {
    return {
      expenses: [],
      searchTerm: '',
      response: null,
    }
  },  
  computed: {
    filterSearch() {
      return this.expenses.filter(expense => {
        return expense.details.match(this.searchTerm)
      })
    }
  },
  methods: {
    getAllExpenses() {
      axios.get('/api/expense')
      .then(({data}) => (this.expenses = data))
      .catch()
    },
    deleteExpense(id) {
          Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
          }).then((result) => {
            if (result.isConfirmed) {
              axios.delete('/api/expense/'+id )
              .then(() => {
                this.expenses = this.expenses.filter(expense => {
                  return expense.id != id;
                })
              })
              .catch(() => {
                this.$router.push({name: 'expenses'})
              })
              Swal.fire(
                'Deleted!',
                'Expense data has been deleted.',
                'success'
              )
            } 
          })
    }
  },
  // Update employees after adding new employee
  created() {
    this.getAllExpenses();
    // console.log();
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