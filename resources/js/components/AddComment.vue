<template>
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
</template>

<script>
export default {
    data() {
        return {
            comment: {},
        }
    },
    methods: {
        addComment() {
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
                this.$axios.post('/api/v1/comments', this.film)
                    .then(response => {
                        this.$router.push({name: 'comment'})
                    })
                    .catch(function (error) {
                        console.error(error);
                    });
            })
        },
    },
    beforeRouteEnter(to, from, next) {
        if (!window.Laravel.isLoggedin) {
            window.location.href = "/";
        }
        next();
    }
}
</script>
