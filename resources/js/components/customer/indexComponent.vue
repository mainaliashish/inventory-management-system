<template lang="en">
    <div>
      <div class="row ml-1">
        <router-link to="/customer/add" class="btn btn-primary">Add Customer</router-link>
      </div>
      <input type="text" v-model="searchTerm" class="form-control mt-2" placeholder="Search Here.." style="width:300px;" />
          <div class="row mt-3">
            <div class="col-lg-12 mb-4">
              <!-- Simple Tables -->
              <div class="card">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Customer List</h6>
                </div>
                <div class="table-responsive">
                  <table class="table align-items-center table-flush">
                    <thead class="thead-light">
                      <tr>
                        <th>Name</th>
                        <th>Photo</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Address</th>
                        <th class="text-center">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                    
                      <tr v-for="customer in filterSearch" :key="customer.id">
                        <td>{{ customer.name }}</td>
                        <td><img :src="customer.photo" v-if="customer.photo" id="emp_photo"></td>
                        <td>{{ customer.phone }}</td>
                        <td>{{ customer.email }}</td>
                        <td>{{ customer.address }}</td>
                        <td class="text-center">
                          <router-link :to="{ name: 'edit-customer', params:{id: customer.id}}" class="btn btn-sm btn-primary">Edit</router-link>
                          <a href="#" @click="deleteCustomer(customer.id)" class="btn btn-sm btn-danger">Delete</a>
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
      customers: [],
      searchTerm: '',
      response: null,
    }
  },  
  computed: {
    filterSearch() {
      return this.customers.filter(cutomer => {
        return cutomer.name.match(this.searchTerm)
      })
    }
  },
  methods: {
    getAllCustomers() {
      axios.get('/api/customer')
      .then(({data}) => (this.customers = data))
      .catch()
    },
    deleteCustomer(id) {
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
              axios.delete('/api/customer/'+id )
              .then(() => {
                this.customers = this.customers.filter(customer => {
                  return customer.id != id;
                })
              })
              .catch(() => {
                this.$router.push({name: 'employees'})
              })
              Swal.fire(
                'Deleted!',
                'Customer data has been deleted.',
                'success'
              )
            } 
          })
    }
  },
  // Update customers after adding new customer
  created() {
    this.getAllCustomers();
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