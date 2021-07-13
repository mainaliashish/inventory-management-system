class AppStorage {
    // Set Token to Local Storage
    storeToken(token) {
        localStorage.setItem("token", token);
    }

    // Set Token to Local Storage
    storeUser(user) {
        localStorage.setItem("user", user);
    }

    // Store Tokens, User in local storage
    store(token, user) {
        this.storeToken(token);
        this.storeUser(user);
    }


    // clear Token, User from local storage
    clear() {
        localStorage.removeItem("token");
        localStorage.removeItem("user");
    }

    // get Token
    getToken()
    {
        localStorage.getItem('token')
    }

    // get User
    getUser()
    {
        localStorage.getItem('user')
    }
}

export default AppStorage = new AppStorage();