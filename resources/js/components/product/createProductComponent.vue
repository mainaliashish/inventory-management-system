<template lang="en">
    <div>
      <div class="row">
        <router-link to="/products" class="btn btn-primary">All Products</router-link>

      </div>
      <div class="row justify-content-center">
      <div class="col-xl-12 col-lg-12 col-md-12">
        <div class="card shadow-sm my-5">
          <div class="card-body p-0">
            <div class="row">
              <div class="col-lg-12">
                <div class="login-form">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Add Product</h1>
                  </div>
                  <form class="user" @submit.prevent="handleProductCreate" enctype="multipart/form-data">
                   
                    <div class="form-group">

                      <div class="form-group">
                      <div class="form-row">
                        <div class="col-md-6">
                          <label for="exampleFormControlSelect1"><b>Product Name</b></label>
                          <input type="text" v-model="form.product_name" class="form-control" id="inputName" placeholder="Enter Product name">
                          <small class="text-danger" v-if="errors.product_name">{{ errors.product_name[0] }}</small>

                        </div>
                        <div class="col-md-6">
                          <label for="exampleFormControlSelect1"><b>Product Code</b></label>
                          <input type="text" v-model="form.product_code" class="form-control" id="inputProductCode" placeholder="Enter Product code">
                          <small class="text-danger" v-if="errors.product_code">{{ errors.product_code[0] }}</small>
                        
                        </div> 
                      </div>
                      </div>

                      <div class="form-group">
                      <div class="form-row">
                        <div class="col-md-6">
                      <label for="exampleFormControlSelect1"><b>Select category</b></label>
                      <select class="form-control" id="exampleFormControlSelect1" v-model="form.category_id">
                        <option :value="category.id" v-for="category in categories" :key="category.id">{{ category.category_name }}</option>
                      </select>
                        </div> 

                        
                        <div class="col-md-6">
                      <label for="exampleFormControlSelect1"><b>Select Supplier</b></label>
                      <select class="form-control" id="exampleFormControlSelect1" v-model="form.supplier_id">
                        <option :value="supplier.id" v-for="supplier in suppliers" :key="supplier.id">{{ supplier.name }}</option>
                      </select>
                        
                        </div>
                        
                      </div>
                    </div>
                    </div>


                      <div class="form-group">
                      <div class="form-row">
                        <div class="col-md-4">
                          <label for="exampleFormControlSelect1"><b>Product Root</b></label>
                          <input type="text" v-model="form.root" class="form-control" id="inputRoot" placeholder="Enter Product root">
                          <small class="text-danger" v-if="errors.root">{{ errors.root[0] }}</small>

                        </div>
                        <div class="col-md-4">
                          <label for="exampleFormControlSelect1"><b>Buying Price</b></label>
                          <input type="text" v-model="form.buying_price" class="form-control" id="inputBuyingPrice" placeholder="Enter Product buying price">
                          <small class="text-danger" v-if="errors.buying_price">{{ errors.buying_price[0] }}</small>
                        
                        </div> 
                        <div class="col-md-4">
                          <label for="exampleFormControlSelect1"><b>Selling Price</b></label>
                          <input type="text" v-model="form.selling_price" class="form-control" id="inputSellingPrice" placeholder="Enter Product selling price">
                          <small class="text-danger" v-if="errors.selling_price">{{ errors.selling_price[0] }}</small>
                        
                        </div> 
                      </div>
                      </div>

                    <div class="form-group">
                      <div class="form-row">
                        <div class="col-md-6">
                          <label for="exampleFormControlSelect1"><b>Buying Date</b></label>
                          <input type="date" v-model="form.buying_date" class="form-control" id="inputbuying_date" placeholder="Enter Product buying date">
                    <small class="text-danger" v-if="errors.buying_date">{{ errors.buying_date[0] }}</small>
                        
                        </div>
                        <div class="col-md-6">
                          <label for="exampleFormControlSelect1"><b>Product Quantity</b></label>

                          <input type="text" v-model="form.product_quantity" class="form-control" id="inputproduct_quantity" placeholder="Enter Product quantity">
                    <small class="text-danger" v-if="errors.product_quantity">{{ errors.product_quantity[0] }}</small>
                        
                        </div>
                      </div>
                     
                  
                    </div>

                    <div class="form-group">
                        <label for="exampleFormControlSelect1"><b>Product Image</b></label>

                      <div class="form-row ml-1">
                      <div class="col-md-6">
                      <input type="file" class="custom-file-input" id="customFile" @change="onImageUpload">
                    <small class="text-danger" v-if="errors.photo">{{ errors.photo[0] }}</small>
                      <label class="custom-file-label" for="customFile">Choose file</label>

                    </div>
                      <div class="col-md-6">
                          <img v-if="form.photo" :src="form.photo" style="height: 50px; width: 90px;">
                        </div>
                    </div>
                    </div>

                    <div class="form-group">
                      <button type="submit" class="btn btn-primary">Add Product</button>
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
        'category_id' : null,
        'product_name' : null,
        'product_code' : null,
        'root' : null,
        'buying_price': null,
        'selling_price' : null,
        'supplier_id' : null,
        'buying_date' : null,
        'photo' : null,
        'product_quantity' : null
      },
      errors: {},
      categories: {},
      suppliers: {},
    }
  },
  methods: {
    // Show Image Preview
    onImageUpload(event) {
        let file = event.target.files[0];
        if (file.size > 1048770) {
          Notification.image_validation();
        } else {
          let reader = new FileReader();
          reader.onload = event => {
            this.form.photo = event.target.result;
            // console.log(event.target.result);
          };
          reader.readAsDataURL(file);
        }
        
    },
    handleProductCreate() {
        // console.log(this.form);
        axios.post('/api/product', this.form)
        .then(() => {
          this.$router.push({ name: 'products'})
          Notification.success();
        })
        .catch(
          error => this.errors = error.response.data.errors
        );
    },
  },
  created() {
    axios.get('/api/category/')
    .then(({data}) => this.categories = data)

    axios.get('/api/supplier/')
    .then(({data}) => (this.suppliers = data))
  }
}
</script>

<style lang="en">
    
</style>