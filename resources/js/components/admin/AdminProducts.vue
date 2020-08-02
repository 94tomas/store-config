<template>
    <div>
        <v-row align="center">
            <v-col cols="12" md="12">
                <v-text-field
                    solo
                    hide-details
                    label="Buscar producto"
                    append-icon="mdi-magnify"
                ></v-text-field>
            </v-col>
        </v-row>

        <v-container>
            <v-data-table
                :headers="headers"
                :items="products"
                class="elevation-1"
                hide-default-footer
            >
                <template v-slot:item.product="{ item }">
                    <v-list-item class="px-0">
                        <v-list-item-avatar class="rounded-0" height="60" width="60">
                            <v-img
                                :src="`/images/banners/${item.banner}`"
                            ></v-img>
                        </v-list-item-avatar>
                        <v-list-item-content>
                            <v-list-item-title>
                                <a :href="`/producto/${item.slug}`" class="text-decoration-none black--text" style="font-size: 14px;">
                                    {{ item.name }}
                                </a>
                            </v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                </template>
                <template v-slot:item.state="{ item }">
                    <v-chip
                        :color="(item.publish) ? 'green' : 'red'"
                        outlined
                        x-small
                        >
                        {{ (item.publish) ? 'Publicado' : 'No publicado' }}
                    </v-chip>
                </template>
                <template v-slot:item.category="{ item }">
                    {{ item.category.name }}
                </template>
                <template v-slot:item.attributes="{ item }">
                    <v-card class="pa-2 pb-1" outlined v-if="item.attribute.length > 0">
                        <v-card-text class="pa-0 mb-1" v-for="(attr, index) in item.attribute" :key="index">
                            <strong>{{ attr.name }} </strong>: {{ attr.attribute }}
                        </v-card-text>
                    </v-card>
                    <v-card class="pa-2 pb-1" outlined v-else>
                        ---
                    </v-card>
                </template>
                <template v-slot:item.actions="{ item }">
                    <v-btn icon :href="`/admin?page=edit&id=${item.id}`">
                        <v-icon>mdi-pencil</v-icon>
                    </v-btn>

                    <v-btn icon @click="deleteProduct(item.id, item.name)">
                        <v-icon>mdi-delete</v-icon>
                    </v-btn>
                </template>
            </v-data-table>

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
        </v-container>

        <!-- create product -->
        
        <!-- end create product -->

        <!-- update product -->
        
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
            dialogDel: false,
            products: [],
            headers: [
                {
                    text: 'Producto',
                    align: 'start',
                    sortable: false,
                    value: 'product',
                },
                { text: 'Estado', sortable: false, value: 'state' },
                { text: 'Categoría', sortable: false, value: 'category' },
                { text: 'Atributos', sortable: false, value: 'attributes' },
                { text: '', sortable: false, value: 'actions' },
            ],
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
            // datas delete
            delName: '',
            delId: null
        }
    },
    mounted() {
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
        // create-edit product
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