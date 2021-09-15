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


let addSupplier = require("./components/supplier/createSupplierComponent.vue")
    .default;
let suppliers = require("./components/supplier/indexComponent.vue").default;
let editSupplier = require("./components/supplier/editSupplierComponent.vue")
    .default;

let addCategory = require("./components/category/createCategoryComponent.vue")
    .default;
let categories = require("./components/category/indexComponent.vue").default;
let editCategory = require("./components/category/editCategoryComponent.vue")
    .default;


let addProduct = require("./components/product/createProductComponent.vue")
    .default;
let products = require("./components/product/indexComponent.vue").default;
let editProduct = require("./components/product/editProductComponent.vue")
    .default;


let addExpense = require("./components/expense/createExpenseComponent.vue")
    .default;
let expenses = require("./components/expense/indexComponent.vue").default;
let editExpense = require("./components/expense/editExpenseComponent.vue")
    .default;

let paySalary = require("./components/salary/allEmployeeComponent.vue").default;
let giveSalary = require("./components/salary/createSalaryComponent.vue").default
let salaries = require("./components/salary/indexComponent.vue").default;
let editSalary = require("./components/salary/editSalaryComponent.vue")
    .default;
let viewSalary = require("./components/salary/viewSalaryComponent.vue").default;

let stock = require("./components/product/stockComponent.vue").default;
let editStock = require("./components/product/editStockComponent.vue").default;


let addCustomer = require("./components/customer/createCustomerComponent.vue")
    .default;
let customers = require("./components/customer/indexComponent.vue").default;
let editCustomer = require("./components/customer/editCustomerComponent.vue")
    .default;

let pos = require("./components/pos/pointofsaleComponent.vue").default;


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
           },
           {
               path: "/supplier/add",
               component: addSupplier,
               name: "add-supplier"
           },
           {
               path: "/suppliers",
               component: suppliers,
               name: "suppliers"
           },
           {
               path: "/supplier/edit/:id",
               component: editSupplier,
               name: "edit-supplier"
           },
           {
               path: "/category/add",
               component: addCategory,
               name: "add-category"
           },
           {
               path: "/categories",
               component: categories,
               name: "categories"
           },
           {
               path: "/category/edit/:id",
               component: editCategory,
               name: "edit-category"
           },
           {
               path: "/product/add",
               component: addProduct,
               name: "add-product"
           },
           {
               path: "/products",
               component: products,
               name: "products"
           },
           {
               path: "/product/edit/:id",
               component: editProduct,
               name: "edit-product"
           },
           {
               path: "/expense/add",
               component: addExpense,
               name: "add-expense"
           },
           {
               path: "/expenses",
               component: expenses,
               name: "expenses"
           },
           {
               path: "/expense/edit/:id",
               component: editExpense,
               name: "edit-expense"
           },
           {
               path: "/salary/give/:id",
               component: giveSalary,
               name: "give-salary"
           },
           {
               path: "/salary-pay",
               component: paySalary,
               name: "salary-pay"
           },
           {
               path: "/salaries",
               component: salaries,
               name: "salaries"
           },
           {
               path: "/salary/view/:id",
               component: viewSalary,
               name: "view-salary"
           },
           {
               path: "/salary/edit/:id",
               component: editSalary,
               name: "edit-salary"
           },
           {
               path: "/stock",
               component: stock,
               name: "stock"
           },
           {
               path: "/stock/edit/:id",
               component: editStock,
               name: "edit-stock"
           },
           ,
           {
               path: "/customer/add",
               component: addCustomer,
               name: "add-customer"
           },
           {
               path: "/customers",
               component: customers,
               name: "customers"
           },
           {
               path: "/customer/edit/:id",
               component: editCustomer,
               name: "edit-customer"
           },
           {
               path: "/pos",
               component: pos,
               name: "pos"
           }
       ];