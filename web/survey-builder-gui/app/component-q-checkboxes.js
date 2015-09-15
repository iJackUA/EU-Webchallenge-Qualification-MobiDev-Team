var g = require('./global');

module.exports = {
    template: require('./component-q-checkboxes.html'),

    props: ['q'],

    data: function () {
        return {}
    },
    methods: {
        addOption: function () {
            var radio = {
                id: g.makeUUID(),
                text: 'New Checkbox label #' + (this.q.meta.options.length + 1)
            };
            this.q.meta.options.push(radio);
        },
        removeOption: function (option) {
            this.q.meta.options = _.reject(this.q.meta.options, 'id', option.id);
        }
    }
}

