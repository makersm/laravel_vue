<template>
    <li>
        <strong @click = "show_user(item)">Name:</strong> <input type="text" v-model="name" v-if="input"><span v-else>{{ item.name }}</span>
        <strong @click = "show_user(item)">Email:</strong> <input type="email" v-model="email" v-if="input"><span v-else>{{ item.email }}</span>
        <button v-if="edit" @click.prevent="edit_user">{{ !input ? 'edit' : 'cancel' }}</button>
        <button v-if="edit" @click.prevent="delete_user(item.id)">delete</button>
        <button v-if="input" @click.prevent="update_user(item.id)">enter</button>
    </li>
</template>
<script>
    export default {
        props: ['item'],
        data() {
            return {
                edit: false,
                input: false,
                selectUser: null,

                name: null,
                email: null
            }
        },
        methods: {
            show_user(user) {
                this.name = user.name;
                this.email = user.email;

                if(this.edit) this.input = false;
                this.edit = !this.edit;
            },
            edit_user() {
                this.input = !this.input;
            },
            delete_user(id) {
                this.$axios.post('/api/users', { id: id, _method:'delete' })
                    .then(response => {
                        this.$emit('refresh', 'delete');
                    }).catch(error => {
                        this.error = error.response.data.message || error.message;
                    });
            },
            update_user(id) {
                this.$axios.post('/api/users', { id: id, name: this.name, email: this.email, _method:'put' })
                    .then(response => {
                        this.$emit('refresh', 'update');
                    }).catch(error => {
                    this.error = error.response.data.message || error.message;
                });
            },
        }
    }
</script>