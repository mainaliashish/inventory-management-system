let login = require('./components/auth/LoginComponent.vue').default;
let register = require('./components/auth/RegisterComponent.vue').default;
let forgotPassword = require("./components/auth/ForgotPasswordComponent.vue")
    .default;
let logout = require("./components/auth/LogoutComponent.vue")
    .default;
let home = require("./components/HomeComponent.vue")
    .default;
let addEmployee = require('./components/employee/createEmployeeComponent.vue').default;
let employees = require('./components/employee/indexComponent.vue').default;
let editEmployee = require('./components/employee/editEmployeeComponent.vue').default;

export const routes = [
           { path: "/", component: login, name: "/" },
           { path: "/register", component: register, name: "register" },
           {
               path: "/forgotpassword",
               component: forgotPassword,
               name: "forgotpassword"
           },
           {
               path: "/logout",
               component: logout,
               name: "logout"
           },
           {
               path: "/home",
               component: home,
               name: "home"
           },
           {
               path: "/employee/add",
               component: addEmployee,
               name: "add-employee"
           },
           {
               path: "/employees",
               component: employees,
               name: "employees"
           },
           {
               path: "/employee/edit/:id",
               component: editEmployee,
               name: "edit-employee"
           }

       ];