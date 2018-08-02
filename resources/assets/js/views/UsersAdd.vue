<template>
    <div class="users">
        <div class="loading" v-if="loading">
            Loading...
        </div>

        <div v-if="error" class="error">
            {{ error }}

        </div>

        <div>
            <input type="text" v-model="name" value="" placeholder="name">
            <input type="email" v-model="email" value="" placeholder="email">
            <button @click.prevet = "addUser">Add</button>
        </div>
    </div>
</template>
<script>
    export default {
        data() {
            return {
                name: null,
                email: null,
                error: null,
                loading: false,
            };
        },
        computed: {},
        methods: {
            addUser() {
                this.loading = true;
                this.$axios.post('/api/users', {
                    name: this.name,
                    email: this.email,
                }).then(response => {
                        console.log(response.data);
                        if(response.data.indexOf('error') > 0) {
                            this.loading = false;
                            return alert(response.data);
                        }

                        location.href = '/users';
                        this.loading = false;
                    })
                    .catch(error => {
                        this.loading = false;
                        this.error = error.response.data.message || error.message;
                    });
            },
        }
    }
</script>