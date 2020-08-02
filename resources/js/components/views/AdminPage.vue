<template>
    <div style="display: table">
        <!-- <v-btn
            dark
            fab
            bottom
            right
            fixed
            color="pink"
            large
            @click.stop="drawer = !drawer"
        >
            <v-icon>mdi-home-city</v-icon>
        </v-btn> -->
        
        <!-- <v-tabs
            background-color="blue-grey lighten-5"
            color="deep-orange darken-3"
            next-icon="mdi-arrow-right-bold-box-outline"
            prev-icon="mdi-arrow-left-bold-box-outline"
            show-arrows
            icons-and-text
            v-model="tab"
        >
            <v-tabs-slider color="deep-orange darken-3"></v-tabs-slider>
            <v-tab href="#products">
                Productos
                <v-icon>mdi-database-settings</v-icon>
            </v-tab>

            <v-tab href="#offers">
                Ofertas
                <v-icon>mdi-tag</v-icon>
            </v-tab>

            <v-tab href="#sales">
                Ventas
                <v-icon>mdi-cart-arrow-up</v-icon>
            </v-tab>

            <v-tab href="#orders">
                Pedidos
                <v-icon>mdi-order-bool-descending-variant</v-icon>
            </v-tab>

            <v-tab href="#settings">
                Configuración
                <v-icon>mdi-cog</v-icon>
            </v-tab>
        </v-tabs> -->
        <v-navigation-drawer
            v-model="drawer"
            :mini-variant.sync="mini"
            permanent
            class="c-aside elevation-3"
        >
            <v-list-item class="px-2">
                <v-list-item-avatar>
                    <img
                        src="/images/logo.png"
                        alt="store"
                        style="background:grey;"
                    >
                </v-list-item-avatar>

                <v-list-item-title>Menu</v-list-item-title>
                <v-btn
                    icon
                    @click.stop="mini = !mini"
                >
                    <v-icon>mdi-arrow-left-bold-circle</v-icon>
                </v-btn>
            </v-list-item>

            <v-divider></v-divider>

            <v-list>
                <v-list-group
                    no-action
                    value="true"
                >
                    <template v-slot:activator>
                        <v-list-item-icon>
                            <v-icon>mdi-database-settings</v-icon>
                        </v-list-item-icon>
                        <v-list-item-title>Productos</v-list-item-title>
                    </template>

                    <v-list-item
                        v-for="(item, i) in productsNav"
                        :key="i"
                        link
                        sub-group
                        dense
                        :href="`/admin?page=${item[2]}`"
                    >
                        <v-list-item-title v-text="item[0]"></v-list-item-title>
                        <v-list-item-icon>
                            <v-icon>{{ item[1] }}</v-icon>
                        </v-list-item-icon>
                    </v-list-item>
                </v-list-group>

                <v-list-item href="/admin?page=offers">
                    <v-list-item-icon>
                        <v-icon>mdi-tag</v-icon>
                    </v-list-item-icon>
                    <v-list-item-title>Ofertas</v-list-item-title>
                </v-list-item>

                <v-list-item href="/admin?page=sales">
                    <v-list-item-icon>
                        <v-icon>mdi-cart-arrow-up</v-icon>
                    </v-list-item-icon>
                    <v-list-item-title>Ventas</v-list-item-title>
                </v-list-item>

                <v-list-item href="/admin?page=orders">
                    <v-list-item-icon>
                        <v-icon>mdi-order-bool-descending-variant</v-icon>
                    </v-list-item-icon>
                    <v-list-item-title>Pedidos</v-list-item-title>
                </v-list-item>

                <!-- <v-list-item @click="changeTab('settings')"> -->
                <v-list-item href="/admin?page=settings">
                    <v-list-item-icon>
                        <v-icon>mdi-cog</v-icon>
                    </v-list-item-icon>
                    <v-list-item-title>Configuración</v-list-item-title>
                </v-list-item>
            </v-list>
        </v-navigation-drawer>

        <v-container style="display: table-cell;">
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
            drawer: null,
            mini: false,
            id: null,
            productsNav: [
                ['Todos los productos', 'mdi-cube-outline', 'products'],
                ['Añadir nuevo', 'mdi-plus-box', 'add'],
                ['Categorías', 'mdi-shape', 'categories'],
                ['Atributos', 'mdi-ticket', 'attributes'],
            ]
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
            const tabs = ['products', 'offers', 'sales', 'orders', 'settings', 'add', 'edit', 'categories', 'attributes'];
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
<style lang="scss">
.c-aside {
    display: table-cell;
    .v-navigation-drawer__content {
        height: auto;
    }
}
</style>