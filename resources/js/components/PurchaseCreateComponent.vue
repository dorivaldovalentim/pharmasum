<template>
    <section>
 
        <div class="page-title">
            <span class="title">Compra</span>
            <div class="description">
                Realização de compras
            </div>
        </div>
        <div class="row">

            <div class="col-xs-6">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            <div class="title">Selecionar os produtos</div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="text-left col-sm-6"><input type="text" v-model="match" class="form-control" placeholder="Pesquisar"></div>
                        </div>
                        <table class="table table-striped" cellspacing="0" width="100%" v-show="match">
                            <thead>
                                <tr>
                                    <th>Produto</th>
                                    <th>Categoria</th>
                                    <th>Fabricante</th>
                                    <th>Detalhe</th>
                                    <th>C. de Barra</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <transition-group enter-active-class="animated fadeInUp" leave-active-class="animated fadeOutDown" tag="tbody" mode="out-in">

                                <tr v-for="product in productsFiltered" :key="product.id">
                                    <td>{{ product.product }}</td>
                                    <td>{{ product.category }}</td>
                                    <td>{{ product.manufacturer }}</td>
                                    <td>{{ product.details }}</td>
                                    <td>{{ product.barcode }}</td>
                                    <td>
                                        <a class="btn btn-sm btn-info" href="" @click.prevent="add(product)">Adicionar</a>
                                    </td>
                                </tr>
                            </transition-group>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-xs-6">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            <div class="title">Produtos selecionados</div>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>Produto</th>
                                    <th>Qtd</th>
                                    <th>P. da compra</th>
                                    <th>D. Exp</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody><tr v-for="(product, pos) in selecteds">
                                <td>{{ product.product }}</td>
                                <td><input type="number" class="form-control w-100" v-model="product.qtd"  @change="amountChange" /></td>
                                <td><input type="" class="form-control w-100" v-model="product.purchase_price" /></td>
                                <td><input type="date" class="form-control" v-model="product.expireDate" /></td>
                                <td>
                                    <a class="btn btn-sm btn-danger" href="" @click.prevent="remove(pos)"> Remover</a>
                                </td>
                            </tr>
                            </tbody>
                        </table>

                        <div class="form-group col-md-6" v-show="selecteds.length">
                            <label for="inputEmail4">Fornecedor</label>
                            <select class="form-control" v-model="provider_id" required>
                                <option v-for="provider in providers" v-bind:value="provider.id">{{provider.name}}</option>
                            </select>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div v-show="selecteds.length">
                            <div class="col-sm-8 mt-2">
                                <button class="btn btn-success btn-sm" @click="store">Registar Compra</button>
                            </div>
                        </div>
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
                    product: "",
                    category_id: "",
                    manufacturer_id: "",
                    details: "",
                    barcode: "",
                    expireDate: '',
                    id: ""
                },
                match: "",
                recieved: '',
                change: '',
                amount: 0,
                provider_id: '',
                date: '2019-01-09',
                products: [],
                providers: [],
                selecteds: [],
            };
        },

        methods: {
            get() {
                axios
                    .get("../api/products")
                    .then(response => {
                        this.products = response.data.products
                        this.providers = response.data.providers
                    })
                    .catch(error => console.log(error));
            },

            store() {
                
                axios.post("../api/purchase/store", { user_id: this.user_id, amount: this.amount, provider_id: this.provider_id, date: this.date, products: this.selecteds})
                    .then(response => {
                        console.log(response)
                        if(response.data.success){    
                            swal("", response.data.message, "success")
                            this.get();
                            this.match = ""
                            this.recieved = ''
                            this.amount = 0
                            this.selecteds = []
                        }   
                        else 
                            swal("", response.data.message, "error")
                    })
                    .catch(error => console.log(error));
            },

            add(prod) {
                let product = { 
                    product: prod.product, 
                    category: prod.category, 
                    manufacturer: prod.manufacturer, 
                    product_id: prod.id, 
                    qtd: 1, 
                    price: prod.price,
                    details: prod.details,
                    barcode: prod.barcode,
                    purchase_price: 0
                }

                this.selecteds.push(product)
                this.amountChange();
            },

            remove(pos) {
                this.amount -= this.selecteds[pos].price * this.selecteds[pos].qtd
                this.selecteds.pop(pos)
            },

            destroy(id) {
                swal("", "Tem certeza que deseja apagar esta venda?", "warning", {buttons: true, dangerMode: true}).then(result => {
                    if(result)
                        axios.delete("../api/product/destroy/" + id)
                            .then(response => {
                                if (response.data.success) {
                                    this.get()
                                    alert("Produto apagado com sucesso!");
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
                })
            },

            update(id) {
                axios.put("../api/product/update/" + id, this.data)
                    .then(response => {
                        if (response.data.success) {
                            this.resetData();
                            this.get();
                            alert("Produto actualizado com sucesso!");
                            return true;
                        }
                        alert("Erro ao actualizar o produto!");
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
            },
            
            amountChange(){

                let amount = 0;

                this.selecteds.forEach(element => {
                    amount += element.price * element.qtd
                });

                this.amount = amount
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
            },

            changeComputed(){
                if(this.recieved)
                    if(this.recieved >= this.amount)
                        return this.change = this.recieved - this.amount
                    else
                        return 'Faltam ' + (this.amount - this.recieved * 1) + ' Kz'
                
            },

        }
    };
</script>
<style lang="">
    .w-100{ max-width: 100px; margin: 0 auto; }
</style>
