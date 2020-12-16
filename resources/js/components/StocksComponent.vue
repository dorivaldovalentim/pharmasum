<template>
    <section>
 
        <div class="page-title">
            <span class="title">Stock</span>
            <div class="description">
                Listagem dos Produtos no Stock
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            <div class="title">Produtos no Stock</div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="text-left col-sm-3"><input type="text" v-model="match" class="form-control" placeholder="Pesquisar"></div>
                            <div class="text-right col-sm-9">
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalSuccess" @click="resetData">
                                    Adicionar Produto
                                </button>
                            </div>
                        </div>
                        <table class="table table-striped" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Produto</th>
                                    <th>Quantidade</th>
                                    <th>Código de Barra</th>
                                    <th>Data de expiração</th>
                                    <th>Acções</th>
                                </tr>
                            </thead>
                            <transition-group enter-active-class="animated fadeInUp" leave-active-class="animated fadeOutDown" tag="tbody" mode="out-in">

                                <tr v-for="(product, pos) in productsFiltered" :key="product.id">
                                    <td>{{ product.id }}</td>
                                    <td>{{ product.product }}</td>
                                    <td>{{ product.qtd }}</td>
                                    <td>{{ product.barcode }}</td>
                                    <td>{{ product.expire_date }}</td>
                                    <td>
                                        <a class="btn btn-sm btn-info" href="" @click="edit(product)" data-toggle="modal" data-target="#modalSuccess">Alterar Quantidade</a>
                                        <a class="btn btn-sm btn-danger" href="" @click.prevent="destroy(product.id)" >Apagar</a>
                                    </td>
                                </tr>
                            </transition-group>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <form @submit.prevent>
            <!-- Modal -->
            <div class="modal fade modal-success" id="modalSuccess" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel" v-show="data.id">Actualizar Produto</h4>
                            <h4 class="modal-title" id="myModalLabel" v-show="!data.id">Adicionar Produto</h4>
                        </div>
                        <div class="modal-body">
                            <div class="row">

                                <div class="form-group col-md-6" v-show="!data.id">
                                    <label for="inputEmail4">Produto</label>
                                    <select class="form-control" v-model="data.product_id" required>
                                        <option v-for="product in products" v-bind:value="product.id">{{product.product}}</option>
                                    </select>
                                </div>

                                <div class="form-group col-md-6" v-show="!data.id">
                                    <label for="inputEmail4">Data de Expiração </label>
                                    <input type="date" class="form-control" id="inputEmail4" v-model="data.expireDate" required />
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="inputEmail4">Quantidade </label>
                                    <input type="number" min="1" class="form-control" id="inputEmail4" v-model="data.qtd" required />
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>                        
                            <button type="button" class="btn btn-success" data-dismiss="modal" v-show="data.id" @click="update()">
                                Actualizar Produto
                            </button>
                            <button
                                type="button" class="btn btn-success" data-dismiss="modal" v-show="!data.id" @click="store">
                                Adicionar Produto
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
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
                    product_id: "",
                    expireDate: "",
                    qtd: "",
                    id: ""
                },
                match: "",
                products: [],
                stock: [],
            };
        },

        methods: {
            get() {
                
                axios
                    .get("../api/stocks")
                    .then(response => {
                        this.products = response.data.products
                        this.stock = response.data.stock
                    })
                    .catch(error => console.log(error));
            },

            store() {
                axios.post("../api/stock/store", this.data)
                    .then(response => {
                        swal("", response.data.message, "success")
                        this.get();
                        
                    })
                    .catch(error => console.log(error));
            },

            destroy(id) {
                swal("", "Tem certeza que deseja apagar este produto do stock?", "warning", {buttons: true, dangerMode: true}).then(result => {
                    if(result)
                        axios.delete("../api/stock/destroy/" + id)
                            .then(response => {
                                if(response.data.success){
                                    this.get()
                                    swal("", response.data.message, "success");
                                }
                                else
                                    swal("", response.data.message, "error");
                                
                            })
                        .catch(error => console.log(error));
                })
            },

            edit(product) {
                this.data.id = product.id
                this.data.qtd = product.qtd;
            },

            update() {
                axios.put("../api/stock/update", this.data)
                    .then(response => {
                        if(response.data.success){
                            this.resetData();
                            this.get();
                            swal("", response.data.message, "success")
                        }
                        else
                            swal("", response.data.message, "error")

                    })
                    .catch(error => console.log(error));
            },

            resetData() {
                this.data.product_id = "";
                this.data.expireDate = "";
                this.data.qtd = "";
                this.data.id = "";
            }
        },

        computed: {
            productsFiltered() { 
                return this.stock.filter(product => {
                    return (
                        product.product.toLowerCase().includes(this.match) ||
                        product.barcode.toLowerCase().includes(this.match) ||
                        product.expire_date.toLowerCase().includes(this.match)
                    );
                });
            }
        }
    };
</script>
