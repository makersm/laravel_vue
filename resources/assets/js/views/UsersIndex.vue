<template>
    <div class="users">
        <div v-if="error" class="error">
            {{ error }}

            <p>
                <button @click.prevent = "fetchData">
                    Try Again
                </button>
            </p>
        </div>

        <ul v-if="users">
            <user-item v-for="item in users" :item="item" :key="item.id" @refresh="fetchData"></user-item>
        </ul>

        <div class="pagination">
            <button :disabled="! prevPage" @click.prevent="goToPrev">Previous</button>
            {{ paginatonCount }}
            <button :disabled="! nextPage" @click.prevent="goToNext">Next</button>
        </div>
    </div>
</template>
<script>
    import axios from 'axios';

    const getUsers = (page, callback) => {
        const params = { page };

        axios.get('/api/users', { params })
            .then(response => {
                callback(null, response.data);
            }).catch(error => {
                callback(error, error.response.data);
            });
    }
    export default {
        data() {
            return {
                users: null,
                meta: null,
                links: {
                    first: null,
                    last: null,
                    next: null,
                    prev: null,
                },
                error: null,
            };
        },
        computed: {
            nextPage() {
                if (!this.meta || this.meta.current_page === this.meta.last_page) return;
                return this.meta.current_page + 1;
            },
            prevPage() {
                if (!this.meta || this.meta.current_page === 1) return;
                return this.meta.current_page - 1;
            },
            paginatonCount: {
                get: function() {
                    if (!this.meta) return;

                    const { current_page, last_page } = this.meta;
                    return `${current_page} of ${last_page}`;
                },
                set: function() {}
            },
        },
        beforeRouteEnter(to, from, next) {
            const params = {
                page: to.query.page
            }

            getUsers(to.query.page, (err, data) => {
                next(vm => vm.setData(err, data))
            })
        },
        beforeRouteUpdate(to, from, next) {
            this.users = this.links = this.meta = null;
            getUsers(to.query.page, (err, data) => {
                this.setData(err, data);
                next();
            })
        },

        methods: {
            setData(err, { data: users, links, meta }) {
                if(err) {
                    this.error = err.toString();
                } else {
                    this.users = users;
                    this.links = links;
                    this.meta = meta;
                }

            },
            goToNext() {
                this.$router.push({
                    query: {
                        page: this.nextPage,
                    },
                });
            },
            goToPrev() {
                this.$router.push({
                    name: 'users.index',
                    query: {
                        page: this.prevPage,
                    }
                });
            },
            paginatonCount() {
                if (! this.meta) {
                    return;
                }
                const { current_page, last_page } = this.meta;
                return `${current_page} of ${last_page}`;
            },
            fetchData() {
                this.error = this.users = null;
                const page = this.$route.query.page;
                const params = { page } ;
                this.$axios
                    .get('/api/users', { params })
                    .then(response => {
                        this.users = response.data.data;
                    })
                    .catch(error => {
                        this.error = error.response.data.message || error.message;
                    })
            },
        }
    }
</script>