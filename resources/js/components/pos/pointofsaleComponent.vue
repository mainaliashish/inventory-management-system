<template lang="en">
    <div>
        <!-- Container Fluid-->
        <div class="container-fluid" id="container-wrapper">
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">POS Dashboard</h1>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="./">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">POS</li>
                </ol>
            </div>

            <div class="row mb-3">

                <!-- Area Chart -->
                <div class="col-xl-5 col-lg-5">
                    <div class="card mb-4">
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-primary">Expenses Insert</h6>
                            <a class="btn badge-primary btn-sm">
                                <font color="white">Add Customer</font></a>

                        </div>  
                                    <div class="table-responsive" style="font-size:12px;">
                                        <table class="table align-items-center table-flush">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Qty</th>
                                                    <th>Unit</th>
                                                    <th>Total</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="cart in carts" :key="cart.id">
                                                    <td>{{ cart.product_name }}</td>
                                                    <td>
                                                    <button @click="incrementCart(cart.id)" class="btn btn-sm btn-primary">+</button>    
                                                    <input type="text" readonly=""
                                                            :value="cart.product_quantity" style="width:14px;">
                                                    <button @click="decrementCart(cart.id)" class="btn btn-sm btn-danger" 
                                                    v-if="cart.product_quantity >=2"
                                                    >-</button>
                                                    <button class="btn btn-danger btn-sm" disabled v-else="">-</button>
                                                    </td>
                                                    
                                                    <td>{{ cart.product_price }}</td>
                                                    <td>{{ cart.sub_total }}</td>
                                                    <td><a @click="removeItemFromCart(cart.id)" class="btn btn-sm btn-danger"><font color="white">x</font></a></td>
                                                </tr>
                                                
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="card-footer">
                                         <ul class="list-group">
                                             <li
                                                 class="list-group-item d-flex justify-content-between align-items-center">
                                                 Total
                                                 Quantity:
                                                 <strong>{{ Quantity }}</strong> </li>
                                             <li
                                                 class="list-group-item d-flex justify-content-between align-items-center">
                                                 Sub Total:
                                                 <strong>{{ SubTotal }}</strong> </li>
                                             <li
                                                 class="list-group-item d-flex justify-content-between align-items-center">
                                                 VAT:
                                                 <strong>{{ vats.vat }}%</strong> </li>
                                             <li
                                                 class="list-group-item d-flex justify-content-between align-items-center">
                                                 Total Amount:
                                                 <strong>{{ SubTotal*vats.vat / 100 + SubTotal }}</strong> </li>
                                         </ul>
                                         <br />
                                        
                                         <form @submit.prevent="processOrder"> 
                                        <label>
                                             Customer Name
                                         </label>
                                         <select class="form-control" v-model="customer_id">
                                             <option v-for="customer in customers" :value="customer.id" :key="customer.id">{{ customer.name }}</option>
                                         </select>  
                                         <label>Pay</label>
                                         <input type="text" class="form-control" required v-model="pay">
                                         <label>Due</label>
                                         <input type="text" class="form-control" required v-model="due">
                                        <label>
                                        Pay By
                                        </label>
                                        <select class="form-control" v-model="pay_by">
                                            <option value="cash">Cash</option>
                                            <option value="online_pay">Online Pay</option>
                                            <option value="cheque">Cheque</option>
                                        </select>
                                        <br />
                                        <button type="submit" class="btn btn-success btn-sm">Submit</button>

                                        </form>

                                    </div>
                          
                    </div>
                </div>
                <!-- Pie Chart -->

                <div class="col-xl-7 col-lg-7">
                    <div class="card mb-4">
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-primary">Products Sold</h6>

                        </div> 

                        <nav>
                            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                <a class="nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home"
                                    role="tab" aria-controls="nav-home" aria-selected="true">All Products</a>
                                <a class="nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile"
                                    role="tab" aria-controls="nav-profile" aria-selected="false"
                                    v-for="category in categories" :key="category.id"
                                    @click="getSubProduct(category.id)">{{ category.category_name }}</a>
                            </div>
                        </nav>
                        <div class="tab-content" id="nav-tabContent">
                            <div class="tab-pane fade show active" id="nav-home" role="tabpanel"
                                aria-labelledby="nav-home-tab">
                            
                                                    <div class="card-body">
                                                        <input type="text" v-model="searchTerm"
                                                            class="form-control mt-2" placeholder="Search product"
                                                            style="width:540px;" />
                                                        <div class="row">
                                                            <div class="col-lg-3 col-md-3 col-xs col-6"
                                                                v-for="product in filterSearch" :key="product.id">
                                                                <div class="row">
                                                                    <button class="btn btn-sm"
                                                                        @click.prevent="addToCart(product.id)">
                                                                        <div class="card"
                                                                            style="width: 8.5rem; margin:5px;">
                                                                            <img class="card-img-top" img
                                                                                :src="product.photo"
                                                                                v-if="product.photo"
                                                                                id="product_photo_pos">
                                                                            <div class="card-body">
                                                                                <h6 class="card-title">
                                                                                    {{ product.product_name }}</h6>
                                                                                <span class="badge badge-success"
                                                                                    v-if="product.product_quantity >= 1">Available
                                                                                    {{ product.product_quantity }}
                                                                                </span></td>

                                                                                <span class="badge badge-danger"
                                                                                    v-else="">Stock out</span>

                                                                            </div>
                                                                        </div>
                                                                </button>
                                                                </div>

                                                            </div>
                                                        </div>


                                                    </div>
                            </div>
                            
                            <div class="tab-pane fade" id="nav-profile" role="tabpanel"
                                aria-labelledby="nav-profile-tab">
                            
                                <div class="card-body">
                            <input type="text" v-model="getsearchTerm" class="form-control mt-2"
                                placeholder="Search product" style="width:540px;" />
                             <div class="row">
                                 <div class="col-lg-3 col-md-3 col-xs col-6" v-for="getproduct in getfilterSearch"
                                     :key="getproduct.id">
                                     <div class="row">
                                         <button class="btn btn-sm" @click.prevent="addToCart(getproduct.id)">
                                             <div class="card" style="width: 8.5rem; margin:5px;">
                                                 <img class="card-img-top" img :src="getproduct.photo"
                                                     v-if="getproduct.photo"
                                                     id="product_photo_pos">
                                                 <div class="card-body">
                                                     <h6 class="card-title">
                                                         {{ getproduct.product_name }}</h6>
                                                     <span class="badge badge-success"
                                                         v-if="getproduct.product_quantity >= 1">Available
                                                         {{ getproduct.product_quantity }}
                                                     </span></td>

                                                     <span class="badge badge-danger" v-else="">Stock out</span>

                                                 </div>
                                             </div>
                                         </button>
                                     </div>

                                 </div>
                             </div>
                            </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
            <!--Row-->


            <!-- Modal Logout -->
            <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog"
                aria-labelledby="exampleModalLabelLogout" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabelLogout">Ohh No!</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p>Are you sure you want to logout?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Cancel</button>
                            <a href="login.html" class="btn btn-primary">Logout</a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!---Container Fluid-->
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
        created() {
            this.getAllProducts();
            this.getAllCategories();
            this.getAllCustomers();
            this.cartProducts();
            this.getVat();
            Reload.$on('AfterAddToCart', () => {
                this.cartProducts();
            })
        },
        data() {
            return {
                products: [],
                categories: '',
                getproducts: [],
                searchTerm: '',
                getsearchTerm: '',
                customers: '',
                error: '',
                carts: [],
                vats: '',
                customer_id: '',
                pay: '',
                due: '',
                pay_by: '',
                response: null,
            }
        },
        computed: {
            filterSearch() {
                return this.products.filter(product => {
                    return product.product_name.match(this.searchTerm)
                })
            },
            getfilterSearch() {
            return this.getproducts.filter(getproduct => {
                return getproduct.product_name.match(this.searchTerm)
            })
            },
            Quantity(){
                let sum = 0
                for(let i = 0; i < this.carts.length; i++) {
                    sum += (parseFloat(this.carts[i].product_quantity))
                }
                return sum
            },
            SubTotal() {
              let sum = 0
              for(let i = 0; i < this.carts.length; i++) { 
                  sum +=(parseFloat(this.carts[i].product_quantity) * parseFloat(this.carts[i].product_price))
                } 
                return sum
            }
        },
        methods: {
            getAllProducts() {
                axios.get('/api/product')
                    .then(({
                        data
                    }) => (this.products = data))
                    .catch()
            },
            getAllCategories() {
            axios.get('/api/category')
            .then(({
            data
            }) => (this.categories = data))
            .catch()
            },
            getAllCustomers() {
                axios.get('/api/customer').then(
                    ({data}) => (this.customers = data)
                ).catch(()=>(console.log('error')))
            },
            getSubProduct(id) {
                () => (console.log(id))
                axios.get('/api/get/subproduct/'+id).then(
                    ({data}) => (this.getproducts = data))
                    .catch()
            },
            addToCart(id) {
                axios.post('/api/addToCart/'+id).then(
                    () => {
                        Reload.$emit('AfterAddToCart');
                        Notification.cart_success()
                    }
                ).catch()
            },
            cartProducts(){
                axios.get('/api/cart/products').then(
                    ({data}) => (this.carts = data)
                ).catch()
            },
            removeItemFromCart(id) {
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
                        axios.delete('/api/cart/delete/'+id).then(
                        () => {
                        Reload.$emit('AfterAddToCart');
                        Notification.cart_delete()
                        }
                        )
                    }
                }).catch()
            },
            incrementCart(id){
                 axios.get('/api/cart/increment/'+id).then(
                  () => {
                  Reload.$emit('AfterAddToCart');
                  Notification.cart_increment()
                  }
                 ).catch()
            },
            decrementCart(id){
                axios.get('/api/cart/decrement/'+id).then(
                () => {
                Reload.$emit('AfterAddToCart');
                Notification.cart_decrement()
                }
                ).catch()
            },
            getVat(){
                axios.get('/api/vats').then(
                    ({data}) => (this.vats = data)
                ).catch()
            },
            processOrder()
            {
               let total = this.SubTotal*this.vats.vat / 100 + this.SubTotal
               var data = { Quantity: this.Quantity, 
                            SubTotal: this.SubTotal, 
                            customer_id: this.customer_id,
                            vat: this.vats.vat,
                            pay: this.pay,
                            due: this.due,
                            pay_by: this.pay_by,
                            total: total
                         }
                 axios.post('/api/process/order', data)
                 .then(() => {
                 Notification.success();
                 this.$router.push({name: 'home'})
                 })
                 .catch(
                 error => this.errors = error.response.data.errors
                 );
            }
        }
    }

</script>

<style type="text/css">
    #product_photo_pos {
        height: 80px;
        width: 130px;
        margin-top: 12px;
        /* border: 1px solid black; */
        /* box-shadow: 1px 1px cyan; */
        /* border-radius: 6px 5px; */
    }

</style>
