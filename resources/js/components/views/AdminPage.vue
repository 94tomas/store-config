<template>
    <div>
        <v-container>
            <component :is="`admin-${tab}`" :id="id">
            </component>
        </v-container>
    </div>
</template>
<script>

export default {
    data() {
        return {
            tab: 'products',
            id: null
        }
    },
    created() {
        this.getParams();
    },
    methods: {
        getParams() {
            const queryString = window.location.search;
            const urlParams = new URLSearchParams(queryString);
            const page_type = urlParams.get('page');
            const tabs = [
                'products',
                'add',
                'edit',
                'categories',
                'attributes',
                'offers',
                'add-offer',
                'sales',
                'orders',
                'settings',
            ];
            if (page_type !== null) {
                if (tabs.includes(page_type)) {
                    if (page_type === 'edit') {
                        this.id = urlParams.get('id');
                    }
                    this.tab = page_type;
                } else {
                    window.location = '/admin';
                }
            } 
        }
    },
}
</script>
