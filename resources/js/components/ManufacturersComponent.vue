<template>
    <section>
 
        <div class="page-title">
            <span class="title">Fabricantes</span>
            <div class="description">
                Listagem dos Fabricantes
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            <div class="title">Fabricantes</div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="text-left col-sm-3"><input type="text" v-model="match" class="form-control" placeholder="Pesquisar"></div>
                            <div class="text-right col-sm-9">
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalSuccess" @click="resetData">
                                    Adicionar Fabricante
                                </button>
                            </div>
                        </div>
                        <table class="table table-striped" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Fabricante</th>
                                    <th>Acções</th>
                                </tr>
                            </thead>
                            <transition-group enter-active-class="animated fadeInUp" leave-active-class="animated fadeOutDown" tag="tbody" mode="out-in">

                                <tr v-for="manufacturer in manufacturersFiltered" :key="manufacturer.id">
                                    <td>{{ manufacturer.id }}</td>
                                    <td>{{ manufacturer.manufacturer }}</td>
                                    <td>
                                        <a class="btn btn-sm btn-info" href="" @click="edit(manufacturer.id)" data-toggle="modal" data-target="#modalSuccess">Editar</a>
                                        <a class="btn btn-sm btn-success" href="" @click="edit(manufacturer.id)" data-toggle="modal" data-target="#modalSuccess">Ver</a>
                                        <a class="btn btn-sm btn-danger" href="" @click.prevent="destroy(manufacturer.id)" >Apagar</a>
                                    </td>
                                </tr>
                            </transition-group>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade modal-success" id="modalSuccess" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel" v-show="data.id">Actualizar Fabricante</h4>
                        <h4 class="modal-title" id="myModalLabel" v-show="!data.id">Adicionar Fabricante</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <form @submit.prevent>
                                <div class="form-group col-sm-6">
                                    <label for="inputEmail4">Fabricante</label>
                                    <input type="text" class="form-control" id="inputEmail4" v-model="data.manufacturer" placeholder="exemplo: COERSUM" />
                                </div>

                            </form>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>                        
                        <button type="button" class="btn btn-success" data-dismiss="modal" v-show="data.id" @click="update(data.id)">
                            Actualizar Fabricante
                        </button>
                        <button
                            type="button" class="btn btn-success" data-dismiss="modal" v-show="!data.id" @click="store">
                            Adicionar Fabricante
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
    export default {
        mounted() {
            this.get();
        },

        data() {
            return {
                data: {
                    manufacturer: "",
                },
                match: "",
                manufacturers: [],
            };
        },

        methods: {
            get() {
                axios
                    .get("../api/manufacturers")
                    .then(response => (this.manufacturers = response.data))
                    .catch(error => console.log(error));
            },

            store() {
                axios
                    .post("../api/manufacturer/store", this.data)
                    .then(response => {
                        console.log(response);
                        if (response.data.success) {
                            swal("", response.data.message, "success")
                            this.get();
                        }
                    })
                    .catch(error => console.log(error));
            },

            destroy(id) {
                swal("", "Tem certeza que deseja apagar este fabricante?", "warning", {buttons: true, dangerMode: true}).then(result => {
                    if(result)
                        axios
                            .delete("../api/manufacturer/destroy/" + id)
                            .then(response => {
                                if (response.data.success) {
                                    this.get();
                                    swal("", response.data.message, "success")
                                }
                            })
                            .catch(error => console.log(error));
                })
            },

            edit(id) {
                axios.get("../api/manufacturer/edit/" + id).then(response => {
                    this.data.manufacturer = response.data.result.manufacturer;
                });
            },

            update(id) {
                axios
                    .put("../api/manufacturer/update/" + id, this.data)
                    .then(response => {
                        if (response.data.success) {
                            this.resetData();
                            this.get();
                            swal("", response.data.message, "success")
                            return true;
                        }
                        swal("", "Erro ao actualizar o fabricante!", "error");
                    })
                    .catch(error => console.log(error));
            },

            resetData() {
                this.data.manufacturer = "";
            }
        },

        computed: {
            manufacturersFiltered() {
                return this.manufacturers.filter(manufacturer => {
                    return (
                        manufacturer.manufacturer.toLowerCase().includes(this.match) 
                    );
                });
            }
        }
    };
</script>
