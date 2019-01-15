<template>
    <div class="modal-card" style="width: auto">
        <header class="modal-card-head">
            <p class="modal-card-title">Login</p>
        </header>
        <section class="modal-card-body">
            <b-field label="Email">
                <b-input
                        type="email"
                        :value="email"
                        placeholder="Your email">
                </b-input>
            </b-field>

            <b-field label="Password">
                <b-input
                        type="password"
                        :value="password"
                        password-reveal
                        placeholder="Your password">
                </b-input>
            </b-field>

            <b-checkbox>Remember me</b-checkbox>
        </section>
        <footer class="modal-card-foot">
            <button class="button" type="button" @click="$parent.close()">Close</button>
            <button class="button is-primary" @click="addArticle">Save</button>
        </footer>
    </div>
</template>

<script>
    export default {
        props: ['email', 'password']
    }
</script>