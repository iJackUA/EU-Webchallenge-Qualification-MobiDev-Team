var Vue = require('../vendor/vue');
Vue.config.debug = true;
//Vue.use(require('../vendor/vue-resource'));

var SurveyBuilderApp = new Vue({
    el: '#survey-builder',
    data: {
        questions: [
            {
                title: 'Q TEXT',
                pos: 1,
                required: true,
                type: 'textfield',
                meta: {
                    placeholder: 'Some default placeholder'
                }
            },
            {
                title: 'Q SLIDER',
                pos: 1,
                required: true,
                type: 'slider',
                meta: {
                    from: 10,
                    to: 150,
                    default: 56
                }
            }
        ]
    },
    components: {
        'builder-q-radio': require('./component-q-radio'),
        'builder-q-checkboxes': require('./component-q-checkboxes'),
        'builder-q-textfield': require('./component-q-textfield'),
        'builder-q-slider': require('./component-q-slider')
    },
    methods: {
        defaultQuestion: function () {
            return {
                title: 'Question title',
                pos: 1,
                required: false,
                type: 'unknown',
                meta: {}
            };
        },
        addRadio: function () {
            var q = _.merge(
                this.defaultQuestion,
                {
                    type: 'radio',
                    meta: {
                        options: [
                            {
                                text: 'Radio button #1'
                            },
                            {
                                text: 'Radio button #2'
                            }
                        ]
                    }
                });
            return this.addQuestion(q);
        },
        addCheckboxes: function () {
            var q = _.merge(
                this.defaultQuestion,
                {
                    type: 'checkboxes',
                    meta: {
                        options: [
                            {
                                text: 'Checkbox #1'
                            }
                        ]
                    }
                });
            return this.addQuestion(q);
        },
        addTextfield: function () {
            var q = _.merge(
                this.defaultQuestion,
                {
                    type: 'textfield',
                    meta: {
                        placeholder: 'Some placeholder text'
                    }
                });
            return this.addQuestion(q);
        },
        addSlider: function () {
            var q = _.merge(
                this.defaultQuestion,
                {
                    type: 'slider',
                    meta: {
                        from: 1,
                        to: 10,
                        default: 5
                    }
                });
            return this.addQuestion(q);
        },
        addQuestion: function (q) {
            this.questions.push(q);
        },
    }
});
