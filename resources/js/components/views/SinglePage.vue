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
            <v-row>
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
                                <h1 class="font-weight-bold mb-6 mb-6 display-2">Nombre del producto</h1>
                                <div class="mb-6">
                                    <span class="text-decoration-line-through display-1 grey--text">Bs.250</span>
                                    <span class="font-weight-medium display-1" style="color: #af2344">Bs.300</span>
                                </div>
                                <div class="body-2">
                                    Disponibilidad: <strong>Disponible</strong> <br>
                                    Vendedor: <strong>Nombre de la tienda</strong>
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
                                >
                                    <v-icon left>
                                        mdi-cart
                                    </v-icon>
                                    Añadir a carrito
                                </v-btn>
                            </v-col>
                            <!-- details -->
                            <v-col cols="12">
                                <div>
                                    <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Explicabo ut voluptatem omnis praesentium, necessitatibus ab nihil earum provident labore! Animi, debitis dolores? Quae, laborum soluta sit ex quod eaque officia.</p>
                                    <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Ullam, tempora iure pariatur illum, eaque assumenda voluptate fugiat quo veritatis libero atque provident qui fugit delectus quisquam incidunt nihil at reprehenderit!</p>
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
        </v-container>
    </div>
</template>
<script>
export default {
    data() {
        return {
            previewPic: 'https://source.unsplash.com/random/?vans-2',
            gallery: [
                {url: 'https://source.unsplash.com/random/?vans-2'},
                {url: 'https://source.unsplash.com/random/?vans-3'},
                {url: 'https://source.unsplash.com/random/?vans-4'}
            ]
        }
    },
    methods: {
        changePreview(url) {
            this.previewPic = url;
        }
    },
}
</script>