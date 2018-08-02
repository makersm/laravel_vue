<template>
    <div>
        <p>
            <router-link :to="{ name: 'home' }">Home</router-link> |
            <router-link :to="{ name: 'hello' }">Hello world</router-link> |
            <router-link :to="{ name: 'users.index' }">Users</router-link> |
            <router-link :to="{ name: 'users.add' }">New Users</router-link>
        </p>

        <div class="container">
            <router-view></router-view>
        </div>
    </div>
</template>
<script>
    export default {}
</script>