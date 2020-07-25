<template>
    <div>
        <v-row align="center">
            <v-col cols="12" md="8">
                <v-text-field
                    solo
                    hide-details
                    label="Buscar producto"
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
                    Añadir producto
                </v-btn>
            </v-col>
        </v-row>

        <v-row v-if="products.length === 0">
            <v-col class="text-center">
                cargando ...
            </v-col>
        </v-row>
        <v-row v-else justify="center">
            <v-col
                cols="12"
                sm="6"
                md="4"
                v-for="(item) in products" :key="item.id"
            >
                <v-card>
                    <v-img
                        :src="`images/banners/${item.banner}`"
                        class="white--text align-end"
                        gradient="to bottom, rgba(0,0,0,.1), rgba(0,0,0,.5)"
                        height="100px"
                    >
                        <v-card-title>{{ item.name }}</v-card-title>
                    </v-img>

                    <v-card-actions>
                        <v-chip
                            :color="(item.publish) ? 'green' : 'red'"
                            outlined
                            x-small
                            >
                            {{ (item.publish) ? 'Publicado' : 'No publicado' }}
                        </v-chip>
                        <v-spacer></v-spacer>

                        <v-btn icon :href="`/producto/${item.slug}`">
                            <v-icon>mdi-eye</v-icon>
                        </v-btn>

                        <!-- <v-btn icon>
                            <v-icon>mdi-share-variant</v-icon>
                        </v-btn> -->

                        <v-btn icon @click="openProduct(item.id)">
                            <v-icon>mdi-pencil</v-icon>
                        </v-btn>

                        <v-btn icon @click="deleteProduct(item.id, item.name)">
                            <v-icon>mdi-delete</v-icon>
                        </v-btn>
                    </v-card-actions>
                </v-card>
            </v-col>

            <v-col cols="12">
                <div class="text-center py-3">
                    <v-pagination
                        v-model="page"
                        :length="totalPage"
                        :total-visible="5"
                        color="green darken-2"
                        dark
                        @input="changePage"
                    ></v-pagination>
                </div>
            </v-col>
        </v-row>

        <!-- create product -->
        <v-dialog
            v-model="dialogCreate"
            max-width="600px"
        >
            <v-card>
                <v-card-title>
                    <span class="headline">Añadir un nuevo producto</span>
                </v-card-title>
                <form @submit.prevent="formCreate">
                    <v-card-text>
                        <v-row class="mb-4">
                            <v-col cols="12" md="12" class="py-0">
                                <v-select
                                    :items="arrayCategories"
                                    item-text="name"
                                    item-value="id"
                                    label="Categoría *"
                                    dense
                                    hint="Escija una categoría"
                                    outlined
                                    v-model="data.category_id"
                                    :error-messages="(errors.category_id) ? errors.category_id[0] : ''"
                                ></v-select>
                            </v-col>
                            <!-- <v-col cols="12" md="12" class="py-0">
                                <v-file-input
                                    label="Banner *"
                                    outlined
                                    dense
                                    accept="image/*"
                                    hint="Imagen principal"
                                    prepend-icon=""
                                    append-icon="mdi-image"
                                    @change="upBanner"
                                    :error-messages="(errors.banner) ? errors.banner[0] : ''"
                                ></v-file-input>
                            </v-col> -->
                            <!-- banner -->
                            <v-col cols="12" md="6" offset-md="3" class="py-0 mb-15">
                                Banner *
                                <div style="position: relative;">
                                    <v-img
                                        :src="previewImg"
                                        height="150"
                                        style="background-color: grey"
                                    ></v-img>
                                    <v-btn
                                        absolute
                                        dark
                                        fab
                                        bottom
                                        right
                                        @click="openInputFile"
                                    >
                                        <v-icon>mdi-image</v-icon>
                                    </v-btn>
                                    <input type="file" @change="upBanner" class="d-none" ref="fileInput" accept="image/png, image/jpeg">
                                </div>
                                <div class="v-text-field__details mt-3" v-if="errors.banner">
                                    <div class="v-messages theme--light error--text" role="alert">
                                        <div class="v-messages__wrapper">
                                            <div class="v-messages__message">
                                                {{ errors.banner[0] }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </v-col>
                            <!-- end banner -->
                            <v-col cols="12" md="6" class="py-0">
                                <v-text-field
                                    label="Nombre *"
                                    outlined
                                    dense
                                    hint="Nombre del producto"
                                    v-model="data.name"
                                    :error-messages="(errors.name) ? errors.name[0] : ''"
                                ></v-text-field>
                            </v-col>
                            <v-col cols="12" md="6" class="py-0">
                                <v-text-field
                                    label="Stock *"
                                    outlined
                                    dense
                                    type="number"
                                    min="0"
                                    step="1"
                                    hint="Cantidad de producto existente"
                                    v-model="data.stock"
                                    :error-messages="(errors.stock) ? errors.stock[0] : ''"
                                ></v-text-field>
                            </v-col>
                            <v-col cols="12" md="6" class="py-0">
                                <v-text-field
                                    label="Precio *"
                                    outlined
                                    dense
                                    type="number"
                                    min="0"
                                    step="0.1"
                                    hint="Precio total del producto en Bs."
                                    v-model="data.price"
                                    :error-messages="(errors.price) ? errors.price[0] : ''"
                                ></v-text-field>
                            </v-col>
                            <v-col cols="12" md="6" class="py-0">
                                <v-text-field
                                    label="descuento"
                                    outlined
                                    dense
                                    type="number"
                                    min="0"
                                    step="0.1"
                                    hint="Descuento del producto en Bs."
                                    v-model="data.discount"
                                    :error-messages="(errors.discount) ? errors.discount[0] : ''"
                                ></v-text-field>
                            </v-col>
                            <v-col cols="12" md="12" class="pt-0 mb-5">
                                Descripción *
                                <vue-editor
                                    v-model="data.description"
                                    :editor-toolbar="customToolbar"
                                    :class="[(errors.description) ? 'editor-error' : '']"
                                ></vue-editor>
                                <div class="v-text-field__details" v-if="errors.description">
                                    <div class="v-messages theme--light error--text" role="alert">
                                        <div class="v-messages__wrapper">
                                            <div class="v-messages__message">
                                                {{ errors.description[0] }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </v-col>
                            <v-col cols="12" md="12" class="py-0">
                                <!-- <v-file-input
                                    small-chips
                                    multiple
                                    label="Galería"
                                    accept="image/*"
                                    dense
                                    outlined
                                    prepend-icon=""
                                    append-icon="mdi-image-multiple"
                                    hint="Galería de fotos del producto"
                                    @change="upGallery"
                                    :error-messages="(errors.gallery) ? errors.gallery[0] : ''"
                                ></v-file-input> -->
                                Galeria
                                <v-card outlined class="mb-7 px-5 py-3" style="border: thin solid rgb(158, 158, 158)">
                                    <input type="file"
                                        accept="image/png, image/jpeg"
                                        ref="fileGallery"
                                        class="d-none"
                                        @change="previewImage"
                                    >
                                    <v-row>
                                        <v-col
                                            cols="6"
                                            sm="3"
                                            v-for="(url, index) in previewGallery" :key="index"
                                        >
                                            <v-img
                                                :src="url"
                                                aspect-ratio="1"
                                                color="grey lighten-2"
                                                class="text-right"
                                            >
                                                <v-btn @click="removeImage(index)" fab dark small color="red darken-3">
                                                    <v-icon>mdi-delete</v-icon>
                                                </v-btn>
                                                <template v-slot:placeholder>
                                                    <v-row
                                                        class="fill-height ma-0"
                                                        align="center"
                                                        justify="center"
                                                    >
                                                        <v-progress-circular indeterminate color="grey lighten-5"></v-progress-circular>
                                                    </v-row>
                                                </template>
                                            </v-img>
                                        </v-col>
                                        <v-col
                                            cols="6"
                                            sm="3"
                                        >
                                            <div class="fill-height d-flex justify-center align-center py-3">
                                                <v-btn v-if="previewGallery.length !== maxImages" @click="addNewImage" fab large color="success">
                                                    <v-icon>mdi-plus</v-icon>
                                                </v-btn>
                                                <span v-if="previewGallery.length === maxImages">
                                                    Llego al límite de imagenes permitidas
                                                </span>
                                            </div>
                                        </v-col>
                                    </v-row>
                                </v-card>
                                <!-- end gallery -->
                            </v-col>
                            <v-col cols="12" md="12" class="py-0">
                                <v-switch
                                    v-model="data.publish"
                                    :label="(data.publish) ? 'Disponible' : 'No disponible'"
                                    dense
                                    :error-messages="(errors.publish) ? errors.publish[0] : ''"
                                ></v-switch>
                            </v-col>
                        </v-row>
                        <small>*indica campo requerido</small>
                    </v-card-text>
                    <v-card-actions class="pa-4">
                        <v-spacer></v-spacer>
                        <v-btn dark @click="dialogCreate = false">Cancelar</v-btn>
                        <v-btn dark type="submit">Añadir</v-btn>
                    </v-card-actions>
                </form>
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
                <form @submit.prevent="formUpdate">
                    <v-card-text>
                        <v-row class="mb-4">
                            <v-col cols="12" md="12" class="py-0">
                                <v-select
                                    :items="arrayCategories"
                                    item-text="name"
                                    item-value="id"
                                    label="Categoría *"
                                    dense
                                    hint="Escija una categoría"
                                    outlined
                                    v-model="dataEdit.category_id"
                                    :error-messages="(errors2.category_id) ? errors2.category_id[0] : ''"
                                ></v-select>
                            </v-col>
                            <!-- <v-col cols="12" md="12" class="py-0">
                                <v-file-input
                                    label="Banner *"
                                    outlined
                                    dense
                                    accept="image/*"
                                    hint="Imagen principal"
                                    prepend-icon=""
                                    append-icon="mdi-image"
                                ></v-file-input>
                            </v-col> -->
                            <v-col cols="12" md="6" offset-md="3" class="py-0 mb-15">
                                Banner *
                                <div style="position: relative;">
                                    <v-img
                                        :src="previewImg2"
                                        height="150"
                                        style="background-color: grey"
                                    ></v-img>
                                    <v-btn
                                        absolute
                                        dark
                                        fab
                                        bottom
                                        right
                                        @click="openInputFile2"
                                    >
                                        <v-icon>mdi-image</v-icon>
                                    </v-btn>
                                    <input type="file" @change="upBanner2" class="d-none" ref="fileInput2" accept="image/png, image/jpeg">
                                </div>
                                <div class="v-text-field__details mt-3" v-if="errors2.banner">
                                    <div class="v-messages theme--light error--text" role="alert">
                                        <div class="v-messages__wrapper">
                                            <div class="v-messages__message">
                                                {{ errors2.banner[0] }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </v-col>
                            <!-- update banner end -->
                            <v-col cols="12" md="6" class="py-0">
                                <v-text-field
                                    label="Nombre *"
                                    outlined
                                    dense
                                    hint="Nombre del producto"
                                    v-model="dataEdit.name"
                                    :error-messages="(errors2.name) ? errors2.name[0] : ''"
                                ></v-text-field>
                            </v-col>
                            <v-col cols="12" md="6" class="py-0">
                                <v-text-field
                                    label="Stock *"
                                    outlined
                                    dense
                                    type="number"
                                    min="0"
                                    step="1"
                                    hint="Cantidad de producto existente"
                                    v-model="dataEdit.stock"
                                    :error-messages="(errors2.stock) ? errors2.stock[0] : ''"
                                ></v-text-field>
                            </v-col>
                            <v-col cols="12" md="6" class="py-0">
                                <v-text-field
                                    label="Precio *"
                                    outlined
                                    dense
                                    type="number"
                                    min="0"
                                    step="0.1"
                                    hint="Precio del producto en Bs."
                                    v-model="dataEdit.price"
                                    :error-messages="(errors2.price) ? errors2.price[0] : ''"
                                ></v-text-field>
                            </v-col>
                            <v-col cols="12" md="6" class="py-0">
                                <v-text-field
                                    label="descuento"
                                    outlined
                                    dense
                                    type="number"
                                    min="0"
                                    step="0.1"
                                    hint="Descuento del producto en Bs."
                                    v-model="dataEdit.discount"
                                    :error-messages="(errors2.discount) ? errors2.discount[0] : ''"
                                ></v-text-field>
                            </v-col>
                            <v-col cols="12" md="12" class="pt-0 mb-5">
                                Descripción *
                                <vue-editor
                                    v-model="dataEdit.description"
                                    :editor-toolbar="customToolbar"
                                    :class="[(errors2.description) ? 'editor-error' : '']"
                                ></vue-editor>
                                <div class="v-text-field__details" v-if="errors2.description">
                                    <div class="v-messages theme--light error--text" role="alert">
                                        <div class="v-messages__wrapper">
                                            <div class="v-messages__message">
                                                {{ errors2.description[0] }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </v-col>
                            <!-- <v-col cols="12" md="12" class="py-0">
                                <v-file-input
                                    small-chips
                                    multiple
                                    label="Galería"
                                    accept="image/*"
                                    dense
                                    outlined
                                    prepend-icon=""
                                    append-icon="mdi-image-multiple"
                                    hint="Galería de fotos del producto"
                                ></v-file-input>
                            </v-col> -->
                            <v-col cols="12" md="12" class="py-0">
                                <!-- <v-file-input
                                    small-chips
                                    multiple
                                    label="Galería"
                                    accept="image/*"
                                    dense
                                    outlined
                                    prepend-icon=""
                                    append-icon="mdi-image-multiple"
                                    hint="Galería de fotos del producto"
                                    @change="upGallery"
                                    :error-messages="(errors.gallery) ? errors.gallery[0] : ''"
                                ></v-file-input> -->
                                Galeria
                                <v-card outlined class="mb-7 px-5 py-3" style="border: thin solid rgb(158, 158, 158)">
                                    <input type="file"
                                        accept="image/png, image/jpeg"
                                        ref="fileGallery2"
                                        class="d-none"
                                        @change="previewImage2"
                                    >
                                    <v-row>
                                        <v-col
                                            cols="6"
                                            sm="3"
                                            v-for="(url, index) in previewGallery2" :key="index"
                                        >
                                            <v-img
                                                :src="url"
                                                aspect-ratio="1"
                                                color="grey lighten-2"
                                                class="text-right"
                                            >
                                                <v-btn @click="removeImage2(index)" fab dark small color="red darken-3">
                                                    <v-icon>mdi-delete</v-icon>
                                                </v-btn>
                                                <template v-slot:placeholder>
                                                    <v-row
                                                        class="fill-height ma-0"
                                                        align="center"
                                                        justify="center"
                                                    >
                                                        <v-progress-circular indeterminate color="grey lighten-5"></v-progress-circular>
                                                    </v-row>
                                                </template>
                                            </v-img>
                                        </v-col>
                                        <v-col
                                            cols="6"
                                            sm="3"
                                        >
                                            <div class="fill-height d-flex justify-center align-center py-3">
                                                <v-btn v-if="previewGallery2.length !== maxImages2" @click="addNewImage2" fab large color="success">
                                                    <v-icon>mdi-plus</v-icon>
                                                </v-btn>
                                                <span v-if="previewGallery2.length === maxImages2">
                                                    Llego al límite de imagenes permitidas
                                                </span>
                                            </div>
                                        </v-col>
                                    </v-row>
                                </v-card>
                                <!-- end gallery -->
                            </v-col>
                            <v-col cols="12" md="12" class="py-0">
                                <v-switch
                                    v-model="dataEdit.publish"
                                    :label="(dataEdit.publish) ? 'Disponible' : 'No disponible'"
                                    dense
                                    :error-messages="(errors2.publish) ? errors2.publish[0] : ''"
                                ></v-switch>
                            </v-col>
                        </v-row>
                        <small>*indica campo requerido</small>
                    </v-card-text>
                    <v-card-actions class="pa-4">
                        <v-spacer></v-spacer>
                        <v-btn dark @click="dialogEdit = false">Cancelar</v-btn>
                        <v-btn dark type="submit">Actualizar</v-btn>
                    </v-card-actions>
                </form>
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
                    <span class="headline">{{ delName }}</span>
                </v-card-title>
                <form @submit.prevent="formDelete">
                    <v-card-text>
                        <v-alert
                            dense
                            outlined
                            type="error"
                        >
                            Al eliminar el producto, se elminará todos los datos referente a esta.
                        </v-alert>
                    </v-card-text>
                    <v-card-actions class="pa-4">
                        <v-spacer></v-spacer>
                        <v-btn dark @click="dialogDel = false">Cancelar</v-btn>
                        <v-btn dark type="submit">Eliminar</v-btn>
                    </v-card-actions>
                </form>
            </v-card>
        </v-dialog>
        <!-- end delete product -->
    </div>
</template>
<script>
import { VueEditor } from "vue2-editor";

export default {
    components: { VueEditor },
    data() {
        return {
            page: 1,
            totalPage: null,
            dialogCreate: false,
            dialogEdit: false,
            dialogDel: false,
            products: [],
            // crud products
            arrayCategories: [],
            customToolbar: [
                [{ header: [false, 3, 4, 5, 6] }],
                ["bold", "italic", "underline"],
                [
                    { align: "" },
                    { align: "center" },
                    { align: "right" },
                    { align: "justify" }
                ],
                [{ list: "ordered" }, { list: "bullet" }, { list: "check" }],
                ["blockquote"]
            ],
            data: {
                name: '',
                description: '',
                banner: null,
                stock: null,
                price: null,
                discount: 0,
                publish: false,
                category_id: null,
                gallery: []
            },
            previewImg: '',
            // gallery
            previewGallery: [],
            maxImages: 3,
            errors: {},
            // datas edit
            dataEdit: {
                id: null,
                name: '',
                description: '',
                banner: null,
                stock: null,
                price: null,
                discount: 0,
                publish: false,
                category_id: null,
                gallery: []
            },
            previewImg2: '',
            // gallery
            previewGallery2: [],
            maxImages2: 3,
            errors2: {},
            // datas delete
            delName: '',
            delId: null
        }
    },
    mounted() {
        if (localStorage.getItem('create')) {
            this.$notify.success("Producto añadido con exito.");
            localStorage.removeItem('create');
        }
        if (localStorage.getItem('update')) {
            this.$notify.success("Producto actualizado con exito.");
            localStorage.removeItem('update');
        }
        if (localStorage.getItem('delete')) {
            this.$notify.success("Producto eliminado.");
            localStorage.removeItem('delete');
        }
    },
    created() {
        this.listProducts();
        this.getCategories();
    },
    methods: {
        changePage(event) {
            this.page = event;
            this.listProducts();
        },
        // get products
        listProducts() {
            axios.get(`product/create?page=${this.page}`)
            .then((response) => {
                // console.log(response);
                this.products = response.data.data;
                this.totalPage = response.data.last_page;
            })
            .catch((error) => {
                console.log(error);
            })
        },
        getCategories() {
            axios.get('categories')
            .then((response) => {
                // console.log(response);
                this.arrayCategories = response.data;
            })
            .catch((error) => {
                console.log(error);
            })
        },
        // create product
        openInputFile() {
            this.$refs.fileInput.click();
        },
        upBanner(event) {
            const file = event.target.files[0];
            this.previewImg = URL.createObjectURL(file);
            this.data.banner = file;
        },
        // gallery
        addNewImage() {
            this.$refs.fileGallery.click();
        },
        previewImage (event) {
            const file = event.target.files[0];
            this.data.gallery.push(file);
            this.previewGallery.push(URL.createObjectURL(file));
        },
        removeImage(i) {
            this.previewGallery.splice(i, 1);
            this.data.gallery.splice(i, 1);
        },
        // end Gallery
        // end create product
        formCreate() {
            this.errors = {};
            const formData = new FormData();
            // datas products
            formData.append('name', this.data.name);
            formData.append('description', this.data.description);
            formData.append('banner', this.data.banner);
            formData.append('stock', (this.data.stock !== null) ? this.data.stock : '');
            formData.append('price', (this.data.price !== null) ? this.data.price : '');
            formData.append('discount', this.data.discount);
            formData.append('publish', (this.data.publish) ? 1 : 0);
            formData.append('category_id', (this.data.category_id !== null) ? this.data.category_id : '');
            for (let i = 0; i < this.data.gallery.length; i++) {
                formData.append(`gallery[${i}]`, this.data.gallery[i]);
            }

            axios.post('product', formData)
            .then((response) => {
                // console.log(response);
                if (response.data.msg === 'ok') {
                    localStorage.setItem('create', true);
                    location.reload();
                }
            })
            .catch((error) => {
                this.$notify.warning("Revise los campos por favor.");
                this.errors = error.response.data.errors;
            })
        },
        // ***************Edit product*******************//
        // edit product
        openInputFile2() {
            this.$refs.fileInput2.click();
        },
        upBanner2(event) {
            const file = event.target.files[0];
            this.previewImg2 = URL.createObjectURL(file);
            this.dataEdit.banner = file;
        },
        // gallery
        addNewImage2() {
            this.$refs.fileGallery2.click();
        },
        previewImage2 (event) {
            const file = event.target.files[0];
            this.dataEdit.gallery.push(file);
            this.previewGallery2.push(URL.createObjectURL(file));
        },
        removeImage2(i) {
            this.previewGallery2.splice(i, 1);
            this.dataEdit.gallery.splice(i, 1);
        },
        // end Gallery
        // end edit product
        openProduct(id) {
            this.previewGallery2 = [];
            this.dataEdit.gallery = [];
            axios.get(`product/${id}`)
            .then((response) => {
                // console.log(response);
                this.dataEdit.id = response.data.id;
                this.dataEdit.name = response.data.name;
                this.dataEdit.description = response.data.description;
                this.previewImg2 = `images/banners/${response.data.banner}`;
                this.dataEdit.stock = response.data.stock;
                this.dataEdit.price = response.data.price;
                this.dataEdit.discount = response.data.discount;
                this.dataEdit.publish = response.data.publish;
                this.dataEdit.category_id = response.data.category_id;
                response.data.gallery.forEach(element => {
                    this.dataEdit.gallery.push(element.image);
                    this.previewGallery2.push(`images/galleries/${element.image}`);
                });

                // open dialog
                this.dialogEdit = !this.dialogEdit;
            })
            .catch((error) => {
                console.log(error);
            })
        },
        formUpdate() {
            this.errors2 = {};
            const formData = new FormData();
            // datas products
            formData.append('name', this.dataEdit.name);
            formData.append('description', this.dataEdit.description);
            formData.append('banner', this.dataEdit.banner);
            formData.append('stock', (this.dataEdit.stock !== null) ? this.dataEdit.stock : '');
            formData.append('price', (this.dataEdit.price !== null) ? this.dataEdit.price : '');
            formData.append('discount', this.dataEdit.discount);
            formData.append('publish', (this.dataEdit.publish) ? 1 : 0);
            formData.append('category_id', (this.dataEdit.category_id !== null) ? this.dataEdit.category_id : '');
            for (let i = 0; i < this.dataEdit.gallery.length; i++) {
                formData.append(`gallery[${i}]`, this.dataEdit.gallery[i]);
            }
            formData.append('_method', 'PUT');

            axios.post(`product/${this.dataEdit.id}`, formData)
            .then((response) => {
                // console.log(response);
                if (response.data.msg === 'ok') {
                    localStorage.setItem('update', true);
                    location.reload();
                }
            })
            .catch((error) => {
                // console.log(error);
                this.$notify.warning("Revise los campos por favor.");
                this.errors2 = error.response.data.errors;
            })
        },
        // ---------------------------Delete product*************//
        deleteProduct(id, name) {
            this.delName = name;
            this.delId = id;
            this.dialogDel = !this.dialogDel;
        },
        formDelete() {
            axios.delete(`product/${this.delId}`)
            .then((response) => {
                // console.log(response);
                if (response.data.msg === 'ok') {
                    localStorage.setItem('delete', true);
                    location.reload();
                }
            })
            .catch((error) => {
                console.log(error);
            })
        }
    },
}
</script>