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
                            <div class="text-left col-sm-3">
                                <input type="text" v-model="match" class="form-control" placeholder="Pesquisar" @keyup="salesList = salesFiltered" />
                            </div>
                            <div class="text-right col-sm-3">
                                <input type="date" class="form-control" v-model="match" @change="salesList = salesFiltered" />
                            </div>
                            <div class="text-right col-sm-3">
                                <input type="date" class="form-control" v-model="to" @change="salesList = dateInterval" />
                            </div>
                        </div>
                        <table class="table table-striped" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>Factura</th>
                                    <th>Valor Total</th>
                                    <th>Recebido</th>
                                    <th>Troco</th>
                                    <th>Funcionário</th>
                                    <th>Data da venda</th>
                                    <th>Acções</th>
                                </tr>
                            </thead>
                            <transition-group enter-active-class="animated fadeInUp" leave-active-class="animated fadeOutDown" tag="tbody" mode="out-in">

                                <tr v-for="sale in salesFiltered" :key="sale.id">
                                    <td>{{ sale.id }}</td>
                                    <td>{{ sale.amount }}</td>
                                    <td>{{ sale.amount_recieved }}</td>
                                    <td>{{ sale.amount_change }}</td>
                                    <td>{{ sale.first_name }} {{ sale.last_name }}</td>
                                    <td>{{ sale.created_at }}</td>
                                    <td>
                                        <a class="btn btn-sm btn-success" href="" @click="show(sale.id)" data-toggle="modal" data-target="#modalSuccess">Ver</a>
                                        <a class="btn btn-sm btn-danger" href="" @click.prevent="destroy(sale.id)" >Apagar</a>
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
                                    <div>Preço: {{product.sale_price}}</div>
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
                to: "",
                sales: [],
                products: [],
            };
        },

        methods: {
            get() {
                axios
                    .get("../api/sales")
                    .then(response => {
                        this.sales = response.data.sales
                    })
                    .catch(error => console.log(error));
            },

            add() {
                axios.post("../api/product/store", this.data)
                    .then(response => {
                        if (response.data.success) {
                            swal("", response.data.success, "success")
                            this.get();
                        }
                    })
                    .catch(error => console.log(error));
            },

            destroy(id) {
                swal("", "Tem certeza que deseja apagar esta venda?", "warning", {buttons: true, dangerMode: true}).then(result => {
                    if(result)
                        axios.delete("../api/sale/destroy/" + id)
                            .then(response => {
                                if (response.data.success) {
                                    this.get()
                                    swal("", response.data.message, "success")
                                }
                            })
                        .catch(error => console.log(error));
                })
            },

            show(id) {
                axios.get("../api/sale/show/" + id).then(response => {
                    this.products = response.data.products;
                }).catch(error => console.log(error))
            },

        },

        computed: {
            salesFiltered() {
                return this.sales.filter(sale => {
                    return (
                        sale.first_name.toLowerCase().includes(this.match) ||
                        sale.last_name.toLowerCase().includes(this.match) ||
                        sale.amount.toLowerCase().includes(this.match) ||
                        sale.amount_recieved.toLowerCase().includes(this.match) ||
                        sale.amount_change.toLowerCase().includes(this.match)  ||
                        sale.created_at.toString().includes(this.match) 
                    )
                });
            },
            
            dateInterval() { 
                return this.sales.filter(sale => {
                    return sale.created_at.toString() >= this.match && sale.created_at.toString() <= this.to;
                });
            }
        }
    };
</script>
