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
                                    <th>Data Expiração</th>
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
                                    <td>{{ product.qtd ? product.qtd : '0' }}</td>
                                    <td>{{ product.expire_date }}</td>
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
