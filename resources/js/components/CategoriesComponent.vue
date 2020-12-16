<template>
    <section>
        <div class="page-title">
            <span class="title">Categorias</span>
            <div class="description">
                Listagem das Categorias
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            <div class="title">Categorias</div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="text-left col-sm-3"><input type="text" v-model="match" class="form-control" placeholder="Pesquisar"></div>
                            <div class="text-right col-sm-9">
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalSuccess" @click="resetData">
                                    Adicionar Categoria
                                </button>
                            </div>
                        </div>
                        <table class="table table-striped" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Categoria</th>
                                    <th>Acções</th>
                                </tr>
                            </thead>
                            <transition-group enter-active-class="animated fadeInUp" leave-active-class="animated fadeOutDown" tag="tbody" mode="out-in">
                                <tr v-for="category in categoriesFiltered" :key="category.id">
                                        
                                    <td>{{ category.id }}</td>
                                    <td>{{ category.category }}</td>
                                    <td>
                                        <a class="btn btn-sm btn-info" href="" @click="edit(category.id)" data-toggle="modal" data-target="#modalSuccess">Editar</a>
                                        <a class="btn btn-sm btn-success" href="" @click="edit(category.id)" data-toggle="modal" data-target="#modalSuccess">Ver</a>
                                        <a class="btn btn-sm btn-danger" href="" @click.prevent="destroy(category.id)" >Apagar</a>
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
                        <h4 class="modal-title" id="myModalLabel" v-show="data.id">Actualizar Categoria</h4>
                        <h4 class="modal-title" id="myModalLabel" v-show="!data.id">Adicionar Categoria</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <form @submit.prevent>
                                <div class="form-group col-sm-6">
                                    <label for="inputEmail4">Categoria</label>
                                    <input type="text" class="form-control" id="inputEmail4" v-model="data.category" placeholder="exemplo: Comprimido" />
                                </div>

                            </form>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>                        
                        <button type="button" class="btn btn-success" data-dismiss="modal" v-show="data.id" @click="update(data.id)">
                            Actualizar Categoria
                        </button>
                        <button
                            type="button" class="btn btn-success" data-dismiss="modal" v-show="!data.id" @click="store">
                            Adicionar Categoria
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
                show: true,
                data: {
                    category: "",
                },
                match: "",
                categories: [],
            };
        },

        methods: {
            get() {
                axios
                    .get("../api/categories")
                    .then(response => (this.categories = response.data))
                    .catch(error => console.log(error));
            },

            store() {
                axios
                    .post("../api/category/store", this.data)
                    .then(response => {
                        
                        if (response.data.success) {
                            this.get();
                            setTimeout(_ => swal("", response.data.message, "success"), 2000)
                        }
                    })
                    .catch(error => console.log(error));
            },

            destroy(id) {
                
                swal("", "Tem certeza que deseja apagar esta categoria?", "warning", {buttons: true, dangerMode: true}).then(result => {
                    if(result)
                        axios
                            .delete("../api/category/destroy/" + id)
                            .then(response => {
                                if (response.data.success) {
                                    this.get();
                                    setTimeout(_ => swal("", "Categoria apagado com sucesso!", "success"), 2000);
                                }
                            })
                            .catch(error => console.log(error));
                })
            },

            edit(id) {
                axios.get("../api/category/edit/" + id).then(response => {
                    this.data.category = response.data.result.category;
                    this.data.id = id;
                });
            },

            update(id) {
                axios
                    .put("../api/category/update/" + id, this.data)
                    .then(response => {
                        if (response.data.success) {
                            this.resetData();
                            this.get();
                            swal("", "Categoria actualizada com sucesso!", "success");
                            return true;
                        }
                        swal("", "Erro ao actualizar o categoria!", "error");
                    })
                    .catch(error => console.log(error));
            },

            resetData() {
                this.data.category = "";
            }
        },

        computed: {
            categoriesFiltered() {
                return this.categories.filter(category => {
                    return (
                        category.category.toLowerCase().includes(this.match) 
                    );
                });
            }
        }
    };
</script>
