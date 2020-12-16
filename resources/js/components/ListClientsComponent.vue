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

    </section>
</template>

<script>
    export default {
        mounted() {
            this.get();
        },

        data() {
            return {
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
