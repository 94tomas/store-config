<template>
    <div>
        <v-container>
            <div class="py-5">
                <div class="text-h4 text-center text-capitalize font-weight-bold mb-5">Productos</div>
                <v-divider></v-divider>
                <v-row>
                    <v-col cols="12" md="4">
                        filtro por categoria
                    </v-col>
                    <v-col cols="12" md="4" class="text-center">
                        6 productos
                    </v-col>
                    <v-col cols="12" md="4" class="text-right">
                        buscar productos
                    </v-col>
                </v-row>
                <v-divider></v-divider>
                <!-- list products -->
                <v-row class="mt-4">
                    <v-col
                        cols="12"
                        sm="6"
                        md="4"
                        v-for="(item, index) in 6" :key="index"
                    >
                        <v-hover v-slot:default="{ hover }">
                            <v-card
                                class="mx-auto"
                                color="grey lighten-4"
                            >
                                <v-img
                                    :aspect-ratio="16/9"
                                    src="https://source.unsplash.com/random/?vans"
                                >
                                    <v-expand-transition>
                                        <div
                                            v-if="hover"
                                            class="d-flex transition-fast-in-fast-out black darken-2 v-card--reveal display-2 white--text"
                                            style="height: 100%;"
                                        >
                                            Bs.250
                                        </div>
                                    </v-expand-transition>
                                </v-img>
                                <v-card-text
                                    class="pt-6"
                                    style="position: relative;"
                                >
                                    <v-btn
                                        absolute
                                        color="green darken-2"
                                        dark
                                        fab
                                        right
                                        top
                                    >
                                        <v-icon>mdi-cart</v-icon>
                                    </v-btn>
                                    <div class="font-weight-light title mb-2">
                                        <span class="text-decoration-line-through grey--text">Bs.300</span>
                                        <span class="deep-orange--text">Bs.250</span>
                                    </div>
                                    <div class="subtitle-1 font-weight-light green--text mb-0">Zapatos Vans</div>
                                </v-card-text>
                                <v-card-actions class="px-4 pb-4">
                                    <v-spacer></v-spacer>
                                    <v-btn
                                        dark
                                        :href="`/producto/producti-${index}`"
                                    >
                                        Detalles
                                    </v-btn>
                                    <!-- <v-btn icon>
                                        <v-icon>mdi-heart</v-icon>
                                    </v-btn>
                                    <v-btn icon>
                                        <v-icon>mdi-share-variant</v-icon>
                                    </v-btn> -->
                                </v-card-actions>
                            </v-card>
                        </v-hover>
                    </v-col>
                </v-row>
            </div>

            <div class="text-center pb-5 pt-3">
                <v-pagination
                    v-model="page"
                    :length="15"
                    :total-visible="5"
                    color="green darken-2"
                    dark
                ></v-pagination>
            </div>
        </v-container>
    </div>
</template>
<script>
export default {
    data() {
        return {
            page: 1,
        }
    },
}
</script>