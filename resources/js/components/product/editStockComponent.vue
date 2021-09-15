<template lang="en">
    <div>
        <div class="row">
            <router-link to="/stock" class="btn btn-primary">All Stock</router-link>

        </div>
        <div class="row justify-content-center">
            <div class="col-xl-12 col-lg-12 col-md-12">
                <div class="card shadow-sm my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="login-form">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Stock Update</h1>
                                    </div>
                                    <form class="user" @submit.prevent="handleStockUpdate">

                                        <div class="form-group">
                                               
                                        <label for="exampleFormControlSelect1"><b>Product
                                                Quantity</b></label>

                                        <input type="text" v-model="form.product_quantity"
                                            class="form-control" id="inputproduct_quantity"
                                            placeholder="Enter Product quantity">
                                        <small class="text-danger"
                                            v-if="errors.product_quantity">{{ errors.product_quantity[0] }}</small>

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
        created() {
            console.log(form.photo);
            if (!User.loggedIn()) {
                this.$router.push({
                    name: '/'
                })
            }
        },
        data() {
            return {
                form: {
                    product_quantity: ''
                },
                errors: {},
            }
        },
        created() {
            let id = this.$route.params.id
            axios.get('/api/product/' + id)
                .then(({
                    data
                }) => (this.form = data))
                .catch(({
                    error
                }) => (console.log(error)))
        },
        methods: {
            handleStockUpdate() {
                let id = this.$route.params.id
                axios.put('/api/stock/update/' + id, this.form)
                    .then(() => {
                        this.$router.push({
                            name: 'stock'
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