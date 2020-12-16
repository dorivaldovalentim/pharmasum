<template>
    <section>
 
        <div class="page-title">
            <span class="title">Clientes</span>
            <div class="description">
                Listagem dos Clientes
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            <div class="title">Clientes</div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="text-left col-sm-3"><input type="text" v-model="match" class="form-control" placeholder="Pesquisar"></div>
                            <div class="text-right col-sm-9">
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalSuccess" @click="resetData">
                                    Adicionar Cliente
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
                                <tr v-for="client in clientsFiltered" :key="client.id">
                                    <td>{{ client.id }}</td>
                                    <td>{{ client.first_name }} {{ client.last_name }}</td>
                                    <td>{{ client.phone }}</td>
                                    <td>{{ client.email }}</td>
                                    <td>
                                        <a class="btn btn-sm btn-info" href="" @click="edit(client.id)" data-toggle="modal" data-target="#modalSuccess">Editar</a>
                                        <a class="btn btn-sm btn-success" href="" @click="edit(client.id)" data-toggle="modal" data-target="#modalSuccess">Ver</a>
                                        <a class="btn btn-sm btn-danger" href="" @click.prevent="destroy(client.id)" >Apagar</a>
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
                        <h4 class="modal-title" id="myModalLabel" v-show="data.id">Actualizar Cliente</h4>
                        <h4 class="modal-title" id="myModalLabel" v-show="!data.id">Adicionar Cliente</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <form @submit.prevent>
                                <div class="form-group col-sm-6">
                                    <label for="inputEmail4">Nome</label>
                                    <input type="text" class="form-control" id="inputEmail4" v-model="data.first_name" placeholder="exemplo: Jefth" />
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="inputEmail4">Sobrenome</label>
                                    <input type="text" class="form-control" id="inputEmail4" v-model="data.last_name" placeholder="exemplo: Valentim" />
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
                            Actualizar Cliente
                        </button>
                        <button
                            type="button" class="btn btn-success" data-dismiss="modal" v-show="!data.id" @click="store">
                            Adicionar Cliente
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
                    first_name: "",
                    last_name: "",
                    address: "",
                    phone_number: "",
                    id: ""
                },
                match: "",
                clients: [],
            };
        },

        methods: {
            get() {
                axios
                    .get("../api/clients")
                    .then(response => (this.clients = response.data))
                    .catch(error => console.log(error));
            },

            store() {
                axios
                    .post("../api/client/store", this.data)
                    .then(response => {
                        if (response.data.success) {
                            swal("", response.data.message, "success")
                            this.get();
                        }
                    })
                    .catch(error => console.log(error));
            },

            destroy(id) {
                swal("", "Tem certeza que deseja apagar este cliente?", "warning", {buttons: true, dangerMode: true}).then(result => {
                    if(result)
                        axios
                            .delete("../api/client/destroy/" + id)
                            .then(response => {
                                if (response.data.success) {
                                    this.get();
                                    alert("Cliente apagado com sucesso!");
                                }
                            })
                        .catch(error => console.log(error));
                })
            },

            edit(id) {
                axios.get("../api/client/edit/" + id).then(response => {
                    this.data.first_name = response.data.result.first_name;
                    this.data.last_name = response.data.result.last_name;
                    this.data.email = response.data.result.email;
                    this.data.address = response.data.result.address;
                    this.data.id = response.data.result.id;
                    this.data.phone_number = response.data.result.phone;
                });
            },

            update(id) {
                axios
                    .put("../api/client/update/" + id, this.data)
                    .then(response => {
                        if (response.data.success) {
                            this.resetData();
                            this.get();
                            swal("", response.data.message, "success")
                            return true;
                        }
                        swal("", "Erro ao actualizar o cliente!", "error");
                    })
                    .catch(error => console.log(error));
            },

            resetData() {
                this.data.first_name = "";
                this.data.last_name = "";
                this.data.email = "";
                this.data.address = "";
                this.data.id = "";
                this.data.phone_number = "";
            }
        },

        computed: {
            clientsFiltered() {
                return this.clients.filter(client => {
                    return (
                        client.first_name.toLowerCase().includes(this.match) ||
                        client.last_name.toLowerCase().includes(this.match) ||
                        client.phone.toLowerCase().includes(this.match) ||
                        client.email.toLowerCase().includes(this.match)
                    );
                });
            }
        }
    };
</script>
