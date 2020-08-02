<template>
    <v-app>
        <!-- Nav aside -->
        <v-navigation-drawer
            :value="drawer"
            @input="$store.dispatch('openNavigationDrawer', $event)"
            app
            right
            width="320"
        >
            <v-list dense v-if="cart !== '{}'">
                <v-list-item-group v-for="(item) in JSON.parse(cart)" :key="item.slug">
                    <template v-if="Array.isArray(item)">
                        <v-list-item v-for="(child, index) in item" :key="index">
                            <v-list-item-avatar class="rounded-0" height="60" width="60">
                                <v-img
                                    :src="`/images/banners/${child.banner}`"
                                ></v-img>
                            </v-list-item-avatar>
                            <v-list-item-content>
                                <v-list-item-title>
                                    <a :href="`/producto/${child.slug}`" class="text-decoration-none black--text" style="font-size: 14px;">
                                        {{ child.name }}
                                    </a>
                                </v-list-item-title>
                                <v-list-item-subtitle>
                                    <span class="text--primary d-block">
                                        Bs.{{ child.price - child.discount }}
                                        <span class="orange--text" v-if="child.quantity > 1"> X {{ child.quantity }}</span>
                                    </span>
                                    <span v-for="(at, index) in child.attr" :key="index">
                                        {{ index }}: {{ at }}
                                    </span>
                                </v-list-item-subtitle>
                            </v-list-item-content>
                            <v-list-item-action>
                                <v-btn icon @click="$store.dispatch('removeItem', {slug: child.slug, index: index})">
                                    <v-icon color="grey lighten-1">mdi-close-circle</v-icon>
                                </v-btn>
                            </v-list-item-action>
                        </v-list-item>
                    </template>
                    <!-- not ATTRIBUTE -->
                    <v-list-item v-else>
                        <v-list-item-avatar class="rounded-0" height="60" width="60">
                            <v-img
                                :src="`/images/banners/${item.banner}`"
                            ></v-img>
                        </v-list-item-avatar>
                        <v-list-item-content>
                            <v-list-item-title>
                                <a :href="`/producto/${item.slug}`" class="text-decoration-none black--text" style="font-size: 14px;">
                                    {{ item.name }}
                                </a>
                            </v-list-item-title>
                            <v-list-item-subtitle>
                                <span class="text--primary d-block">
                                    Bs.{{ item.price - item.discount }}
                                    <span class="orange--text" v-if="item.quantity > 1"> X {{ item.quantity }}</span>
                                </span>
                            </v-list-item-subtitle>
                        </v-list-item-content>
                        <v-list-item-action>
                            <v-btn icon @click="$store.dispatch('removeItem', {slug: item.slug, index: null})">
                                <v-icon color="grey lighten-1">mdi-close-circle</v-icon>
                            </v-btn>
                        </v-list-item-action>
                    </v-list-item>
                </v-list-item-group>

                <v-divider></v-divider>

                <v-list-item>
                    <v-row align="center">
                        <v-col cols="6" class="text-right">
                            <span style="font-size: 12px">SubTotal: </span>
                        </v-col>
                        <v-col cols="6">
                            <span class="deep-orange--text subtitle-1">Bs.{{ total }}</span>
                        </v-col>
                    </v-row>
                </v-list-item>

                <v-list-item>
                    <v-btn
                        dark
                        block
                        href="/carrito"
                    >
                        Lista de pago
                    </v-btn>
                </v-list-item>
            </v-list>

            <v-list v-else>
                <v-list-item class="justify-center">
                    Ningun producto
                </v-list-item>
                <v-list-item>
                    <v-btn
                        dark
                        block
                        href="/catalogo"
                    >
                        Seguir comprando
                    </v-btn>
                </v-list-item>
            </v-list>
        </v-navigation-drawer>
        <!-- end nav aside -->
        <v-app-bar
            app
            color="blue-grey darken-3"
            dark
            height="80"
            elevate-on-scroll
            hide-on-scroll
        >
            <v-toolbar-title>
                <a href="/" class="white--text text-decoration-none d-block" style="font-size: 30px">
                    <v-avatar color="dark" size="62" tile>
                        <img
                            src="/images/logo.png"
                            alt="store"
                        >
                    </v-avatar>
                    Store
                </a>
            </v-toolbar-title>

            <v-spacer></v-spacer>

            <v-btn
                icon
                class="mx-2"
            >
                <v-icon>mdi-magnify</v-icon>
            </v-btn>

            <!-- Authenticate -->
            <v-menu
                offset-y
                v-if="auth !== 'not'"
            >
                <template v-slot:activator="{ on, attrs }">
                    <v-btn
                        v-bind="attrs"
                        v-on="on"
                        class="mx-2"
                    >
                        {{ user.name }}
                    </v-btn>
                </template>

                <!-- Authentication Links -->
                <v-card>
                    <v-list>
                        <v-list-item>
                            <v-list-item-avatar>
                                <v-icon>mdi-account</v-icon>
                            </v-list-item-avatar>
                
                            <v-list-item-content>
                                <v-list-item-title>{{ user.name }}</v-list-item-title>
                            </v-list-item-content>
                
                            <v-list-item-action>
                            </v-list-item-action>
                        </v-list-item>
                    </v-list>
                
                    <v-divider></v-divider>

                    <v-list dense>
                        <!-- <v-list-item href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();"
                        >
                            <v-list-item-title>Salir</v-list-item-title>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </v-list-item> -->
                        <v-list-item>
                            <v-list-item-title>Mi cuenta</v-list-item-title>
                        </v-list-item>
                        <v-list-item @click.prevent="logout">
                            <v-list-item-title>Salir</v-list-item-title>
                        </v-list-item>
                    </v-list>
                </v-card>
            </v-menu>
            <v-menu
                offset-y
                v-else
            >
                <template v-slot:activator="{ on, attrs }">
                    <v-btn
                        icon
                        v-bind="attrs"
                        v-on="on"
                        class="mx-2"
                    >
                        <v-icon>mdi-account</v-icon>
                    </v-btn>
                </template>

                <!-- Authentication Links -->
                <v-card>
                    <v-list>
                        <v-list-item>
                            <v-list-item-avatar>
                                <v-icon>mdi-account</v-icon>
                            </v-list-item-avatar>
                
                            <v-list-item-content>
                                <v-list-item-title>Iniciar sesión</v-list-item-title>
                            </v-list-item-content>
                
                            <v-list-item-action>
                            </v-list-item-action>
                        </v-list-item>
                    </v-list>
                
                    <v-divider></v-divider>

                    <v-list dense>
                        <v-list-item href="/login">
                            <v-list-item-title>Iniciar sesión</v-list-item-title>
                        </v-list-item>
                        <v-list-item href="/register">
                            <v-list-item-title>Registrate</v-list-item-title>
                        </v-list-item>
                    </v-list>
                </v-card>
            </v-menu>

            <!-- cart -->
            <v-btn
                fab
                dark
                small
                class="mx-2"
                color="green darken-2"
                @click.stop="$store.commit('openDrawer', true)"
            >
                <!-- @click.stop="$store.dispatch('toggleDrawerOn', drawer);" -->
                <!-- @click.stop="$store.commit('toggleDrawer', !drawer)" -->
                <v-badge
                    :content="count"
                    :value="count"
                    color="red"
                >
                    <v-icon>
                        mdi-cart-outline
                    </v-icon>
                </v-badge>
            </v-btn>

            <template v-slot:extension>
                <v-tabs
                    centered
                    hide-slider
                    color="white"
                    background-color="blue-grey darken-4"
                    v-model="activeTab"
                >
                    <v-tab v-for="tab in tabs" :key="tab.id" :href="tab.route" exact>
                        {{ tab.name }}
                    </v-tab>
                </v-tabs>
            </template>
        </v-app-bar>
        <!-- Sizes your content based upon application components -->
        <v-main>
            <slot></slot>
        </v-main>

        <v-footer :padless="true">
            <v-card
                flat
                tile
                width="100%"
                class="blue-grey darken-3 text-center"
            >
                <v-card-text>
                    <v-btn
                        class="mx-4"
                        icon
                        dark
                    >
                        <v-icon size="24px">mdi-home</v-icon>
                    </v-btn>
                    <v-btn
                        class="mx-4"
                        icon
                        dark
                    >
                        <v-icon size="24px">mdi-email</v-icon>
                    </v-btn>
                    <v-btn
                        class="mx-4"
                        icon
                        dark
                    >
                        <v-icon size="24px">mdi-facebook</v-icon>
                    </v-btn>
                </v-card-text>

                <v-divider></v-divider>

                <v-card-text class="white--text">
                    2020 — <strong>Store</strong>
                </v-card-text>
            </v-card>
        </v-footer>
    </v-app>
