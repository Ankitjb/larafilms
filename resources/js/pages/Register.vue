<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <div class="alert alert-danger" role="alert" v-if="error !== null">
                    <div v-for="err in error">
                        {{ err[0] }}
                    </div>
                </div>

                <div class="card card-default">
                    <div class="card-header">Register</div>
                    <div class="card-body">
                        <form>
                            <div class="form-group row  mb-3">
                                <label for="name" class="col-sm-4 col-form-label text-md-right">Name</label>
                                <div class="col-md-6">
                                    <input id="name" type="email" class="form-control" v-model="name" autofocus autocomplete="off">
                                </div>
                            </div>

                            <div class="form-group row  mb-3">
                                <label for="email" class="col-sm-4 col-form-label text-md-right">E-Mail</label>
                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control" v-model="email" autofocus autocomplete="off">
                                </div>
                            </div>

                            <div class="form-group row  mb-3">
                                <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>
                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control" v-model="password" autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group  row  mb-3">
                                <label for="password_confirmation" class="col-md-4 control-label">Confirm Password</label>

                                <div class="col-md-6">
                                    <input id="password_confirmation" type="password" class="form-control"  v-model="password_confirmation" autocomplete="off">
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary text-white" @click="handleSubmit">
                                        Register
                                    </button>
                                    <router-link to="/login" class="offset-md-1 link-secondary m-t-5"><strong>Login</strong></router-link>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            name: "",
            email: "",
            password: "",
            password_confirmation: "",
            error: null
        }
    },
    methods: {
        handleSubmit(e) {
            e.preventDefault()
            if (this.password.length > 0) {
                axios.get('/sanctum/csrf-cookie').then(response => {
                    axios.post('api/v1/register', {
                        name: this.name,
                        email: this.email,
                        password: this.password,
                        password_confirmation: this.password_confirmation
                    })
                        .then(response => {
                            if (response.data.success) {
                                window.location.href = "/login"
                            } else {
                                this.error = response.data.message
                            }
                        })
                        .catch(function (error) {
                            console.error(error);
                        });
                })
            }else{
                this.error = [{ 0:'Name, E-Mail, Password and Confirm-Password fields required'}]
            }
        }
    },
    beforeRouteEnter(to, from, next) {
        if (window.Laravel.isLoggedin) {
            return next('dashboard');
        }
        next();
    }
}
</script>
