<template>
    <div>
        <v-container>
            <v-row>
                <v-col cols="12" sm="8">
                    <v-stepper v-model="e6" vertical>
                        <!-- identity -->
                        <v-stepper-step :complete="e6 > 1" step="1" editable>
                            Datos de identificación
                        </v-stepper-step>
                        
                        <v-stepper-content step="1">
                            <v-card flat>
                                <v-row>
                                    <v-col cols="12" sm="12" class="py-0">
                                        <v-text-field
                                            label="Correo electrónico *"
                                            outlined
                                            dense
                                        ></v-text-field>
                                    </v-col>
                                    <v-col cols="12" sm="6" class="py-0">
                                        <v-text-field
                                            label="Nombre/s *"
                                            outlined
                                            dense
                                        ></v-text-field>
                                    </v-col>
                                    <v-col cols="12" sm="6" class="py-0">
                                        <v-text-field
                                            label="Apellido/s *"
                                            outlined
                                            dense
                                        ></v-text-field>
                                    </v-col>
                                    <v-col cols="12" sm="6" class="py-0">
                                        <v-text-field
                                            label="C.I. *"
                                            outlined
                                            dense
                                        ></v-text-field>
                                    </v-col>
                                    <v-col cols="12" sm="6" class="py-0">
                                        <v-text-field
                                            label="Teléfono o celular *"
                                            outlined
                                            dense
                                        ></v-text-field>
                                    </v-col>
                                </v-row>
                            </v-card>
                            <v-btn color="primary" @click="e6 = 2">Siguiente</v-btn>
                        </v-stepper-content>

                        <!-- Facture -->
                        <v-stepper-step :complete="e6 > 2" step="2" editable>
                            Datos de facturación
                        </v-stepper-step>

                        <v-stepper-content step="2">
                            <v-card flat>
                                <v-row>
                                    <v-col cols="12" sm="12" class="py-0">
                                        <v-text-field
                                            label="Razón Social / Nombre *"
                                            outlined
                                            dense
                                        ></v-text-field>
                                    </v-col>
                                    <v-col cols="12" sm="12" class="py-0">
                                        <v-text-field
                                            label="NIT"
                                            outlined
                                            dense
                                            hint="Dejar en blanco si no cuenta con NIT"
                                        ></v-text-field>
                                    </v-col>
                                </v-row>
                            </v-card>
                            <v-btn color="primary" @click="e6 = 3">Siguiente</v-btn>
                        </v-stepper-content>

                        <!-- send -->
                        <v-stepper-step :complete="e6 > 3" step="3" editable>
                            Dirección de envíos
                        </v-stepper-step>

                        <v-stepper-content step="3">
                            <v-card flat>
                                <v-row>
                                    <v-col cols="12" sm="12" class="py-0">
                                        <v-text-field
                                            label="Calle *"
                                            outlined
                                            dense
                                        ></v-text-field>
                                    </v-col>
                                    <v-col cols="12" sm="6" class="py-0">
                                        <v-text-field
                                            label="Nro. *"
                                            outlined
                                            dense
                                        ></v-text-field>
                                    </v-col>
                                    <v-col cols="12" sm="6" class="py-0">
                                        <v-text-field
                                            label="Piso y/o depto."
                                            outlined
                                            dense
                                        ></v-text-field>
                                    </v-col>
                                    <v-col cols="12" sm="12" class="py-0">
                                        <v-select
                                            :items="cities"
                                            label="Departamento *"
                                            outlined
                                            dense
                                        ></v-select>
                                    </v-col>
                                    <v-col cols="12" sm="12" class="py-0">
                                        <v-select
                                            :items="cities"
                                            label="Provincia *"
                                            outlined
                                            dense
                                        ></v-select>
                                    </v-col>
                                    <v-col cols="12" sm="12" class="py-0">
                                        <v-select
                                            :items="cities"
                                            label="Cuidad *"
                                            outlined
                                            dense
                                        ></v-select>
                                    </v-col>
                                </v-row>
                                Seleccione tu método de entrega
                                <v-radio-group v-model="radios">
                                    <v-radio value="store">
                                        <template v-slot:label>
                                            <v-icon size="64" color="green">mdi-store</v-icon>
                                            Retiro en la tienda (Gratis)
                                        </template>
                                    </v-radio>
                                    <v-radio value="bus">
                                        <template v-slot:label>
                                            <v-icon size="64" color="green">mdi-bus</v-icon>
                                            Envío a terminal (Pago en destino)
                                        </template>
                                    </v-radio>
                                    <v-text-field
                                        label="Flota *"
                                        hint="Ingrese aquí la flota de preferencia para el envío."
                                        outlined
                                        dense
                                        v-if="radios === 'bus'"
                                    ></v-text-field>
                                    <v-radio value="home">
                                        <template v-slot:label>
                                            <v-icon size="64" color="green">mdi-motorbike</v-icon>
                                            Envío a domicilio (Bs. 35)
                                        </template>
                                    </v-radio>
                                </v-radio-group>
                            </v-card>
                            <v-btn color="primary" @click="e6 = 4">Ir a método de pago</v-btn>
                        </v-stepper-content>

                        <!-- payment -->
                        <v-stepper-step :complete="e6 > 4" step="4" editable>
                            Método de pago
                        </v-stepper-step>

                        <v-stepper-content step="4">
                            <v-card flat>
                                <v-select
                                    :items="methodPay"
                                    label="Método de pago *"
                                    hint="Selecione un método de pago"
                                    outlined
                                    dense
                                ></v-select>
                            </v-card>
                        </v-stepper-content>
                    </v-stepper>
                </v-col>
                <v-col cols="12" sm="4">
                    <v-card>
                        <v-list dense v-if="cart !== '{}'">
                            <v-list-item-group v-for="(item) in JSON.parse(cart)" :key="item.slug" class="py-1">
                                <template v-if="Array.isArray(item)">
                                    <v-list-item v-for="(child, index) in item" :key="index" :href="`/producto/${child.slug}`">
                                        <v-badge
                                            :content="child.quantity"
                                            :value="child.quantity"
                                            color="green"
                                            offset-y="20"
                                            offset-x="20"
                                        >
                                            <v-avatar class="rounded-0" height="60" width="60">
                                                <v-img
                                                    :src="`/images/banners/${child.banner}`"
                                                ></v-img>
                                            </v-avatar>
                                        </v-badge>
                                        <v-list-item-content class="ml-5">
                                            <v-list-item-title>
                                                <span class="black--text" style="font-size: 14px;">
                                                    {{ child.name }}
                                                </span>
                                            </v-list-item-title>
                                            <v-list-item-subtitle>
                                                <span class="text--primary d-block font-weight-bold">
                                                    Bs.{{ child.price - child.discount }}
                                                </span>
                                                <span v-for="(at, index) in child.attr" :key="index">
                                                    {{ index }}: {{ at }}
                                                </span>
                                            </v-list-item-subtitle>
                                        </v-list-item-content>
                                    </v-list-item>
                                </template>
                                <!-- not ATTRIBUTE -->
                                <v-list-item v-else :href="`/producto/${item.slug}`">
                                    <v-badge
                                        :content="item.quantity"
                                        :value="item.quantity"
                                        color="green"
                                        offset-y="20"
                                        offset-x="20"
                                    >
                                        <v-avatar class="rounded-0" height="60" width="60">
                                            <v-img
                                                :src="`/images/banners/${item.banner}`"
                                            ></v-img>
                                        </v-avatar>
                                    </v-badge>
                                    <v-list-item-content class="ml-5">
                                        <v-list-item-title>
                                            <span class="black--text" style="font-size: 14px;">
                                                {{ item.name }}
                                            </span>
                                        </v-list-item-title>
                                        <v-list-item-subtitle>
                                            <span class="text--primary d-block font-weight-bold">
                                                Bs.{{ item.price - item.discount }}
                                            </span>
                                        </v-list-item-subtitle>
                                    </v-list-item-content>
                                </v-list-item>
                            </v-list-item-group>

                            <v-divider></v-divider>

                            <v-list-item>
                                <v-row align="center">
                                    <v-col cols="6" class="pb-0">
                                        <span style="font-size: 12px">SubTotal: </span>
                                    </v-col>
                                    <v-col cols="6" class="text-right pb-0">
                                        <span class="subtitle-1 font-weight-bold">Bs.{{ total }}</span>
                                    </v-col>
                                    <v-col cols="6" class="pt-0">
                                        <span style="font-size: 12px">Costo de envío: </span>
                                    </v-col>
                                    <v-col cols="6" class="text-right pt-0">
                                        <span class="subtitle-1 font-weight-bold">gratis</span>
                                    </v-col>
                                    <v-col cols="12" class="pa-0">
                                        <v-divider></v-divider>
                                    </v-col>
                                    <v-col cols="6">
                                        <span style="font-size: 14px">TOTAL: </span>
                                    </v-col>
                                    <v-col cols="6" class="text-right">
                                        <span class="deep-orange--text subtitle-1 font-weight-bold">Bs.{{ total }}</span>
                                    </v-col>
                                </v-row>
                            </v-list-item>

                            <!-- <v-divider></v-divider>

                            <v-list-item>
                                <v-btn
                                    dark
                                    block
                                    href="/carrito"
                                >
                                    Lista de pago
                                </v-btn>
                            </v-list-item> -->
                        </v-list>
                    </v-card>
                </v-col>
            </v-row>
        </v-container>
    </div>
</template><script>
export default {
    data() {
        return {
            e6: 1,
            radios: 'store',
            cities: ['Beni', 'Chuquisaca', 'Cochabamba', 'La Paz', 'Oruro', 'Pando', 'Potosí', 'Santa Cruz', 'Tarija'],
            methodPay: ['Tarjeta de Crédito / Débito', 'Transferencia bancaria', 'Togo Money', 'En tienda']
        }
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