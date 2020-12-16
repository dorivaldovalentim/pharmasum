<template>
    <section>
 
        <div class="page-title">
            <span class="title">Vendas</span>
            <div class="description">
                Listagem das vendas efectuadas
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            <div class="title">Vendas</div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="text-left col-sm-3"><input type="text" v-model="match" class="form-control" placeholder="Pesquisar"></div>
                            <div class="text-right col-sm-3">
                                <input type="date" class="form-control" v-model="date" />
                            </div>
                        </div>
                        <table class="table table-striped" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>Compra nº</th>
                                    <th>Valor Total</th>
                                    <th>Fornecedor</th>
                                    <th>Data da compra</th>
                                    <th>Acções</th>
                                </tr>
                            </thead>
                            <transition-group enter-active-class="animated fadeInUp" leave-active-class="animated fadeOutDown" tag="tbody" mode="out-in">

                                <tr v-for="purchase in purchasesFiltered" :key="purchase.id">
                                    <td>{{ purchase.id }}</td>
                                    <td>{{ purchase.amount }}</td>
                                    <td>{{ purchase.name }}</td>
                                    <td>{{ purchase.date }}</td>
                                    <td>
                                        <a class="btn btn-sm btn-success" href="" @click="show(purchase.id)" data-toggle="modal" data-target="#modalSuccess">Ver</a>
                                        <a class="btn btn-sm btn-danger" href="" @click.prevent="destroy(purchase.id)" >Apagar</a>
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
                        <h4 class="modal-title" id="myModalLabel">Produtos da venda</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                        
                            <div class="col-sm-6" v-for="product in products">
                                <div class="alert alert-info">
                                    <div>Produto: {{product.product}}</div>
                                    <div>Detalhes: {{product.details}}</div>
                                    <div>Preço: {{product.purchase_price}}</div>
                                    <div>Quantidade: {{product.qtd}}</div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>                        
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
    export default {

        props: ['user_id'],

        mounted() {
            this.get();
        },

        data() {
            return {
                data: {
                    
                },
                match: "",
                date: "",
                purchases: [],
                products: [],
            };
        },

        methods: {
            get() {
                axios
                    .get("../api/purchases")
                    .then(response => {
                        console.log(response.data)
                        this.purchases = response.data.purchases
                    })
                    .catch(error => console.log(error));
            },

            show(id) {
                axios.get("../api/purchase/show/" + id).then(response => {
                    this.products = response.data.products;
                }).catch(error => console.log(error))
            },

        },

        computed: {
            purchasesFiltered() {
                return this.purchases.filter(purchase => {
                    return (
                        purchase.name.toLowerCase().includes(this.match) ||
                        purchase.date.toLowerCase().includes(this.match) ||
                        purchase.amount.toLowerCase().includes(this.match) 
                    )
                });
            }
        }
    };
</script>
