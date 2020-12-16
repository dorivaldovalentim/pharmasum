<template>
    <section>
 
        <div class="page-title">
            <span class="title">Fornecedores</span>
            <div class="description">
                Listagem dos Fornecedores
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            <div class="title">Fornecedores</div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="text-left col-sm-3"><input type="text" v-model="match" class="form-control" placeholder="Pesquisar"></div>
                            <div class="text-right col-sm-9">
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalSuccess" @click="resetData">
                                    Adicionar Fornecedor
                                </button>
                            </div>
                        </div>
                        <table class="table table-striped" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nome Completo</th>
                                    <th>Telefone</th>
                                    <th>Email</th>
                                    <th>Acções</th>
                                </tr>
                            </thead>
                            <transition-group enter-active-class="animated fadeInUp" leave-active-class="animated fadeOutDown" tag="tbody" mode="out-in">

                                <tr v-for="provider in providersFiltered" :key="provider.id">
                                    <td>{{ provider.id }}</td>
                                    <td>{{ provider.name }}</td>
                                    <td>{{ provider.phone }}</td>
                                    <td>{{ provider.email }}</td>
                                    <td>
                                        <a class="btn btn-sm btn-info" href="" @click="edit(provider.id)" data-toggle="modal" data-target="#modalSuccess">Editar</a>
                                        <a class="btn btn-sm btn-success" href="" @click="edit(provider.id)" data-toggle="modal" data-target="#modalSuccess">Ver</a>
                                        <a class="btn btn-sm btn-danger" href="" @click.prevent="destroy(provider.id)" >Apagar</a>
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
                        <h4 class="modal-title" id="myModalLabel" v-show="data.id">Actualizar Fornecedor</h4>
                        <h4 class="modal-title" id="myModalLabel" v-show="!data.id">Adicionar Fornecedor</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <form @submit.prevent>
                                <div class="form-group col-sm-6">
                                    <label for="inputEmail4">Nome</label>
                                    <input type="text" class="form-control" id="inputEmail4" v-model="data.name" placeholder="exemplo: Jefth" />
                                </div>
                                
                                <div class="form-group col-md-6">
                                    <label for="inputEmail4">Email</label>
                                    <input type="email" class="form-control" id="inputEmail4" v-model="data.email" placeholder="exemplo: jefthvalentim@hotmail.com" />
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="inputEmail4">Telefone</label>
                                    <input type="text" class="form-control" id="inputEmail4" v-model="data.phone_number" placeholder="exemplo: 913 299 172" />
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="inputEmail4">Morada</label>
                                    <input type="text" class="form-control" id="inputEmail4" v-model="data.address" placeholder="exemplo: Luanda, Ngola Kiluanje, Rua do Bate nú" />
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>                        
                        <button type="button" class="btn btn-success" data-dismiss="modal" v-show="data.id" @click="update(data.id)">
                            Actualizar Fornecedor
                        </button>
                        <button
                            type="button" class="btn btn-success" data-dismiss="modal" v-show="!data.id" @click="store">
                            Adicionar Fornecedor
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
                    email: "",
                    name: "",
                    address: "",
                    phone_number: "",
                    id: ""
                },
                match: "",
                providers: [],
            };
        },

        methods: {
            get() {
                axios
                    .get("../api/providers")
                    .then(response => (this.providers = response.data))
                    .catch(error => console.log(error));
            },

            store() {
                axios
                    .post("../api/provider/store", this.data)
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
                swal("", "Tem certeza que deseja apagar esta fornecedor?", "warning", {buttons: true, dangerMode: true}).then(result => {
                    if(result)
                        axios
                            .delete("../api/provider/destroy/" + id)
                            .then(response => {
                                if (response.data.success) {
                                    this.get();
                                    alert("Fornecedor apagado com sucesso!");
                                }
                            })
                        .catch(error => console.log(error));
                })
            },

            edit(id) {
                axios.get("../api/provider/edit/" + id).then(response => {
                    this.data.name = response.data.result.name;
                    this.data.email = response.data.result.email;
                    this.data.address = response.data.result.address;
                    this.data.id = response.data.result.id;
                    this.data.phone_number = response.data.result.phone;
                });
            },

            update(id) {
                axios
                    .put("../api/provider/update/" + id, this.data)
                    .then(response => {
                        if (response.data.success) {
                            this.resetData();
                            this.get();
                            swal("", response.data.message, "error")
                            return true;
                        }
                        swal("", "Erro ao actualizar o fornecedor!", "error");
                    })
                    .catch(error => console.log(error));
            },

            resetData() {
                this.data.name = "";
                this.data.email = "";
                this.data.address = "";
                this.data.id = "";
                this.data.phone_number = "";
            }
        },

        computed: {
            providersFiltered() {
                return this.providers.filter(provider => {
                    return (
                        provider.name.toLowerCase().includes(this.match) ||
                        provider.phone.toLowerCase().includes(this.match) ||
                        provider.email.toLowerCase().includes(this.match)
                    );
                });
            }
        }
    };
</script>
