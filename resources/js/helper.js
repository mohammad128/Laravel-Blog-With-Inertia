import Vue from 'vue';

Vue.mixin({
    computed: {
        errors() {
            return this.$page.props.errors;
        },
        siteTitle() {
            return this.$page.props.site_config.site_title;
        },
        tagLine() {
            return this.$page.props.site_config.tag_line;
        }
    },
    methods: {
        link(e) {
            let url = e.currentTarget.getAttribute('url');
            let method = e.currentTarget.getAttribute('method');
            if(method === '') method = 'get';
            this.$inertia.visit(url, { method: method })
        },
        can(permission) {
            if (!permission) return true;
            return this.$page.props.can[permission];
        },
        titleToId(title) {
            return title.replace(/\s+/g, '_');
        },
        getCsrfToken() {
            return window.csrf_token;

        },
        convertToSlug(Text) {
            return Text.toLowerCase()
                .replace(/ /g, '-');
                // .replace(/[^\w-]+/g, '');
        },

    }
});
