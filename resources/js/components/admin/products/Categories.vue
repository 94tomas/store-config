<template>
    <div>
        <v-breadcrumbs :items="breadcrumbs" class="elevation-2"></v-breadcrumbs>
        <v-row>
            <v-col cols="12" sm="6" md="4">
                <div class="text-h6">
                    Añadir categoría
                </div>
                <form @submit.prevent="formCreate">
                    <v-text-field
                        label="Nombre *"
                        outlined
                        dense
                        hint="Nombre de la categoría"
                        v-model="dataCat.name"
                    ></v-text-field>
                    <v-textarea
                        outlined
                        label="Descripción"
                        rows="2"
                        hint="Descripción de la categoría"
                        v-model="dataCat.description"
                    ></v-textarea>
                    <v-btn
                        block
                        dark
                        type="submit"
                    >
                        Añadir
                    </v-btn>
                </form>
            </v-col>

            <v-col cols="12" sm="6" md="8">
                <div class="text-h6">
                    Lista de categorías
                </div>
                <v-simple-table>
                    <template v-slot:default>
                        <thead>
                            <tr>
                                <th class="text-left">Nombre</th>
                                <th  >Descripción</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(item) in arrayCategories" :key="item.id">
                                <td>
                                    {{ item.name }}
                                </td>
                                <td>
                                    {{ item.description }}
                                </td>
                                <td class="text-right">
                                    <v-btn icon small @click="openCategory(item.id)">
                                        <v-icon>mdi-pencil</v-icon>
                                    </v-btn>
                                    <v-btn icon small @click="forDelete(item.id)">
                                        <v-icon>mdi-delete</v-icon>
                                    </v-btn>
                                </td>
                            </tr>
                        </tbody>
                    </template>
                </v-simple-table>
            </v-col>
        </v-row>

        <!-- Create categories -->
        <v-dialog
            v-model="dialogEdit"
            max-width="290"
        >
            <v-card>
                <v-card-title class="headline">Actualizar categoría</v-card-title>

                <v-card-text>
                    <form @submit.prevent="formEdit">
                        <v-text-field
                            label="Nombre *"
                            outlined
                            dense
                            hint="Nombre de la categoría"
                            v-model="dataEdit.name"
                        ></v-text-field>
                        <v-textarea
                            outlined
                            label="Descripción"
                            rows="2"
                            hint="Descripción de la categoría"
                            v-model="dataEdit.description"
                        ></v-textarea>
                        <v-card-actions>
                            <v-spacer></v-spacer>

                            <v-btn
                                color="green darken-1"
                                text
                                @click="dialogEdit = false"
                            >
                                Cancelar
                            </v-btn>

                            <v-btn
                                dark
                                type="submit"
                            >
                                Actualizar
                            </v-btn>
                        </v-card-actions>
                    </form>
                </v-card-text>
            </v-card>
        </v-dialog>
        <!-- end create categories -->
    </div>
</template>
<script>
export default {
    data() {
        return {
            breadcrumbs: [
                {
                    text: 'Productos',
                    disabled: false,
                    href: '/admin',
                },
                {
                    text: 'Categorías',
                    disabled: true,
                    href: '',
                }
            ],
            // Categories
            dataCat: {
                name: '',
                description: ''
            },
            arrayCategories: [],
            // Update
            dialogEdit: false,
            dataEdit: {
                id: '',
                name: '',
                description: ''
            },
        }
    },
    created() {
        this.getCategories();
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
        //************************** */ Create categoriea *********************************//
        formCreate() {
            axios.post('categories', this.dataCat)
            .then((response) => {
                // console.log(response);
                if (response.data.msg === 'ok') {
                    this.$notify.success("Nueva categoría creada.");
                    this.getCategories();
                    this.dataCat.name = '';
                    this.dataCat.description = '';
                }
            })
            .catch((error) => {
                console.log(error);
            })
        },
        //************************** */ edit categoriea *********************************//
        openCategory(id) {
            axios.get(`categories/${id}`)
            .then((response) => {
                // console.log(response);
                this.dataEdit.id = response.data.id;
                this.dataEdit.name = response.data.name;
                this.dataEdit.description = response.data.description;
                this.dialogEdit = true;
            })
            .catch((error) => {
                console.log(error);
            })
        },
        formEdit() {
            axios.put(`categories/${this.dataEdit.id}`, this.dataEdit)
            .then((response) => {
                // console.log(response);
                if (response.data.msg === 'ok') {
                    this.$notify.success("Categoría actualizada con éxito.");
                    this.dialogEdit = false;
                    this.getCategories();
                }
            })
            .catch((error) => {
                console.log(error);
            })
        },
        //************************** */ delete categoriea *********************************//
        forDelete(id) {
            if (confirm('¿Está seguro en eliminar la categoría?.')) {
                axios.delete(`categories/${id}`)
                .then((response) => {
                    // console.log(response);
                    if (response.data.msg === 'ok') {
                        this.$notify.success("Categoría eliminada.");
                        this.getCategories();
                    }
                    if (response.data.msg === 'denied') {
                        this.$notify.warning("Error, Algunos productos utilizan esta categoría.");
                        this.getCategories();
                    }
                })
                .catch((error) => {
                    console.log(error);
                })   
            }
        }
    },
}
</script>