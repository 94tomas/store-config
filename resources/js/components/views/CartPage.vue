<template>
    <div>
        <v-container>
            <div v-if="cart !== '{}'" class="py-5">
                <div class="text-h4 text-center text-capitalize font-weight-bold mb-5">Tu carrito</div>

                <v-simple-table>
                    <template v-slot:default>
                        <thead>
                            <tr>
                                <th class="text-left">Producto</th>
                                <th class="text-left">Precio</th>
                                <th class="text-left">Cantidad</th>
                                <th class="text-left">Total</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <template v-for="(item) in JSON.parse(cart)">
                                <template v-if="Array.isArray(item)">
                                    <tr v-for="(child, index) in item">
                                        <td>
                                            <v-list-item class="px-0">
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
                                                    <span v-for="(at, index) in child.attr" :key="index">
                                                        {{ index }}: {{ at }}
                                                    </span>
                                                </v-list-item-content>
                                            </v-list-item>
                                        </td>
                                        <td>Bs.{{ child.price - child.discount }}</td>
                                        <td>
                                            <v-text-field
                                                label="Cantidad"
                                                solo
                                                dense
                                                type="number"
                                                hide-details
                                                style="max-width: 90px"
                                                min="1"
                                                step="1"
                                                required
                                                v-model="child.quantity"
                                                @input="$store.dispatch('changeQuantity', {quantity: $event, slug: child.slug, index: index})"
                                            ></v-text-field>
                                        </td>
                                        <td>Bs.{{ (child.price - child.discount) * child.quantity }}</td>
                                        <td>
                                            <v-btn fab dark x-small @click="$store.dispatch('removeItem', {slug: child.slug, index: index})">
                                                <v-icon>mdi-close-circle</v-icon>
                                            </v-btn>
                                        </td>
                                    </tr>
                                </template>
                                <!-- not attributes -->
                                <template v-else>
                                    <tr>
                                        <td>
                                            <v-list-item class="px-0">
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
                                                </v-list-item-content>
                                            </v-list-item>
                                        </td>
                                        <td>Bs.{{ item.price - item.discount }}</td>
                                        <td>
                                            <v-text-field
                                                label="Cantidad"
                                                solo
                                                dense
                                                type="number"
                                                hide-details
                                                style="max-width: 90px"
                                                min="1"
                                                step="1"
                                                required
                                                v-model="item.quantity"
                                                @input="$store.dispatch('changeQuantity', {quantity:$event, slug:item.slug, index: null})"
                                            ></v-text-field>
                                        </td>
                                        <td>Bs.{{ (item.price - item.discount) * item.quantity }}</td>
                                        <td>
                                            <v-btn fab dark x-small @click="$store.dispatch('removeItem', {slug: item.slug, index:null})">
                                                <v-icon>mdi-close-circle</v-icon>
                                            </v-btn>
                                        </td>
                                    </tr>
                                </template>
                            </template>
                            <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>
                                    <div class="text-h5 py-8">Subtotal:</div>
                                </td>
                                <td>
                                    <v-chip>
                                        Bs.{{ total }}
                                    </v-chip>
                                </td>
                                <td>&nbsp;</td>
                            </tr>
                        </tbody>
                    </template>
                </v-simple-table>

                <v-row class="mt-5">
                    <v-col cols="12" class="text-right">
                        <v-btn
                            text
                            href="/catalogo"
                        >
                            Seguir comprando
                        </v-btn>
                        <v-btn
                            dark
                        >
                            Continuar con la compra
                        </v-btn>
                    </v-col>
                </v-row>
            </div>
            <div v-else class="py-5">
                <v-row>
                    <v-col cols="6" offset="3" class="text-center">
                        <div class="text-h4 text-center text-capitalize font-weight-bold mb-5">Tu carrito</div>
                        <div class="mb-3">Su carrito está vacío.</div>
                        <v-btn
                            dark
                            href="/catalogo"
                        >
                            Seguir comprando
                        </v-btn>
                    </v-col>
                </v-row>
            </div>
        </v-container>
    </div>
</template>
<script>
export default {
    data() {
        return {
            
        }
    },
    methods: {
        
    },
    computed: {
        cart() {
            return this.$store.state.cart;
        },
        total() {
            return this.$store.state.total;
        },
    }
}
</script>