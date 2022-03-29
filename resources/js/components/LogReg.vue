<template>
    <div class="form">
        <form @submit.prevent="loginForm" v-if="logreg==='/login'">
            <h1>Logowanie</h1>
            <input type="text" name="login" v-model="login">
            <input type="password" name="password" v-model="password">
            <input type="submit" value="Zaloguj">
            <p style="color: red" v-if="error===1">Konto nie istnieje</p>
            <p style="color: red" v-if="error===2">Błędny login lub hasło</p>
        </form>
        <form @submit.prevent="registerForm" v-if="logreg==='/register'">
            <h1>Rejestracja</h1>
            <input type="text" name="login" v-model="login">
            <input type="email" name="email" v-model="email">
            <input type="password" name="password" v-model="password">
            <input type="submit" value="Zarejestruj">
        </form>
    </div>
</template>

<script>
export default {
    name: "LogReg",
    data: function () {
        return {
            error: 0,
            success: 0,
            logreg: '/register',
            email: '',
            password: '',
            csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    },
    mounted() {
        // this.checkIfLogged();
        var currentUrl = window.location.pathname;
        this.logreg = currentUrl;
    
    },
    methods: {
        async loginForm() {
            const res = await fetch('/api/loginCheck', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json'},
                body: JSON.stringify({
                    login: this.login,
                    password: this.password,
                    token: this.csrf
                })
            })
            const data = await res.json();
            this.error = data.error;
            this.success = data.success;
            if(this.success===1){
                window.location.href = "/"+data.username;
            }
        },
        checkIfLogged: function (){
            axios.post('/api/checkLogged', {
                'token': this.csrf
            })
                .then((response) => {
                    if(response.data.success==1){
                        window.location.href = "/"+data.username;
                    }
                })
                .catch(function (error) {
                    console.log(error);
                });
        },
        async registerForm() {
            const res = await fetch('/api/registerCheck', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json'},
                body: JSON.stringify({
                    login: this.login,
                    email: this.email,
                    password: this.password,
                    token: this.csrf
                })
            })
            const data = await res.json();
            this.error = data.error;
            this.success = data.success;
            if(this.success===1){
                // window.location.href = "/account";
            }
        }
    }
}
</script>
