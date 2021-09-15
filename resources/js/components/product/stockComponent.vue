<template lang="en">
    <div>
        <div class="row ml-1">
            <router-link to="/supplier/add" class="btn btn-primary">Add Product</router-link>
        </div>
        <input type="text" v-model="searchTerm" class="form-control mt-2" placeholder="Search Here.."
            style="width:300px;" />
        <div class="row mt-3">
            <div class="col-lg-12 mb-4">
                <!-- Simple Tables -->
                <div class="card">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Stock</h6>
                    </div>
                    <div class="table-responsive">
                        <table class="table align-items-center table-flush">
                            <thead class="thead-light">
                                <tr>
                                    <th>Name</th>
                                    <th>Photo</th>
                                    <th>Code</th>
                                    <th>Category</th>
                                    <th>Buying Price</th>
                                    <th>Status</th>
                                    <th>Quantity</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>

                                <tr v-for="product in filterSearch" :key="product.id">
                                    <td>{{ product.product_name }}</td>
                                    <td><img :src="product.photo" v-if="product.photo" id="product_photo"></td>
                                    <td>{{ product.product_code }}</td>
                                    <td>{{ product.category_name }}</td>
                                    <td>{{ product.buying_price }}</td>
                                    <td v-if="product.product_quantity >= 1">
                                        <span class="badge badge-success">Available</span></td>
                                        <td v-else="">
                                            <span class="badge badge-danger">Stock out</span></td>
                                    <td>{{ product.product_quantity }}</td>
                                    <td class="text-center">
                                        <router-link :to="{ name: 'edit-stock', params:{id: product.id}}"
                                            class="btn btn-sm btn-primary">Edit</router-link>
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
                products: [],
                searchTerm: '',
                response: null,
            }
        },
        computed: {
            filterSearch() {
                return this.products.filter(product => {
                    return product.name.match(this.searchTerm)
                })
            }
        },
        methods: {
            getAllProducts() {
                axios.get('/api/product')
                    .then(({
                        data
                    }) => (this.products = data))
                    .catch()
            }
        },
        // Update employees after adding new employee
        // Created is called as soon as the component loads..
        created() {
            this.getAllProducts();
        },

    }
</script>

<style type="text/css">
    #product_photo {
        height: 60px;
        width: 60px;
        border: 1px solid black;
        box-shadow: 1px 1px cyan;
        border-radius: 6px 5px;
    }
</style>