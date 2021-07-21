<template lang="en">
    <div>
            <div class="row justify-content-center">
      <div class="col-xl-10 col-lg-12 col-md-9">
        <div class="card shadow-sm my-5">
          <div class="card-body p-0">
            <div class="row">
              <div class="col-lg-12">
                <div class="login-form">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Register</h1>
                  </div>
                  <form class="user" @submit.prevent="handleRegister">
                    <div class="form-group">
                      <input type="text" v-model="form.name" class="form-control" id="exampleInputFirstName" placeholder="Enter Your full name">
                    <small class="text-danger" v-if="errors.name">{{ errors.name[0] }}</small>
                    
                    </div>
                    <div class="form-group">
                      <input type="email" v-model="form.email" class="form-control" id="exampleInputEmail" aria-describedby="emailHelp"
                        placeholder="Enter Email Address">
                    <small class="text-danger" v-if="errors.email">{{ errors.email[0] }}</small>
                    
                    </div>
                    <div class="form-group">
                      <input type="password" v-model="form.password" class="form-control" id="exampleInputPassword" placeholder="Password">
                    <small class="text-danger" v-if="errors.password">{{ errors.password[0] }}</small>
                    
                    </div>
                    <div class="form-group">
                      <input type="password" v-model="form.password_confirmation" class="form-control" id="exampleInputPasswordRepeat"
                        placeholder="Confirm Password">
                      <small class="text-danger" v-if="errors.password_confirmation">{{ errors.confirm_password[0] }}</small>
                    </div>
                    <div class="form-group">
                      <button type="submit" class="btn btn-primary">Register</button>
                    </div>
                    <hr>
                  </form>
                  <div class="">
                    <router-link to="/">Already have an account?</router-link>
                  </div>
                  <div class="text-center">
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
    if(User.loggedIn()){
      this.$router.push({ name: 'home' })
    }
  },
  data(){
    return {
      form: {
        email: null,
        name: null,
        password: null,
        password_confirmation: null
      },
      errors: {

      }
    }
  },
  methods: {
    handleRegister() {
      axios.post('/api/auth/signup', this.form)
      .then(response => {
        User.responseAfterLogin(response)
        Toast.fire({
          icon: 'success',
          title: 'Signed in successfully'
        })
        this.$router.push({ name: 'home' })
      })
      .catch(error => this.errors = error.response.data.errors)
    }
  },
}
</script>

<style lang="en">
    
</style>