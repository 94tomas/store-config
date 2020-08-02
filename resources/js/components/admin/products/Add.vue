<template>
    <div>
        <v-breadcrumbs :items="breadcrumbs" class="elevation-2"></v-breadcrumbs>
        <v-row>
            <v-col cols="12">
                <div class="text-h6">
                    Añadir un nuevo producto <small class="text--secondary">( * indica campo requerido)</small>
                </div>
            </v-col>
        </v-row>
        <form @submit.prevent="formCreate">
            <v-row>
                <v-col cols="12" sm="6" md="8">
                    <v-text-field
                        label="Nombre *"
                        outlined
                        dense
                        hint="Nombre del producto"
                        v-model="data.name"
                        :error-messages="(errors.name) ? errors.name[0] : ''"
                    ></v-text-field>
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
                    <div class="mb-5">
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
                    </div>
                    <v-switch
                        v-model="data.publish"
                        :label="(data.publish) ? 'Disponible' : 'No disponible'"
                        dense
                        :error-messages="(errors.publish) ? errors.publish[0] : ''"
                    ></v-switch>
                </v-col>
                <v-col cols="12" sm="6" md="4">
                    <!-- banner -->
                    <div class="mb-15">
                        Imagen pricipal *
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
                    </div>
                    <!-- end banner -->
                    <v-select
                        :items="arrayCategories"
                        item-text="name"
                        item-value="id"
                        label="Categoría *"
                        dense
                        hint="Seleccione una categoría"
                        outlined
                        v-model="data.category_id"
                        :error-messages="(errors.category_id) ? errors.category_id[0] : ''"
                    ></v-select>
                    <!-- Attribute -->
                    <v-select
                        :items="arrayAttributes"
                        item-text="name"
                        item-value="id"
                        label="Atributos"
                        hint="Seleccione un atributo"
                        outlined
                        chips
                        small-chips
                        multiple
                        deletable-chips
                        v-model="data.attributes_id"
                    ></v-select>
                    <v-card class="pa-4 pb-1 mb-8" v-if="data.attributes_id.length !== 0">
                        <v-card-text class="pa-0 mb-3" v-for="(attr) in data.attributes_id" :key="attr.key">
                            <div v-for="(item) in arrayAttributes" :key="item.id">
                                <span v-if="attr === item.id">
                                    {{ item.name }}: {{ item.attribute }}
                                </span>
                            </div>
                        </v-card-text>
                    </v-card>
                    <!-- btn gallery -->
                    <v-btn
                        dark
                        block
                        @click="dialogGallery = true"
                    >
                        + Fotos <span class="ml-1 text-uppercase" style="font-size: 10px;">(Galería)</span>
                    </v-btn>
                </v-col>
            </v-row>
            <!-- Dialog gallery -->
            <v-dialog
                v-model="dialogGallery"
                max-width="500px"
            >
                <v-card>
                    <v-card-title>
                        Galería del producto
                    </v-card-title>
                    <v-card-text>
                        Galeria
                        <v-card outlined class="px-3 py-1" style="border: thin solid rgb(158, 158, 158)">
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
                                        <span v-if="previewGallery.length === maxImages" style="font-size: 12px;">
                                            Llego al límite de imagenes permitidas
                                        </span>
                                    </div>
                                </v-col>
                            </v-row>
                        </v-card>
                        <!-- end gallery -->
                    </v-card-text>
                    <v-card-actions class="px-6 pb-5">
                        <v-spacer></v-spacer>
                        <v-btn
                            dark
                            @click="dialogGallery = false"
                        >
                            Listo
                        </v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>
            <v-row>
                <v-col cols="12" class="text-center">
                    <v-btn dark type="submit" large>Registrar</v-btn>
                </v-col>
            </v-row>
        </form>
    </div>
</template>
<script>
import { VueEditor } from "vue2-editor";

export default {
    components: { VueEditor },
    data() {
        return {
            dialogGallery: false,
            breadcrumbs: [
                {
                    text: 'Productos',
                    disabled: false,
                    href: '/admin',
                },
                {
                    text: 'Nuevo producto',
                    disabled: true,
                    href: '',
                }
            ],
            // crud products
            arrayCategories: [],
            arrayAttributes: [],
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
                attributes_id: [],
                gallery: []
            },
            previewImg: '',
            // gallery
            previewGallery: [],
            maxImages: 3,
            errors: {},
        }
    },
    mounted() {
        if (localStorage.getItem('create')) {
            this.$notify.success("Producto añadido con exito.");
            localStorage.removeItem('create');
        }
    },
    created() {
        this.getCategories();
        this.getAttributes();
    },
    methods: {
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
        getAttributes() {
            axios.get('attributes')
            .then((response) => {
                // console.log(response);
                this.arrayAttributes = response.data;
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
            formData.append('attributes', this.data.attributes_id);
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
    },
}
</script>