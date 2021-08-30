<template>
    <div class="alert alert-danger" role="alert" v-if="error !== null">
        <div v-for="err in error">
            {{ err[0] }}
        </div>
    </div>
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
        <div class="row">
            <div class="col-md-11">
                <h4 class="text-left">Related Comment</h4>
            </div>
        </div>
        <div class="table" v-for="comment in comments" :key="comment.id">
            <div class="form-group">
                <label>Added By: </label>{{ comment.added_by }}<br/>
                <label>Comment: </label>{{ comment.comment }}
            </div>
        </div>
        <div>
            <h4 class="text-left">Add Comment</h4>
            <div class="row">
                <div class="col-md-6">
                    <form @submit.prevent="addComment">
                        <div class="form-group mb-3">
                            <label>Comment</label>
                            <textarea type="text" class="form-control" v-model="comment.comment" placeholder="Enter Description"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Save</button>
                        <router-link to="/films" class="btn btn-secondary">Cancel</router-link>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            film: {},
            comments: {},
            comment: {},
            error: null,
        }
    },
    created() {
        this.showFilm();
    },
    methods: {
        showFilm() {
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
                this.$axios.get(`/api/v1/films/${this.$route.params.slug}`)
                    .then(response => {
                        this.film = response.data;
                        this.comments = response.data.comments;
                    })
                    .catch(function (error) {
                        console.error(error);
                    });
            })
        },
        addComment() {
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
                this.$axios.post(`/api/v1/comments/${this.$route.params.slug}`, this.comment)
                    .then(response => {
                        if (response.data.success) {
                            this.showFilm();
                            this.comment = {}
                            this.error = null
                        } else {
                            this.error = response.data.message
                        }
                    })
                    .catch(function (error) {
                        console.error(error);
                    });
            })
        }
    },
    beforeRouteEnter(to, from, next) {
        if (!window.Laravel.isLoggedin) {
            window.location.href = "/";
        }
        next();
    }
}
</script>
