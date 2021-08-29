<template>
    <div>
        <div class="row">
            <div class="form-group col-md-10 text-right">
                <h4 class="text-left">
                    View Film Detail
                </h4>
            </div>
            <div class="form-group col-md-2 text-right">
                <router-link to="/films" class="btn btn-secondary">Back</router-link>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Name:</label>
                    {{ film.name }}
                </div>
                <div class="form-group">
                    <label>Slug:</label>
                    {{ film.slug }}
                </div>
                <div class="form-group">
                    <label>Genre:</label>
                    {{ film.genre }}
                </div>
                <div class="form-group">
                    <label>Country:</label>
                    {{ film.country }}
                </div>
                <div class="form-group">
                    <label>Description:</label>
                    {{ film.description }}
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Release Date:</label>
                    {{ film.release_date }}
                </div>
                <div class="form-group">
                    <label>rating:</label>
                    {{ film.rating }}
                </div>
                <div class="form-group">
                    <label>Ticket Price:</label>
                    {{ film.ticket_price }}
                </div>
                <div class="form-group">
                    <label>Photo:</label>
                    <br/>
                    <img v-if="film.photo != null" v-bind:src="'/'+film.photo" :style="{width: 77 + '%' }">
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            film: {}
        }
    },
    created() {
        this.$axios.get('/sanctum/csrf-cookie').then(response => {
            this.$axios.get(`/api/v1/films/${this.$route.params.slug}`)
                .then(response => {
                    this.film = response.data[0];
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
    },
    computed: {
        imagePath() {
            return `${film.photo}`
        }
    }
}
</script>
