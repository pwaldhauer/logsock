import WebAuthn from "../vendor/webauthn/webauthn";

export default () => ({

    async login (home) {
        new WebAuthn().login({}, {
            remember: 'on',
        }).then(response => {
            location.href = home;
        })
            .catch(error => alert('Something went wrong, try again!'))
    },

    async create () {
        new WebAuthn().register()
            .then(response => alert('Registration successful!'))
            .catch(error => alert('Something went wrong, try again!'))
    }

})