</template>
<script>
import axios from 'axios';
export default {
    data() {
        return {
            csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            activeTab: `/`,
            tabs: [
                { id: 1, name: "Inicio", route: `/` },
                { id: 2, name: "Catalogo", route: `/catalogo` },
            ],
            // drawer: null,
            user: {
                name: ''
            }
        }
    },
    props: ['auth'],
    mounted() {
        this.updateTabs();
    },
    created() {
        if (this.auth !== 'not') {
            this.getUser(this.auth);
        }
    },
    methods: {
        logout() {
            axios.post('logout')
            .then((response) => {
                // console.log(response);
                if (response.status === 302 || 401) {
                    window.location.href = '/'
                }
                else {
                    // throw error and go to catch block
                }
            })
            .catch((error) => {
                console.log(error);
            })
        },
        updateTabs() {
            switch (window.location.pathname) {
                case '/':
                    this.activeTab = '/';
                    break;
                case '/catalogo':
                    this.activeTab = '/catalogo';
                    break;
                case '/admin':
                    this.activeTab = '/admin';
                    break;
                default:
                    break;
            }
        },
        // get data user
        getUser(id) {
            axios.get(`/users/${id}`)
            .then((response) => {
                // console.log(response);
                this.user.name = response.data.name;
                if (response.data.role === 'seller') {
                    this.tabs.push({ id: 3, name: "Mi panel", route: `/admin` });
                    this.updateTabs();
                }
            })
            .catch((error) => {
                console.log(error);
            })
        }
    },
    computed: {
        cart() {
            return this.$store.state.cart;
        },
        count() {
            return this.$store.state.count;
        },
        total() {
            return this.$store.state.total;
        },
        drawer() {
            return this.$store.state.drawer;
        },
    },
}
</script>