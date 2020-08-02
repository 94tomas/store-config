<template>
    <div>
        <v-breadcrumbs :items="breadcrumbs" class="elevation-2"></v-breadcrumbs>
        <v-row>
            <v-col cols="12">
                <div class="text-h6">
                    Editar producto <small class="text--secondary">( * indica campo requerido)</small>
                </div>
            </v-col>
        </v-row>
        <form @submit.prevent="formUpdate" v-if="load">
            <v-row>
                <v-col cols="12" sm="6" md="8">
                    <v-text-field
                        label="Nombre *"
                        outlined
                        dense
                        hint="Nombre del producto"
                        v-model="dataEdit.name"
                        :error-messages="(errors2.name) ? errors2.name[0] : ''"
                    ></v-text-field>
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
                    <v-text-field
                        label="Precio *"
                        outlined
                        dense
                        type="number"
                        min="0"
                        step="0.1"
                        hint="Precio total del producto en Bs."
                        v-model="dataEdit.price"
                        :error-messages="(errors2.price) ? errors2.price[0] : ''"
                    ></v-text-field>
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
                    <div class="mb-5">
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
                    </div>
                    <v-switch
                        v-model="dataEdit.publish"
                        :label="(dataEdit.publish) ? 'Disponible' : 'No disponible'"
                        dense
                        :error-messages="(errors2.publish) ? errors2.publish[0] : ''"
                    ></v-switch>
                </v-col>
                <v-col cols="12" sm="6" md="4">
                    <!-- banner -->
                    <div class="mb-15">
                        Imagen pricipal *
                        <div style="position: relative;">
                            <v-img
                                :src="previewImg2"
                                height="150"
                                class="img-response-100"
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
                        v-model="dataEdit.category_id"
                        :error-messages="(errors2.category_id) ? errors2.category_id[0] : ''"
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
                        v-model="dataEdit.attributes_id"
                    ></v-select>
                    <v-card class="pa-4 pb-1 mb-8" v-if="dataEdit.attributes_id.length !== 0">
                        <v-card-text class="pa-0 mb-3" v-for="(attr) in dataEdit.attributes_id" :key="attr.key">
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
                        Fotos <span class="ml-1 text-uppercase" style="font-size: 10px;">(Galería)</span>
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
                                        <span v-if="previewGallery2.length === maxImages2" style="font-size: 12px;">
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
                    <v-btn dark type="submit" large>Actualizar</v-btn>
                </v-col>
            </v-row>
        </form>
    </div>
</template>
<script>
export default {
    data() {
        return {
            load: false,
            dialogGallery: false,
            breadcrumbs: [
                {
                    text: 'Productos',
                    disabled: false,
                    href: '/admin',
                },
                {
                    text: 'Editar producto',
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
                attributes_id: [],
                gallery: []
            },
            previewImg2: '',
            // gallery
            previewGallery2: [],
            maxImages2: 3,
            errors2: {},
        }
    },
    props: ['id'],
    mounted() {
        if (localStorage.getItem('update')) {
            this.$notify.success("Producto actualizado con exito.");
            localStorage.removeItem('update');
        }
    },
    created() {
        this.getCategories();
        this.getAttributes();
        this.openProduct(this.id);
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
                if (JSON.stringify(response.data) !== '{}') {
                    this.dataEdit.id = response.data.id;
                    this.dataEdit.name = response.data.name;
                    this.dataEdit.description = response.data.description;
                    this.previewImg2 = `images/banners/${response.data.banner}`;
                    this.dataEdit.stock = response.data.stock;
                    this.dataEdit.price = response.data.price;
                    this.dataEdit.discount = response.data.discount;
                    this.dataEdit.publish = response.data.publish;
                    this.dataEdit.category_id = response.data.category_id;
                    response.data.attribute.forEach(element => {
                        this.dataEdit.attributes_id.push(element.id);
                    });
                    response.data.gallery.forEach(element => {
                        this.dataEdit.gallery.push(element.image);
                        this.previewGallery2.push(`images/galleries/${element.image}`);
                    });
                    // loading
                    this.load = true;
                } else {
                    window.location = '/admin';
                }
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
            formData.append('attributes', this.dataEdit.attributes_id);
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
                console.log(error);
                this.$notify.warning("Revise los campos por favor.");
                this.errors2 = error.response.data.errors;
            })
        },
    },
}
</script>