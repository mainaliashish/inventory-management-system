<template lang="en">
    <div>
      <div class="row ml-1">
        <router-link to="/employee/add" class="btn btn-primary">Add Employees</router-link>
      </div>
      <input type="text" v-model="searchTerm" class="form-control mt-2" placeholder="Search Here.." style="width:300px;" />
          <div class="row mt-3">
            <div class="col-lg-12 mb-4">
              <!-- Simple Tables -->
              <div class="card">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Employees List</h6>
                </div>
                <div class="table-responsive">
                  <table class="table align-items-center table-flush">
                    <thead class="thead-light">
                      <tr>
                        <th>Name</th>
                        <th>Photo</th>
                        <th>Phone</th>
                        <th>Salary</th>
                        <th>Joining Date</th>
                        <th class="text-center">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                    
                      <tr v-for="employee in filterSearch" :key="employee.id">
                        <td>{{ employee.name }}</td>
                        <td><img :src="employee.photo" v-if="employee.photo" id="emp_photo"></td>
                        <td>{{ employee.phone }}</td>
                        <td>{{ employee.salary }}</td>
                        <td>{{ employee.joining_date }}</td>
                        <td class="text-center">
                          <router-link :to="{ name: 'edit-employee', params:{id: employee.id}}" class="btn btn-sm btn-primary">Edit</router-link>
                          <a href="#" @click="deleteEmployee(employee.id)" class="btn btn-sm btn-danger">Delete</a>
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
      employees: [],
      searchTerm: '',
      response: null,
    }
  },  
  computed: {
    filterSearch() {
      return this.employees.filter(employee => {
        return employee.name.match(this.searchTerm)
      })
    }
  },
  methods: {
    getAllEmployees() {
      axios.get('/api/employee')
      .then(({data}) => (this.employees = data))
      .catch()
    },
    deleteEmployee(id) {
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
              axios.delete('/api/employee/'+id )
              .then(() => {
                this.employees = this.employees.filter(employee => {
                  return employee.id != id;
                })
              })
              .catch(() => {
                this.$router.push({name: 'employees'})
              })
              Swal.fire(
                'Deleted!',
                'Employee data has been deleted.',
                'success'
              )
            } 
          })
    }
  },
  // Update employees after adding new employee
  created() {
    this.getAllEmployees();
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