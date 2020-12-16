<template>
    <section>
 
        <div class="page-title">
            <span class="title">Produtos</span>
            <div class="description">
                Listagem dos Produtos
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            <div class="title">Produtos</div>
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
                                    <th>Produto</th>
                                    <th>Categoria</th>
                                    <th>Fabricante</th>
                                    <th>Detalhe</th>
                                    <th>Código de Barra</th>
                                    <!-- <th>Prateleira</th> -->
                                    <th>Quantidade no Stock</th>
                                    <th>Acções</th>
                                </tr>
                            </thead> 
                            <transition-group enter-active-class="animated fadeInUp" leave-active-class="animated fadeOutDown" tag="tbody" mode="out-in">

                                <tr v-for="product in productsFiltered" :key="product.id">
                                    <td>{{ product.product }}</td>
                                    <td>{{ product.category }}</td>
                                    <td>{{ product.manufacturer }}</td>
                                    <td>{{ product.details }}</td>
                                    <td>{{ product.barcode }}</td>
                                    <!-- <td>{{ product.place }}</td> -->
                                    <td>{{ product.qtd }}</td>
                                    <td>
                                        <a class="btn btn-sm btn-info" href="" @click="edit(product.id)" data-toggle="modal" data-target="#modalSuccess">Editar</a>
                                        <a class="btn btn-sm btn-success" href="" @click="edit(product.id)" data-toggle="modal" data-target="#modalSuccess">Ver</a>
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
                                <div class="form-group col-sm-6">
                                    <label for="inputEmail4">Produto</label>
                                    <input type="text" class="form-control" id="inputEmail4" v-model="data.product" placeholder="exemplo: Paracetamol" required />
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="inputEmail4">Código de barra</label>
                                    <input type="text" class="form-control" id="inputEmail4" v-model="data.barcode" placeholder="exemplo: 913299172" required />
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="inputEmail4">Categoria</label>
                                    <select class="form-control" v-model="data.category_id" required>
                                        <option v-for="category in categories" v-bind:value="category.id">{{category.category}}</option>
                                    </select>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="inputEmail4">Fabricante</label>
                                    <select class="form-control" v-model="data.manufacturer_id" required>
                                        <option v-for="manufacturer in manufacturers" v-bind:value="manufacturer.id">{{manufacturer.manufacturer}}</option>
                                    </select>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="inputEmail4">Detalhes</label>
                                    <input type="text" class="form-control" id="inputEmail4" v-model="data.details" placeholder="exemplo: 2mg" required />
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="inputEmail4">Preço</label>
                                    <input type="text" class="form-control" id="inputEmail4" v-model="data.price" placeholder="exemplo: 2000" required />
                                </div>

                                <!-- <div class="form-group col-md-6">
                                    <label for="inputEmail4">Prateleira</label>
                                    <input type="text" class="form-control" id="inputEmail4" v-model="data.place" placeholder="exemplo: 2" required />
                                </div> -->
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>                        
                            <button type="button" class="btn btn-success" data-dismiss="modal" v-show="data.id" @click="update(data.id)">
                                Actualizar Produto
                            </button>
                            <button type="submit" class="btn btn-success" data-dismiss="modal" v-show="!data.id" @click="store">
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
                    product: "",
                    category_id: "",
                    manufacturer_id: "",
                    details: "",
                    barcode: "",
                    price: "",
                    place: "",
                    id: ""
                },
                match: "",
                products: [],
                categories: [],
                manufacturers: [],
            };
        },

        methods: {
            get() {
                axios
                    .get("../api/products")
                    .then(response => {
                        this.products = response.data.products
                        this.categories = response.data.categories
                        this.manufacturers = response.data.manufacturers
                    })
                    .catch(error => console.log(error));
            },

            store() {
                axios.post("../api/product/store", this.data)
                    .then(response => {
                        if (response.data.success) {
                            swal("", response.data.message, "success")
                            this.get();
                        }
                    })
                    .catch(error => console.log(error));
            },

            destroy(id) {
                swal("", "Tem certeza que deseja apagar este produto?", "warning", {buttons: true, dangerMode: true}).then(result => {
                    if(result)
                        axios.delete("../api/product/destroy/" + id)
                            .then(response => {
                                if (response.data.success) {
                                    this.get()
                                    swal("", "Produto apagado com sucesso!", "success");
                                }
                            })
                        .catch(error => console.log(error));
                })
            },

            edit(id) {
                axios.get("../api/product/edit/" + id).then(response => {
                    this.data.product = response.data.result.product;
                    this.data.category_id = response.data.result.category_id;
                    this.data.manufacturer_id = response.data.result.manufacturer_id;
                    this.data.id = response.data.result.id;
                    this.data.details = response.data.result.details;
                    this.data.barcode = response.data.result.barcode;
                    this.data.price = response.data.result.price;
                    this.data.place = response.data.result.place;
                })
            },

            update(id) {
                axios.put("../api/product/update/" + id, this.data)
                    .then(response => {
                        if (response.data.success) {
                            this.resetData();
                            this.get();
                            swal("", response.data.message, "success")
                            return true;
                        }
                        swal("", "Erro ao actualizar o produto!", "error");
                    })
                    .catch(error => console.log(error));
            },

            resetData() {
                this.data.product = "";
                this.data.category_id = "";
                this.data.manufacturer_id = "";
                this.data.id = "";
                this.data.details = "";
                this.data.barcode = "";
                this.data.price = "";
                this.data.place = "";
            }
        },

        computed: {
            productsFiltered() {
                return this.products.filter(product => {
                    return (
                        product.product.toLowerCase().includes(this.match) ||
                        product.category.toLowerCase().includes(this.match) ||
                        product.barcode.toLowerCase().includes(this.match) ||
                        product.manufacturer.toLowerCase().includes(this.match)
                    );
                });
            }
        }
    };
</script>
