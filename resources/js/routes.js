let login = require('./components/auth/LoginComponent.vue').default;
let register = require('./components/auth/RegisterComponent.vue').default;
let forgotPassword = require('./components/auth/ForgotPasswordComponent.vue').default;

export const routes = [
  { path: '/', component: login, name: '/' },
  { path: '/register', component: register, name: 'register' },
  { path: '/forgotpassword', component: forgotPassword, name: 'forgotpassword' },
]