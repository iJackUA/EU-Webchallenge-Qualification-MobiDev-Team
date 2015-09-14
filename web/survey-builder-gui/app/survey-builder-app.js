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
                type: 'text',
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
    methods: {},
    components: {
        'builder-q-slider': require('./component-q-slider'),
        'builder-q-text': require('./component-q-text')
    }
});
