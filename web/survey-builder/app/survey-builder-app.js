var g = require('./global');
var Vue = require('../vendor/vue');
Vue.config.debug = true;
Vue.use(require('../vendor/vue-resource.min'));
Vue.http.headers.common['X-CSRF-Token'] = $('meta[name=csrf-token]').attr('content');


var SurveyBuilderApp = new Vue({
    el: '#survey-builder',
    data: {
        title: 'My new survey',
        desc: 'Survey description...',
        emails: null,
        startDate: null,
        expireDate: null,
        questions: []
    },
    ready: function () {
        this.$on('removeQuestion', this.removeQuestion);

        if (window.gon.survey) {
            this.$set('$data', _.clone(window.gon.survey, true));
        }
    },
    components: {
        'builder-q-radio': require('./component-q-radio'),
        'builder-q-checkboxes': require('./component-q-checkboxes'),
        'builder-q-textfield': require('./component-q-textfield'),
        'builder-q-slider': require('./component-q-slider')
    },
    computed: {
        questionsExists: function () {
            return !_.isEmpty(this.questions);
        }
    },
    methods: {
        defaultQuestion: function () {
            return {
                uuid: g.makeUUID(),
                title: 'Question title',
                position: 1,
                required: false,
                type: 'unknown',
                meta: {}
            };
        },
        addRadio: function () {
            var q = _.merge(
                this.defaultQuestion(),
                {
                    type: 'radio',
                    meta: {
                        options: [
                            {
                                id: g.makeUUID(),
                                text: 'Radio button #1'
                            },
                            {
                                id: g.makeUUID(),
                                text: 'Radio button #2'
                            }
                        ]
                    }
                });
            return this.addQuestion(q);
        },
        addCheckboxes: function () {
            var q = _.merge(
                this.defaultQuestion(),
                {
                    type: 'checkboxes',
                    meta: {
                        options: [
                            {
                                id: g.makeUUID(),
                                text: 'Checkbox #1'
                            }
                        ]
                    }
                });
            return this.addQuestion(q);
        },
        addTextfield: function () {
            var q = _.merge(
                this.defaultQuestion(),
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
                this.defaultQuestion(),
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
        removeQuestion: function (q, index) {
            this.questions.$remove(index);
        },
        saveSurvey: function () {
            this.$http.post(window.gon.saveSurveyUrl, JSON.stringify(this.$data),
                function (data, status, request) {
                    window.location.href = window.gon.afterSaveSurveyRedirectUrl;
                }).error(function (data, status, request) {
                alert('Error');
                console.log(data, status);
            })
        }
    }
});

window.dbgApp = SurveyBuilderApp;
