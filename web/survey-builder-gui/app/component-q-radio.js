var g = require('./global');

module.exports = {
    template: require('./component-q-radio.html'),

    props: ['q', 'position'],

    data: function () {
        return {}
    },
    methods: {
        addOption: function () {
            var radio = {
                id: g.makeUUID(),
                text: 'New Radio button label #' + (this.q.meta.options.length + 1)
            };
            this.q.meta.options.push(radio);
        },
        removeOption: function (option) {
            this.q.meta.options = _.reject(this.q.meta.options, 'id', option.id);
        },
        remove: function () {
            this.$dispatch('removeQuestion', this.q, this.position);
        }
    }
};

