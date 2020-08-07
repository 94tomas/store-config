<template>
    <v-app id="inspire">
        <v-navigation-drawer
            v-model="drawer"
            app
            clipped
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
                        :href="`/admin?page=${item.url}`"
                    >
                        <v-list-item-title v-text="item.text"></v-list-item-title>
                        <v-list-item-icon>
                            <v-icon>{{ item.icon }}</v-icon>
                        </v-list-item-icon>
                    </v-list-item>
                </v-list-group>

                <v-list-group
                    no-action
                    value="true"
                >
                    <template v-slot:activator>
                        <v-list-item-icon>
                            <v-icon>mdi-tag</v-icon>
                        </v-list-item-icon>
                        <v-list-item-title>Ofertas</v-list-item-title>
                    </template>

                    <v-list-item
                        v-for="(item, i) in offersNav"
                        :key="i"
                        link
                        sub-group
                        dense
                        :href="`/admin?page=${item.url}`"
                    >
                        <v-list-item-title v-text="item.text"></v-list-item-title>
                        <v-list-item-icon>
                            <v-icon>{{ item.icon }}</v-icon>
                        </v-list-item-icon>
                    </v-list-item>
                </v-list-group>

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

        <v-app-bar
            app
            color="blue-grey darken-4"
            dark
        >
            <v-app-bar-nav-icon @click.stop="drawer = !drawer"></v-app-bar-nav-icon>
            <v-toolbar-title>
                Administrador
            </v-toolbar-title>
            <v-spacer></v-spacer>
            
            <v-btn href="/" icon class="mx-1">
                <v-icon>mdi-home</v-icon>
            </v-btn>
            <v-btn @click.prevent="logout" icon class="mx-1">
                <v-icon>
                    mdi-logout
                </v-icon>
            </v-btn>
        </v-app-bar>

        <v-main>
            <slot></slot>
        </v-main>
        <v-footer
            color="blue-grey darken-4"
            app
        >
            <span class="white--text">&copy; {{ new Date().getFullYear() }}</span>
        </v-footer>
    </v-app>
</template>

<script>
  export default {
    data() {
        return {
            drawer: null,
            productsNav: [
                { text: 'Todos los productos', icon: 'mdi-cube-outline', url: 'products' },
                { text: 'Añadir nuevo', icon: 'mdi-plus-box', url: 'add' },
                { text: 'Categorías', icon: 'mdi-shape', url: 'categories' },
                { text: 'Atributos', icon: 'mdi-ticket', url: 'attributes' }
            ],
            offersNav: [
                { text: 'Todas las ofertas', icon: 'mdi-offer', url: 'offers' },
                { text: 'Crear oferta', icon: 'mdi-plus', url: 'add-offer' }
            ]
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
    },
  }
</script>