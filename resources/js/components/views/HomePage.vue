<template>
    <div>
        <v-carousel
            height="280"
            hide-delimiter-background
            show-arrows-on-hover
        >
            <v-carousel-item
                v-for="(slide, i) in slides"
                :key="i"
                href="/"
            >
                <v-img
                    src="https://source.unsplash.com/random/?skate"
                    height="280"
                    gradient="to top right, rgba(38, 50, 56, .7), rgba(38, 50, 56, .5), rgba(38, 50, 56, 0)"
                >
                    <v-row align="center" class="pa-2 fill-height">
                        <v-col>
                            <div class="text-h3 text-center">
                                {{ slide }} Slide 
                                <span class="font-weight-bold">30%</span>
                                descuento
                            </div>
                        </v-col>
                    </v-row>
                </v-img>
            </v-carousel-item>
        </v-carousel>

        <v-container>
            <div class="py-5">
                <div class="text-h3 text-center text-capitalize font-weight-bold mb-5">Productos nuevos</div>
                <!-- list products -->
                <v-row v-if="listProduct.length === 0">
                    <v-col class="text-center">
                        cargando ...
                    </v-col>
                </v-row>
                <v-row v-else justify="center">
                    <v-col
                        cols="12"
                        sm="6"
                        md="4"
                        v-for="(item) in listProduct" :key="item.id"
                    >
                        <v-hover v-slot:default="{ hover }">
                            <v-card
                                class="mx-auto"
                                color="grey lighten-4"
                            >
                                <v-img
                                    :aspect-ratio="16/9"
                                    :src="`images/banners/${item.banner}`"
                                >
                                    <v-expand-transition>
                                        <div
                                            v-if="hover"
                                            class="d-flex transition-fast-in-fast-out black darken-2 v-card--reveal display-2 white--text"
                                            style="height: 100%;"
                                        >
                                            Bs.{{ item.price - item.discount }}
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
                                        <span class="text-decoration-line-through grey--text" v-if="item.discount !== 0">Bs.{{ item.price }}</span>
                                        <span class="deep-orange--text">Bs.{{ item.price - item.discount }}</span>
                                    </div>
                                    <div class="subtitle-1 font-weight-light green--text mb-0">{{ item.name }}</div>
                                </v-card-text>
                                <v-card-actions class="px-4 pb-4">
                                    <v-btn
                                        dark
                                        :href="`/producto/${item.slug}`"
                                    >
                                        Detalles
                                    </v-btn>
                                    <v-spacer></v-spacer>
                                    <!-- <v-tooltip top>
                                        <template v-slot:activator="{ on, attrs }">
                                            <v-btn
                                                icon
                                                v-bind="attrs"
                                                v-on="on"
                                            >
                                                <v-icon>mdi-heart</v-icon>
                                            </v-btn>
                                        </template>
                                        <span>{{ item.qualification }}</span>
                                    </v-tooltip> -->
                                    
                                    <v-btn icon>
                                        <v-icon>mdi-share-variant</v-icon>
                                    </v-btn>
                                </v-card-actions>
                            </v-card>
                        </v-hover>
                    </v-col>
                </v-row>
            </div>

            <div class="text-center pb-5 pt-3">
                <v-btn
                    color="green darken-2"
                    dark
                    href="/catalogo"
                >
                    Ver todos los productos
                </v-btn>
            </div>
        </v-container>
    </div>
</template>

<script>
export default {
    data() {
        return {
            slides: [
                'First',
                'Second',
                'Third',
                'Fourth',
                'Fifth',
            ],
            listProduct: []
        }
    },
    mounted() {
        // console.log('Component mounted.')
    },
    created() {
        this.getProduct();
    },
    methods: {
        getProduct() {
            axios.get(`product`)
            .then((response) => {
                console.log(response);
                this.listProduct = response.data;
            })
            .catch((error) => {
                console.log(error);
            })
        }
    },
}
</script>
