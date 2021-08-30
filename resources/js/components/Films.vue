<template>
    <div>
        <div class="row">
            <div class="col-md-11">
                <h4 class="text-left">Films Listing</h4>
            </div>
            <div class="col-md-1 mb-3">
                <button type="button" class="btn btn-info" @click="this.$router.push('/films/add')">Add Film</button>
            </div>
        </div>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Release Date</th>
                <th>Ticket Price</th>
                <th>Country</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="film in films" :key="film.id">
                <td>{{ film.id }}</td>
                <td>{{ film.name }}</td>
                <td>{{ film.release_date }}</td>
                <td>{{ film.ticket_price }}</td>
                <td>{{ film.country }}</td>
                <td>
                    <div class="btn-group" role="group">
                        <router-link :to="{name: 'viewfilm', params: { slug: film.slug }}" class="btn btn-primary">View</router-link>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
export default {
    data() {
        return {
            films: []
        }
    },
    created() {
        this.$axios.get('/sanctum/csrf-cookie').then(response => {
            this.$axios.get('/api/v1/films')
                .then(response => {
                    this.films = response.data;
                })
                .catch(function (error) {
                    console.error(error);
                });
        })
    },
    methods: {

    },
    beforeRouteEnter(to, from, next) {
        if (!window.Laravel.isLoggedin) {
            window.location.href = "/";
        }
        next();
    }
}
</script>
