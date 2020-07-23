<template>
    <div>
        <v-row align="center">
            <v-col cols="12" md="8">
                <v-text-field
                    solo
                    hide-details
                    label="Buscar oferta"
                    append-icon="mdi-magnify"
                ></v-text-field>
            </v-col>
            <v-col cols="12" md="4">
                <v-btn
                    dark
                    block
                    large
                    @click="dialogCreate = !dialogCreate"
                >
                    Crear oferta
                </v-btn>
            </v-col>
        </v-row>

        <div class="mt-5">
            <v-hover v-for="(item, index) in 6" :key="index">
                <template v-slot="{ hover }">
                    <v-card class="mb-6" :elevation="hover ? 20 : 5">
                        <v-list-item>
                            <v-list-item-avatar class="rounded-0" height="80" width="100">
                                <v-img
                                    src="https://source.unsplash.com/random/?skate"
                                ></v-img>
                            </v-list-item-avatar>
                            <v-list-item-content>
                                <v-list-item-title>
                                    <a href="#" class="text-decoration-none black--text" style="font-size: 14px;">Nombre del producto</a>
                                </v-list-item-title>
                                <span style="font-size: 14px" class="text--secondary">Bs.250</span>
                                <v-list-item-subtitle style="font-size: 12px">Nombre de la tienda</v-list-item-subtitle>
                            </v-list-item-content>
                            <v-list-item-action class="flex-row align-center">
                                <v-btn icon>
                                    <v-icon>mdi-eye</v-icon>
                                </v-btn>

                                <v-btn icon @click="dialogEdit = !dialogEdit">
                                    <v-icon>mdi-pencil</v-icon>
                                </v-btn>

                                <v-btn icon @click="dialogDel = !dialogDel">
                                    <v-icon>mdi-delete</v-icon>
                                </v-btn>
                            </v-list-item-action>
                        </v-list-item>
                    </v-card>
                </template>
            </v-hover>
        </div>
        <div class="text-center py-5">
            <v-pagination
                v-model="page"
                :length="15"
                :total-visible="5"
                color="green darken-2"
                dark
            ></v-pagination>
        </div>

        <!-- create product -->
        <v-dialog
            v-model="dialogCreate"
            max-width="600px"
        >
            <v-card>
                <v-card-title>
                    <span class="headline">Añadir un nuevo producto</span>
                </v-card-title>
                <v-card-text>
                    <v-row class="mb-4">
                        
                    </v-row>
                    <small>*indica campo requerido</small>
                </v-card-text>
                <v-card-actions class="pa-4">
                    <v-spacer></v-spacer>
                    <v-btn dark @click="dialogCreate = false">Cancelar</v-btn>
                    <v-btn dark @click="dialogCreate = false">Añadir</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
        <!-- end create product -->

        <!-- update product -->
        <v-dialog
            v-model="dialogEdit"
            max-width="600px"
        >
            <v-card>
                <v-card-title>
                    <span class="headline">Editar producto</span>
                </v-card-title>
                <v-card-text>
                    <v-row class="mb-4">
                        
                    </v-row>
                    <small>*indica campo requerido</small>
                </v-card-text>
                <v-card-actions class="pa-4">
                    <v-spacer></v-spacer>
                    <v-btn dark @click="dialogEdit = false">Cancelar</v-btn>
                    <v-btn dark @click="dialogEdit = false">Actualizar</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
        <!-- end update product -->

        <!-- delete product -->
        <v-dialog
            v-model="dialogDel"
            max-width="300px"
        >
            <v-card>
                <v-card-title>
                    <span class="headline">Nombre del producto</span>
                </v-card-title>
                <v-card-text>
                    <v-alert
                        dense
                        outlined
                        type="error"
                    >
                        Al eliminar el producto <strong>Zapatos</strong>, no podrá recuperarlo.
                    </v-alert>
                </v-card-text>
                <v-card-actions class="pa-4">
                    <v-spacer></v-spacer>
                    <v-btn dark @click="dialogDel = false">Cancelar</v-btn>
                    <v-btn dark @click="dialogDel = false">Eliminar</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
        <!-- end delete product -->
    </div>
</template>
<script>
export default {
    data() {
        return {
            page: 1,
            dialogCreate: false,
            dialogEdit: false,
            dialogDel: false,
        }
    },
}
</script>