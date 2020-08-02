<template>
    <div>
        <v-breadcrumbs :items="breadcrumbs" class="elevation-2"></v-breadcrumbs>
        <v-row>
            <v-col cols="12" sm="6" md="4">
                <div class="text-h6">
                    Añadir atributo
                </div>
                <form @submit.prevent="formCreate">
                    <v-text-field
                        label="Nombre *"
                        outlined
                        dense
                        hint="Nombre del atributo"
                        v-model="data.name"
                    ></v-text-field>
                    <v-text-field
                        label="Atributos *"
                        outlined
                        dense
                        hint="Por favor separe los atributos por comas, ej: uno,dos,etc"
                        v-model="data.attribute"
                    ></v-text-field>
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
                    Lista de Atributos
                </div>
                <v-simple-table>
                    <template v-slot:default>
                        <thead>
                            <tr>
                                <th class="text-left">Nombre</th>
                                <th >Atributos</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(item) in arrayAttributes" :key="item.id">
                                <td>
                                    {{ item.name }}
                                </td>
                                <td>
                                    {{ item.attribute }}
                                </td>
                                <td class="text-right">
                                    <v-btn icon small @click="openAttribute(item.id)">
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

        <!-- Edit attributes -->
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
                        <v-text-field
                            label="Atributos *"
                            outlined
                            dense
                            hint="Por favor separe los atributos por comas, ej: uno,dos,etc"
                            v-model="dataEdit.attribute"
                        ></v-text-field>
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
        <!-- end edit attributes -->
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
                    text: 'Atributos',
                    disabled: true,
                    href: '',
                }
            ],
            // datas attributes
            data: {
                name: '',
                attribute: ''
            },
            arrayAttributes: [],
            // Update
            dialogEdit: false,
            dataEdit: {
                id: '',
                name: '',
                attribute: ''
            },
        }
    },
    created() {
        this.getAttributes();
    },
    methods: {
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
        //************************** */ Create categoriea *********************************//
        formCreate() {
            axios.post('attributes', this.data)
            .then((response) => {
                // console.log(response);
                if (response.data.msg === 'ok') {
                    this.$notify.success("Nuevo atributo creada.");
                    this.getAttributes();
                    this.data.name = '';
                    this.data.attribute = '';
                }
            })
            .catch((error) => {
                console.log(error);
            })
        },
        //************************** */ edit attributes *********************************//
        openAttribute(id) {
            axios.get(`attributes/${id}`)
            .then((response) => {
                // console.log(response);
                this.dataEdit.id = response.data.id;
                this.dataEdit.name = response.data.name;
                this.dataEdit.attribute = response.data.attribute;
                this.dialogEdit = true;
            })
            .catch((error) => {
                console.log(error);
            })
        },
        formEdit() {
            axios.put(`attributes/${this.dataEdit.id}`, this.dataEdit)
            .then((response) => {
                // console.log(response);
                if (response.data.msg === 'ok') {
                    this.$notify.success("Atributo actualizado con éxito.");
                    this.dialogEdit = false;
                    this.getAttributes();
                }
            })
            .catch((error) => {
                console.log(error);
            })
        },
        //************************** */ delete categoriea *********************************//
        forDelete(id) {
            if (confirm('Si elimina el atributo, también afectará a los productos. ¿Desea continuar?.')) {
                axios.delete(`attributes/${id}`)
                .then((response) => {
                    // console.log(response);
                    if (response.data.msg === 'ok') {
                        this.$notify.success("Atributo eliminado.");
                        this.getAttributes();
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