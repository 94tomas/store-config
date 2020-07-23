<template>
    <div>
        <v-tabs
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
        </v-tabs>
        <v-container>
            <component :is="`admin-${tab}`">
            </component>
        </v-container>
    </div>
</template>
<script>

export default {
    data() {
        return {
            tab: 'products',
        }
    },
}
</script>