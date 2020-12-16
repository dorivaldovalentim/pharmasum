<template>
    <section>
        <form>
            <!-- Modal -->
            <div class="modal fade modal-success" id="edit-profile" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <h4 class="modal-title" id="myModalLabel">Actualizar Dados</h4>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="form-group col-md-7">
                                    <label for="inputEmail4">Username</label>
                                    <input type="text" class="form-control" v-model="data.username" placeholder="exemplo: jefthvalentim" required />
                                </div>

                                <div class="form-group col-sm-7">
                                    <label for="inputEmail4">Telefone</label>
                                    <input type="text" class="form-control" v-model="data.phone" placeholder="exemplo: 913299172" required />
                                </div>

                                <div class="form-group col-md-7">
                                    <label for="inputEmail4" >Endereço Residencial</label>
                                    <input type="text" class="form-control" v-model="data.address" placeholder="exemplo: Luanda, Ngola Kiluanje" required />
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <a data-dismiss="modal" class="btn" data-toggle="modal" data-target="#edit-password" >Actualizar Senha</a>
                            <button type="button" class="btn btn-default" data-dismiss="modal" >
                                Cancelar
                            </button>
                            <button type="button" class="btn btn-success" data-dismiss="modal" @click="update">
                                Actualizar Perfil
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <form>
            <!-- Modal -->
            <div class="modal fade modal-success" id="edit-password" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <h4 class="modal-title" id="myModalLabel">Actualizar Senha</h4>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="form-group col-md-7">
                                    <label for="inputEmail4">Senha Antiga</label>
                                    <input type="password" class="form-control" v-model="password.old_password" placeholder="*****" required />
                                </div>
                                <div class="form-group col-md-5" v-if="password.password != password.confirm_password">
                                    <p class="text-error">As senha não batem certo</p>
                                </div>

                                <div class="form-group col-sm-7">
                                    <label for="inputEmail4">Nova Senha</label>
                                    <input type="password" class="form-control" :class="{'form-error': password.password != password.confirm_password}" v-model="password.password" placeholder="*****" required />
                                </div>

                                <div class="form-group col-md-7">
                                    <label>Confirmar Senha</label>
                                    <input type="password" class="form-control" :class="{'form-error': password.password != password.confirm_password}" v-model="password.confirm_password" placeholder="*****" required />
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">
                                Cancelar
                            </button>
                            <button type="button" class="btn btn-success" :class="{disabled: password.password != password.confirm_password}" data-dismiss="modal" @click="updatePassword">
                                Actualizar Senha
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

        props: ['user_id'],

        mounted() {
            this.get();
        },

        data() {
            return {
                data: {},
                password: {password: '', old_password: '', confirm_password: ''},
            };
        },

        methods: {
            get() {
                
                axios
                    .get("../api/profile/" + this.user_id)
                    .then(response => {
                        if(response.data.success)
                            this.data = response.data.data
                        else
                            swal("", "Erro ao pegar os dados do utilizador!", "error");
                    })
                    .catch(error => console.log(error));
            },

            update() {
                axios
                    .put("../api/profile/update/" + this.user_id, this.data)
                    .then(response => {
                        if (response.data.success) {
                            swal("", response.data.message, "success");
                            return true;
                        }
                        swal("", "Erro ao actualizar os dados do perfil!", "error");
                    })
                    .catch(error => console.log(error));
            },

            updatePassword() {
                axios
                    .put("../api/profile/update-password/" + this.user_id, this.password)
                    .then(response => {
                        if (response.data.success) {
                            swal("", response.data.message, "success");
                            return true;
                        }
                        swal("", "Erro ao actualizar a senha!", "error");
                    })
                    .catch(error => console.log(error));
            }
        }
    };
</script>

<style>
    .form-error, .form-error:focus{
        border: 1px solid red;
    }
    .text-error{
        color: red;
    }
</style>