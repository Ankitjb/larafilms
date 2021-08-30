<template>
    <div class="alert alert-danger" role="alert" v-if="error !== null">
        <div v-for="err in error">
            {{ err[0] }}
        </div>
    </div>
    <div>
        <h4 class="text-left">Add Film</h4>
        <div class="row">
            <div class="col-md-6">
                <form @submit.prevent="addFilm">
                    <div class="form-group mb-3">
                        <label>Name</label>
                        <input type="text" class="form-control" v-model="film.name" placeholder="Enter Name">
                    </div>
                    <div class="form-group mb-3">
                        <label>Description</label>
                        <textarea type="text" class="form-control" v-model="film.description" placeholder="Enter Description"></textarea>
                    </div>
                    <div class="form-group mb-3">
                        <label>Release Date</label>
                        <input type="date" class="form-control" v-model="film.release_date" placeholder="Enter Release Date">
                    </div>
                    <div class="form-group mb-3">
                        <label>Rating</label>
                        <select class='form-control' v-model='film.rating'>
                            <option value=''>Select Rating</option>
                            <option value='1'>Very Poor</option>
                            <option value='2'>Poor</option>
                            <option value='3'>Average</option>
                            <option value='4'>Good</option>
                            <option value='5'>Excellent</option>
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label>Ticket Price</label>
                        <input type="text" class="form-control" v-model="film.ticket_price" placeholder="Enter Ticket Price">
                    </div>
                    <div class="form-group mb-3">
                        <label>Country</label>
                        <select class='form-control' v-model='film.country'>
                            <option value='0' >Select Country</option>
                            <option v-for='data in countries' :value='data.id'>{{ data.name }}</option>
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label>Genre</label>
                        <select class='form-control' multiple v-model='film.genres'>
                            <option value='0' >Select Genres</option>
                            <option v-for='data in genres' :value='data.id'>{{ data.name }}</option>
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label>Photo</label>
                        <input type="file" name="photo" class="form-control-file" id="photo" accept="image/*" @change="onImageChange">
                    </div>
                    <button type="submit" class="btn btn-primary">Add Film</button>
                    <router-link to="/films" class="btn btn-secondary">Cancel</router-link>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            film: {},
            countries: [],
            genres: [],
            photo: null,
            error: null,
        }
    },
    methods: {
        addFilm() {
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
                const data = new FormData();
                if(typeof this.film.name != 'undefined')
                    data.append('name',  this.film.name);
                if(typeof this.film.description != 'undefined')
                    data.append('description',  this.film.description);
                if(typeof this.film.release_date != 'undefined')
                    data.append('release_date',  this.film.release_date);
                if(typeof this.film.rating != 'undefined')
                    data.append('rating',  this.film.rating);
                if(typeof this.film.ticket_price != 'undefined')
                    data.append('ticket_price',  this.film.ticket_price);
                if(typeof this.film.country != 'undefined')
                    data.append('country_id',  this.film.country);
                if(typeof this.film.genres != 'undefined')
                    data.append('genres', this.film.genres);
                if(typeof this.photo != 'undefined')
                    data.append('photo', this.photo);

                this.$axios.post('/api/v1/films', data, {
                        headers : {
                            'Content-Type': 'multipart/form-data'
                        }
                    })
                    .then(response => {
                        if (response.data.success) {
                            this.$router.push({name: 'films'})
                        } else {
                            this.error = response.data.message
                        }
                    })
                    .catch(function (error) {
                        console.error(error);
                    });
            })
        },
        getCountries: function(){
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
                this.$axios.get('/api/v1/getcountries')
                    .then(response => {
                        this.countries = response.data;
                    })
                    .catch(function (error) {
                        console.error(error);
                    });
            })
        },
        getGenres: function(){
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
                this.$axios.get('/api/v1/getgenres')
                    .then(response => {
                        this.genres = response.data;
                    })
                    .catch(function (error) {
                        console.error(error);
                    });
            })
        },
        onImageChange(e) {
            this.photo = e.target.files[0];
        }
    },
    beforeRouteEnter(to, from, next) {
        if (!window.Laravel.isLoggedin) {
            window.location.href = "/";
        }
        next();
    },
    created() {
        this.getCountries();
        this.getGenres();
    }
}
</script>
