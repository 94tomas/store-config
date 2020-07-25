<template>
    <div>
        <!-- <v-parallax 
            src="https://source.unsplash.com/random/?shoes"
            height="200"
        >
            <div class="overlay-gradient" style="background: #000125"></div>
                        
            <v-container class="text-center">
                <div class="text-h3 mb-5">
                    <span class="font-weight-bold">Nombre de la tienda</span>
                </div>
            </v-container>
        </v-parallax> -->
        
        <v-container fluid>
            <v-row v-if="load">
                <v-col
                    cols="12"
                    sm="6"
                >
                    <v-row>
                        <v-col
                            cols="12"
                            md="3"
                        >
                            <div>
                                <v-card
                                    max-width="48"
                                    class="mb-5 mx-auto"
                                    v-for="(item, index) in gallery" :key="index"
                                    @click="changePreview(item.url)"
                                >
                                    <v-img
                                        :src="item.url"
                                    ></v-img>
                                </v-card>
                            </div>
                        </v-col>
                        <v-col
                            cols="12"
                            md="9"
                        >
                            <v-card>
                                <v-img
                                    :src="previewPic"
                                ></v-img>
                            </v-card>
                        </v-col>
                    </v-row>
                </v-col>
                <v-col
                    cols="12"
                    sm="6"
                >
                    <div>
                        <v-row>
                            <v-col cols="12">
                                <a href="/catalogo" class="black--text mb-3 body-2">Volver a la tienda</a>
                                <h1 class="font-weight-bold mb-6 mb-6 display-2">{{ singleProduct.name }}</h1>
                                <div class="mb-6">
                                    <span class="text-decoration-line-through display-1 grey--text" v-if="singleProduct.discount !== 0">Bs.{{ singleProduct.price }}</span>
                                    <span class="font-weight-medium display-1" style="color: #af2344">Bs.{{ singleProduct.price - singleProduct.discount }}</span>
                                </div>
                                <div class="body-2">
                                    Disponibilidad: <strong>{{ (singleProduct.stock > 0) ? 'D' : 'No d' }}isponible</strong>
                                </div>
                            </v-col>
                            <!-- actions -->
                            <v-col
                                cols="12"
                                md="auto"
                            >
                                <v-btn
                                    x-large
                                    color="green darken-2"
                                    dark
                                    @click="$store.dispatch('addItem', singleProduct.slug)"
                                >
                                    <v-icon left>
                                        mdi-cart
                                    </v-icon>
                                    Añadir a carrito
                                </v-btn>
                            </v-col>
                            <!-- details -->
                            <v-col cols="12">
                                <div v-html="singleProduct.description" class="c-description">
                                </div>
                            </v-col>
                            <!-- social -->
                            <v-col
                                cols="12"
                            >
                                <strong>Encuentranos en nuestras redes sociales</strong> <br>
                                <v-btn fab small class="mx-1">
                                    <v-icon>
                                        mdi-facebook
                                    </v-icon>
                                </v-btn>
                                <v-btn fab small class="mx-1">
                                    <v-icon>
                                        mdi-twitter
                                    </v-icon>
                                </v-btn>
                                <v-btn fab small class="mx-1">
                                    <v-icon>
                                        mdi-instagram
                                    </v-icon>
                                </v-btn>
                            </v-col>
                        </v-row>
                    </div>
                </v-col>
            </v-row>

            <v-row v-else>
                <v-col class="text-center">
                    cargando ...
                </v-col>
            </v-row>
        </v-container>
    </div>
</template>
<script>
export default {
    data() {
        return {
            previewPic: '',
            gallery: [],
            load: false,
            singleProduct: {}
        }
    },
    props: ['slug'],
    mounted() {
        this.getProduct();
    },
    methods: {
        changePreview(url) {
            this.previewPic = url;
        },
        getProduct() {
            axios.get(`single/${this.slug}`)
            .then((response) => {
                // console.log(response);
                this.singleProduct = response.data;
                this.previewPic = `/images/banners/${response.data.banner}`;
                this.gallery.push({url: `/images/banners/${response.data.banner}`});
                if (response.data.gallery.length > 0) {
                    response.data.gallery.forEach(img => {
                        this.gallery.push({url: `/images/galleries/${img.image}`});
                    });
                }
                this.load = true;
            })
            .catch((error) => {
                // console.log(error);
                location.reload();
            })
        }
    },
}
</script>