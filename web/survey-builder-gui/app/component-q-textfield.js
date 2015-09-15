module.exports = {
    template: require('./component-q-textfield.html'),

    props: ['q', 'position'],

    data: function () {
        return {}
    },
    methods: {
        remove: function () {
            this.$dispatch('removeQuestion', this.q, this.position);
        }
    }
}
