<template>
    <div>
        <v-container>
            <div class="py-5">
                <div class="text-h4 text-center text-capitalize font-weight-bold mb-5">Productos</div>
                <v-divider></v-divider>
                <v-row align="center">
                    <v-col cols="12" sm="4">
                        <v-select
                            :items="arrayCategories"
                            item-text="name"
                            item-value="id"
                            label="Buscar por categoría"
                            dense
                            hide-details
                            outlined
                            v-model="byCategory"
                            @change="filterByCategory"
                        ></v-select>
                    </v-col>
                    <v-col cols="12" sm="4" class="text-center">
                        {{ lengthP }} productos
                    </v-col>
                    <v-col cols="12" sm="4" class="text-right">
                        <v-text-field
                            label="Buscar producto por nombre"
                            outlined
                            dense
                            hide-details
                            append-icon="mdi-feature-search"
                            v-model="byTitle"
                            @input="filterByTitle"
                        ></v-text-field>
                    </v-col>
                </v-row>
                <v-divider class="mb-5"></v-divider>
                <!-- list products -->
                <!-- list products -->
                <v-row v-if="listProduct.length === 0">
                    <v-col class="text-center" v-if="lengthP !== 0">
                        cargando ...
                    </v-col>
                    <v-col class="text-center" v-else>
                        Sin productos
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
                                        <a
                                            :href="`/producto/${item.slug}`"
                                            v-if="hover"
                                            class="d-flex transition-fast-in-fast-out black darken-2 v-card--reveal display-2 white--text text-decoration-none"
                                            style="height: 100%;"
                                        >
                                            Bs.{{ item.price - item.discount }}
                                        </a>
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
                                        :href="`/producto/${item.slug}`"
                                    >
                                        <v-icon>mdi-eye</v-icon>
                                    </v-btn>
                                    <div class="font-weight-light title mb-2">
                                        <span class="text-decoration-line-through grey--text" v-if="item.discount !== 0">Bs.{{ item.price }}</span>
                                        <span class="deep-orange--text">Bs.{{ item.price - item.discount }}</span>
                                    </div>
                                    <div class="subtitle-1 font-weight-light black--text mb-0">{{ item.name }}</div>
                                    {{item.category.name}}
                                </v-card-text>
                                <v-card-actions class="px-4 pb-4">
                                    <v-spacer></v-spacer>
                                    <v-btn
                                        v-if="item.attribute.length == 0"
                                        dark
                                        @click="$store.dispatch('addItem', {slug: item.slug, attribute: null})"
                                    >
                                        <v-icon left>
                                            mdi-cart-arrow-down
                                        </v-icon>
                                        Comprar
                                    </v-btn>
                                    <v-btn
                                        v-else
                                        dark
                                        :href="`/producto/${item.slug}`"
                                    >
                                        <v-icon left>
                                            mdi-cart-plus
                                        </v-icon>
                                        Mas opciones
                                    </v-btn>
                                </v-card-actions>
                            </v-card>
                        </v-hover>
                    </v-col>
                </v-row>
            </div>

            <div class="text-center pb-5 pt-3">
                <v-pagination
                    v-model="page"
                    :length="totalPage"
                    :total-visible="5"
                    color="green darken-2"
                    dark
                    @input="changePage"
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
            totalPage: null,
            arrayCategories: [],
            listProduct: [],
            byCategory: 'all',
            byTitle: '',
            lengthP: null
        }
    },
    created() {
        this.getProduct();
        this.getCategories();
    },
    methods: {
        changePage(event) {
            this.page = event;
            this.getProduct();
        },
        filterByCategory(event) {
            this.byCategory = event;
            this.page = 1;
            this.getProduct();
        },
        filterByTitle(event) {
            this.byTitle = event;
            this.page = 1;
            this.getProduct();
        },
        // 
        getProduct() {
            axios.get(`list-product?page=${this.page}&cat=${this.byCategory}&title=${this.byTitle}`)
            .then((response) => {
                // console.log(response);
                this.lengthP = response.data.total;
                this.listProduct = response.data.data;
                this.totalPage = response.data.last_page;
            })
            .catch((error) => {
                console.log(error);
            })
        },
        // get categories
        getCategories() {
            axios.get('categories')
            .then((response) => {
                // console.log(response);
                this.arrayCategories = response.data;
                this.arrayCategories.unshift({id: 'all', name: 'Todos los productos'});
            })
            .catch((error) => {
                console.log(error);
            })
        },
    },
}
</script>